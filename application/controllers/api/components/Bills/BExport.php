<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . "/third_party/PHPExcel/Classes/PHPExcel.php";
require_once APPPATH . "/third_party/PHPExcel/Classes/PHPExcel/Style/Border.php";
require_once APPPATH . "/third_party/PHPExcel/Classes/PHPExcel/Style/Fill.php";

class BExport
{
    protected $CI;
    protected $appSrc;

    public function __construct($command, $params)
    {
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model([
            'general',
            'mhospital'
        ]);
        $this->CI->load->library([
            // 'excel',
            'form_validation'
        ]);

        $this->_command = $command;
        $this->_params = $params;
    }

    public function _export_bills(&$responseObj, &$responsecode, &$responseMessage)
    {
        // header('Content-Type: application/json');
        $bills = $this->_params["bills"];
        $patient  = $bills["patient"];
        $jkk  = $bills["jkk_date"];
        $this_day = time();
        $fname    = str_replace(" ", "_", strtoupper($patient["name"])) . "_" . $this_day . ".xls";

        // activate worksheet number 1
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // name the worksheet
        $sheet->setTitle(strtoupper($patient['name']));
        foreach(range('A','Z') as $columnID) {
            $sheet->getColumnDimension($columnID)->setWidth(14, 'pt');
        }
        $sheet->getDefaultStyle()->getFont()->setSize(10);
        
        // set cell A1 content with some text
        $sheet->setCellValue('A1', 'NAMA :')->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('B1', strtoupper($patient["name"]));
        $sheet->mergeCells('B1:C1');

        $sheet->setCellValue('A2', 'KPJ :')->getStyle('A2')->getFont()->setBold(true);
        $sheet->setCellValue('B2', $patient["kpj"]);
        $sheet->mergeCells('B2:C2');
        
        $sheet->setCellValue('A3', 'PERUSAHAAN :')->getStyle('A3')->getFont()->setBold(true);
        $sheet->setCellValue('B3', $patient["company"]);
        $sheet->mergeCells('B3:C3');
        
        $sheet->setCellValue('A4', 'NPP :')->getStyle('A4')->getFont()->setBold(true);
        $sheet->setCellValue('B4', $patient["npp"]);
        $sheet->mergeCells('B4:C4');
        
        $sheet->setCellValue('A5', 'JENIS KELAMIN')->getStyle('A5')->getFont()->setBold(true);
        $sheet->setCellValue('B5', $bills["jenis_kelamin"]);

        $sheet->setCellValue('E1', 'TGL JKK :')->getStyle('E1')->getFont()->setBold(true);
        $sheet->setCellValue('F1', date("d/m/Y", strtotime($jkk)));

        $sheet->setCellValue('E2', 'WAKTU JKK :')->getStyle('E2')->getFont()->setBold(true);
        $sheet->setCellValue('F2', date("H:i", strtotime($jkk)) . " WIB");

        $sheet->setCellValue('E3', 'TGL BEROBAT :')->getStyle('E3')->getFont()->setBold(true);
        $sheet->setCellValue('F3', date("d/m/Y", strtotime($bills["treatment_date"])));

        $sheet->setCellValue('E4', 'LOKASI :')->getStyle('E4')->getFont()->setBold(true);
        $sheet->setCellValue('F4', $bills["lokasi"]);

        $sheet->setCellValue('E5', 'KONDISI AKHIR :')->getStyle('E5')->getFont()->setBold(true);
        $sheet->setCellValue('F5', $bills["last_condition"]);

        $billStmb = json_decode($bills["stmb"]);
        $sheet->setCellValue('I1', 'STMB');
        $sheet->setCellValue('L1', 'HARI');

        if (!empty($billStmb) && !empty($billStmb[0])) {
            $stmbTotalDay = 0;
            foreach ($billStmb as $key => $stmb) {
                $stmbDate = explode(" - ", $stmb);
                $daysCount = (!empty($stmb) ? intval((abs(strtotime($stmbDate[1]) - strtotime($stmbDate[0])) / 86400) + 1) : 0);
                $sheet->setCellValue('I' . ($key + 2), (!empty($stmb) ? strtoupper(date("d M Y", strtotime($stmbDate[0]))) . " - " . strtoupper(date("d M Y", strtotime($stmbDate[1]))) : "-"));
                $sheet->setCellValue('K' . ($key + 2), $daysCount);
                $sheet->mergeCells('I'.($key + 2).':J'.($key + 2));
                $sheet->getStyle('K' . ($key + 2))->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('L' . ($key + 2), "HARI");
                $sheet->getStyle('I'.($key + 2).':L'.($key + 2))->getFont()->setSize(8);
                $stmbTotalDay += $daysCount;
            }
        }
        $sheet->setCellValue('K1', $stmbTotalDay);
        $sheet->getStyle('K1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B2')->getFill()->getStartColor()->setARGB('FFFF0000');

        $sheet->setCellValue('A7', 'RANAP');
        $sheet->setCellValue('C7', date("d/m/Y", strtotime($bills["ranap_date_start"])) . " - " . date("d/m/Y", strtotime($bills["ranap_date_last"])));
        $sheet->setCellValue('A8', 'RAJAL TERAKHIR');
        $sheet->setCellValue('C8', ($bills["last_rajal"] == "0000-00-00") ? "-" : date("d/m/Y", strtotime($bills["last_rajal"])));
        $sheet->setCellValue('A9', 'DIAGNOSA');
        $sheet->setCellValue('C9', strtoupper($bills["diagnose"]));
        $sheet->setCellValue('A10', 'DX SEKUNDER');
        $sheet->setCellValue('C10', strtoupper($bills["dx_sekunder"]));
        $sheet->setCellValue('A11', 'TINDAKAN');
        $sheet->setCellValue('C11', strtoupper($bills["action"]));

        $style = [];
        $styleAlignCenter = [
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center'
            ]
        ];
        $styleBorders = [
            'borders' => [
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ],
            ]
        ];
        $styleFill = [
            'fill' => [
                'fillType' => PHPExcel_Style_Fill::FILL_SOLID
            ]
        ];
        $styleFontBold = [
            'font' => [
                'bold' => true
            ],
        ];

        $sheet->getStyle('A7:B11')->applyFromArray(array_merge($style, $styleAlignCenter, $styleBorders, $styleFontBold));
        $sheet->getStyle('C7:F11')->applyFromArray(array_merge($style, $styleBorders));

        $sheet->mergeCells('A7:B7');
        $sheet->mergeCells('A8:B8');
        $sheet->mergeCells('A9:B9');
        $sheet->mergeCells('A10:B10');
        $sheet->mergeCells('A11:B11');
        $sheet->mergeCells('C7:F7');
        $sheet->mergeCells('C8:F8');
        $sheet->mergeCells('C9:F9');
        $sheet->mergeCells('C10:F10');
        $sheet->mergeCells('C11:F11');

        $sheet->setCellValue('A16', 'YANKES');
        $sheet->setCellValue('B16', 'KAMAR');
        $sheet->setCellValue('C16', 'ADM');
        $sheet->setCellValue('D16', 'OBAT');
        $sheet->setCellValue('E16', 'DOKTER');
        $sheet->setCellValue('F16', 'LAB');
        $sheet->setCellValue('G16', 'RO');
        $sheet->setCellValue('H16', 'AMBULANCE');
        $sheet->setCellValue('I16', 'REHAB');
        $sheet->setCellValue('J16', 'SUB TOTAL ACC');

        $sheet->getStyle('A16:J16')->applyFromArray(array_merge($style, $styleAlignCenter, $styleBorders, $styleFontBold, $styleFill));
        $sheet->getRowDimension('16')->setRowHeight(22);

        $detail = [];
        $kamar = [];
        $icu = [];
        if (isset($bills["detail"])) {
            if (isset($bills["detail"]["room"]) && !is_null($bills["detail"]["room"])) {
                foreach ($bills["detail"]["room"] as $room) {
                    if (strtoupper($room['value']) == "ICU" || strtoupper($room['value']) == "HDU") {
                        $icu[strtoupper($room['value'])] = [
                            "qty" => $room["qty"],
                            "total" => $room["total"]
                        ];
                    } else {
                        $kamar[] = [
                            "qty" => $room["qty"],
                            "total" => $room["total"]
                        ];
                    }
                }
            }

            $detail["room"][] = (isset($bills["detail"]["room"]) && !is_null($bills["detail"]["room"])) ? array_sum(array_column($bills["detail"]["room"], "total")) : 0;
            $detail["admin"][] = (isset($bills["detail"]["admin"]) && !is_null($bills["detail"]["admin"])) ? array_sum(array_column($bills["detail"]["admin"], "total")) : 0;
            $detail["medicine"][] = (isset($bills["detail"]["medicine"]) && !is_null($bills["detail"]["medicine"])) ? array_sum(array_column($bills["detail"]["medicine"], "total")) : 0;

            $subTotalDocter = (isset($bills["detail"]["docter"]) && !is_null($bills["detail"]["docter"])) ? array_sum(array_column($bills["detail"]["docter"], "total")) : 0;
            if (isset($bills["detail"]["docter"]) && !is_null($bills["detail"]["docter"])) {
                foreach ($bills["detail"]["docter"] as $docter) {
                    if (isset($docter["children"]) && !is_null($docter["children"]))
                        $subTotalDocter += (isset($docter["children"]) && !is_null($docter["children"])) ? array_sum(array_column($docter["children"], "total")) : 0;
                }
            }
            $detail["docter"][] = $subTotalDocter;

            $subTotalSurgery = (isset($bills["detail"]["surgery"]) && !is_null($bills["detail"]["surgery"])) ? array_sum(array_column($bills["detail"]["surgery"], "total")) : 0;
            if (isset($bills["detail"]["surgery"]) && !is_null($bills["detail"]["surgery"])) {
                foreach ($bills["detail"]["surgery"] as $surgery) {
                    if (isset($surgery["children"]) && !is_null($surgery["children"]))
                        $subTotalSurgery += (isset($surgery["children"]) && !is_null($surgery["children"])) ? array_sum(array_column($surgery["children"], "total")) : 0;
                }
            }
            $detail["docter"][] = $subTotalSurgery;

            $detail["docter"][] = (isset($bills["detail"]["surgery_nurse"]) && !is_null($bills["detail"]["surgery_nurse"])) ? array_sum(array_column($bills["detail"]["surgery_nurse"], "total")) : 0;
            $detail["docter"][] = (isset($bills["detail"]["room_nurse"]) && !is_null($bills["detail"]["room_nurse"])) ? array_sum(array_column($bills["detail"]["room_nurse"], "total")) : 0;
            $subTotalAnestesi = (isset($bills["detail"]["anestesi"]) && !is_null($bills["detail"]["anestesi"])) ? array_sum(array_column($bills["detail"]["anestesi"], "total")) : 0;
            if (isset($bills["detail"]["anestesi"]) && !is_null($bills["detail"]["anestesi"])) {
                foreach ($bills["detail"]["anestesi"] as $anestesi) {
                    if (isset($anestesi["children"]) && !is_null($anestesi["children"]))
                        $subTotalAnestesi += (isset($anestesi["children"]) && !is_null($anestesi["children"])) ? array_sum(array_column($anestesi["children"], "total")) : 0;
                }
            }
            $detail["docter"][] = $subTotalAnestesi;
            $detail["docter"][] = (isset($bills["detail"]["medic"]) && !is_null($bills["detail"]["medic"])) ? array_sum(array_column($bills["detail"]["medic"], "total")) : 0;

            $detail["lab"][] = (isset($bills["detail"]["lab"]) && !is_null($bills["detail"]["lab"])) ? array_sum(array_column($bills["detail"]["lab"], "total")) : 0;
            $detail["radiology"][] = (isset($bills["detail"]["radiology"]) && !is_null($bills["detail"]["radiology"])) ? array_sum(array_column($bills["detail"]["radiology"], "total")) : 0;
            $detail["rehab"][] = (isset($bills["detail"]["rehab"]) && !is_null($bills["detail"]["rehab"])) ? array_sum(array_column($bills["detail"]["rehab"], "total")) : 0;
            $detail["ambulance"][] = (isset($bills["detail"]["ambulance"]) && !is_null($bills["detail"]["ambulance"])) ? array_sum(array_column($bills["detail"]["ambulance"], "total")) : 0;
        }

        $kamarLetter = "A";
        $icuLetter = "C";
        $sheet->setCellValue('A14', 'SEWA KAMAR');

        foreach ($kamar as $kam) {
            $sheet->setCellValue($kamarLetter . '15', $kam["qty"]."x".number_format($kam["total"], 0, ",", "."));
        }
        $sheet->setCellValue('C14', 'ICU / HDU');
        foreach ($icu as $ic) {
            $sheet->setCellValue($icuLetter . '15', $ic["qty"]."x".number_format($ic["total"], 0, ",", "."));
            $icuLetter++;
        }
        $sheet->setCellValue('E14', 'COB JASA RAHARJA');
        $sheet->setCellValue('E15', number_format($bills["cob"], 0, ",", "."));
        $sheet->getStyle('A14:J15')->getFont()->setSize(8);
        $sheet->getStyle('A14:J15')->applyFromArray(array_merge([
            'alignment' => [
                'horizontal' => 'center'
            ]
        ]));

        $sheet->getRowDimension('17')->setRowHeight(22);
        $jenisYankes = (($bills['yankes'] == "Rawat Inap") ? "RANAP" : "RAJAL");
        $sheet->setCellValue('A17', $jenisYankes);

        $xDocter = count($detail["docter"]);
        $lastRowDetail = 17;
        $firstRowDetail = 17;
        $subTotalDetailDocter = 0;

        $detailRoom = $detail["room"];
        $detailAdmin = $detail["admin"];
        $detailMedicine = $detail["medicine"];
        $detailLab = $detail["lab"];
        $detailRadiology = $detail["radiology"];
        $detailAmbulance = $detail["ambulance"];
        $detailRehab = $detail["rehab"];
        $subTotalDetail = [];
        $subRowTotalDetail = [];

        foreach ($detail["docter"] as $key => $detailDocter) {
            $sheet->getRowDimension($lastRowDetail)->setRowHeight(22);
            $sheet->setCellValue('E'.$lastRowDetail, $detailDocter);
            $subTotalDetailDocter += $detailDocter;
            $subTotalDetail[] = $detailDocter;
            $subRowTotalDetail[$key][] = $detailDocter;

            $lastRowDetail++;
        }

        for ($xRoom = 0 ; $xRoom < $xDocter ; $xRoom++) {
            if (isset($detailRoom[$xRoom])) {
                $sheet->setCellValue('B' . $firstRowDetail, $detailRoom[$xRoom]);
                $subTotalDetail[] = $detailRoom[$xRoom];
                $subRowTotalDetail[$xRoom][] = $detailRoom[$xRoom];
            } else {
                $sheet->setCellValue('B' . ($firstRowDetail + $xRoom), "-");
            }
        }

        for ($xAdmin = 0 ; $xAdmin < $xDocter ; $xAdmin++) {
            if (isset($detailAdmin[$xAdmin])) {
                $sheet->setCellValue('C' . $firstRowDetail, $detailAdmin[$xAdmin]);
                $subTotalDetail[] = $detailAdmin[$xAdmin];
                $subRowTotalDetail[$xAdmin][] = $detailAdmin[$xAdmin];
            } else {
                $sheet->setCellValue('C' . ($firstRowDetail + $xAdmin), "-");
            }
        }

        for ($xMedicine = 0 ; $xMedicine < $xDocter ; $xMedicine++) {
            if (isset($detailMedicine[$xMedicine])) {
                $sheet->setCellValue('D' . $firstRowDetail, $detailMedicine[$xMedicine]);
                $subTotalDetail[] = $detailMedicine[$xMedicine];
                $subRowTotalDetail[$xMedicine][] = $detailMedicine[$xMedicine];
            } else {
                $sheet->setCellValue('D' . ($firstRowDetail + $xMedicine), "-");
            }
        }

        for ($xLab = 0 ; $xLab < $xDocter ; $xLab++) {
            if (isset($detailLab[$xLab])) {
                $sheet->setCellValue('F' . $firstRowDetail, $detailLab[$xLab]);
                $subTotalDetail[] = $detailLab[$xLab];
                $subRowTotalDetail[$xLab][] = $detailLab[$xLab];
            } else {
                $sheet->setCellValue('F' . ($firstRowDetail + $xLab), "-");
            }
        }

        for ($xRadiology = 0 ; $xRadiology < $xDocter ; $xRadiology++) {
            if (isset($detailRadiology[$xRadiology])) {
                $sheet->setCellValue('G' . $firstRowDetail, $detailRadiology[$xRadiology]);
                $subTotalDetail[] = $detailRadiology[$xRadiology];
                $subRowTotalDetail[$xRadiology][] = $detailRadiology[$xRadiology];
            } else {
                $sheet->setCellValue('G' . ($firstRowDetail + $xRadiology), "-");
            }
        }

        for ($xAmbulance = 0 ; $xAmbulance < $xDocter ; $xAmbulance++) {
            if (isset($detailAmbulance[$xAmbulance])) {
                $sheet->setCellValue('H' . $firstRowDetail, $detailAmbulance[$xAmbulance]);
                $subTotalDetail[] = $detailAmbulance[$xAmbulance];
                $subRowTotalDetail[$xAmbulance][] = $detailAmbulance[$xAmbulance];
            } else {
                $sheet->setCellValue('H' . ($firstRowDetail + $xAmbulance), "-");
            }
        }

        for ($xRehab = 0 ; $xRehab < $xDocter ; $xRehab++) {
            if (isset($detailRehab[$xRehab])) {
                $sheet->setCellValue('I' . $firstRowDetail, $detailRehab[$xRehab]);
                $subTotalDetail[] = $detailRehab[$xRehab];
                $subRowTotalDetail[$xRehab][] = $detailRehab[$xRehab];
            } else {
                $sheet->setCellValue('I' . ($firstRowDetail + $xRehab), "-");
            }
        }

        for ($xSubTotal = 0 ; $xSubTotal < $xDocter ; $xSubTotal++) {
            $sheet->setCellValue('J' . ($firstRowDetail + $xSubTotal), array_sum($subRowTotalDetail[$xSubTotal]));
        }

        // $sheet->setCellValue('B17', $detail['room']);
        // $sheet->setCellValue('C17', $detail['admin']);
        // $sheet->setCellValue('D17', $detail['medicine']);
    
        // $sheet->setCellValue('F17', $detail['lab']);
        // $sheet->setCellValue('G17', $detail['radiology']);
        // $sheet->setCellValue('H17', $detail['ambulance']);
        // $sheet->setCellValue('I17', $detail['rehab']);
        // $sheet->setCellValue('J17', array_sum($detail));

        $sheet->getStyle('A'.$lastRowDetail.':J'.$lastRowDetail)->applyFromArray(array_merge($style, $styleAlignCenter, $styleBorders, $styleFontBold, $styleFill));
        $sheet->setCellValue('A'.$lastRowDetail, 'TOTAL ' . $jenisYankes);
        $sheet->setCellValue('B'.$lastRowDetail, array_sum($detail['room']));
        $sheet->setCellValue('C'.$lastRowDetail, array_sum($detail['admin']));
        $sheet->setCellValue('D'.$lastRowDetail, array_sum($detail['medicine']));
        $sheet->setCellValue('E'.$lastRowDetail, $subTotalDetailDocter);
        $sheet->setCellValue('F'.$lastRowDetail, array_sum($detail['lab']));
        $sheet->setCellValue('G'.$lastRowDetail, array_sum($detail['radiology']));
        $sheet->setCellValue('H'.$lastRowDetail, array_sum($detail['ambulance']));
        $sheet->setCellValue('I'.$lastRowDetail, array_sum($detail['rehab']));
        $sheet->setCellValue('J'.$lastRowDetail, array_sum($subTotalDetail));
        $sheet->getRowDimension($lastRowDetail)->setRowHeight(22);
        $sheet->mergeCells('A17:A'.($lastRowDetail-1));

        $sheet->getStyle('A17:J'.$lastRowDetail)->applyFromArray(array_merge($style, $styleAlignCenter, $styleBorders, $styleFill));

        $cob = intval($bills["cob"]);
        $acc = intval($bills["subtotal"]);
        $bayar = intval($bills["total_bayar"]);
        $selisih = $acc - $bayar - $cob;

        $sheet->setCellValue('A' . ($lastRowDetail+3), "TOTAL PENGAJUAN");
        $sheet->mergeCells('A'. ($lastRowDetail+3) . ':B'. ($lastRowDetail+3));

        $sheet->setCellValue('A' . ($lastRowDetail+4), "TOTAL ACC");
        $sheet->mergeCells('A'. ($lastRowDetail+4) . ':B'. ($lastRowDetail+4));

        $sheet->setCellValue('F' . ($lastRowDetail+3), "TOTAL SELISIH");
        $sheet->mergeCells('F'. ($lastRowDetail+3) . ':G'. ($lastRowDetail+3));

        $sheet->setCellValue('C' . ($lastRowDetail+3), $jenisYankes . ' TOTAL');
        $sheet->mergeCells('C'. ($lastRowDetail+3) . ':D'. ($lastRowDetail+3));

        $sheet->setCellValue('C' . ($lastRowDetail+4), $jenisYankes . ' TOTAL');
        $sheet->mergeCells('C'. ($lastRowDetail+4) . ':D'. ($lastRowDetail+4));

        $sheet->setCellValue('H' . ($lastRowDetail+3), $jenisYankes . ' TOTAL');
        $sheet->mergeCells('H'. ($lastRowDetail+3) . ':I'. ($lastRowDetail+3));

        $sheet->setCellValue('E' . ($lastRowDetail+3), $bayar);
        $sheet->setCellValue('E' . ($lastRowDetail+4), $acc);
        $sheet->setCellValue('J' . ($lastRowDetail+3), $selisih);

        $sheet->getStyle('A' . ($lastRowDetail+3) . ':E' . ($lastRowDetail+4))->applyFromArray(array_merge($style, $styleAlignCenter, $styleBorders, $styleFill));
        $sheet->getStyle('F' . ($lastRowDetail+3) . ':J' . ($lastRowDetail+3))->applyFromArray(array_merge($style, $styleAlignCenter, $styleBorders, $styleFill));
        $sheet->getStyle('A' . ($lastRowDetail+4))->applyFromArray(array_merge($style, $styleFontBold));
        $sheet->getStyle('E' . ($lastRowDetail+4))->applyFromArray(array_merge($style, $styleFontBold));
        $sheet->getStyle('F' . ($lastRowDetail+3))->applyFromArray(array_merge($style, $styleFontBold));
        $sheet->getStyle('J' . ($lastRowDetail+3))->applyFromArray(array_merge($style, $styleFontBold));
        
        $sheet->getRowDimension(($lastRowDetail+3))->setRowHeight(22);
        $sheet->getRowDimension(($lastRowDetail+4))->setRowHeight(22);

        $sheet->setCellValue('G' . ($lastRowDetail+5), 'KETERANGAN / HASIL VERIFIKASI:');
        $sheet->setCellValue('G' . ($lastRowDetail+6), $bills["verification"]);
        $sheet->mergeCells('G'. ($lastRowDetail+5) . ':J'. ($lastRowDetail+5));
        $sheet->mergeCells('G'. ($lastRowDetail+6) . ':J'. ($lastRowDetail+6));
        $sheet->mergeCells('G'. ($lastRowDetail+7) . ':J'. ($lastRowDetail+7));
        $sheet->mergeCells('G'. ($lastRowDetail+8) . ':J'. ($lastRowDetail+8));

        $sheet->getStyle('G' . ($lastRowDetail+5) . ':J' . ($lastRowDetail+5))->applyFromArray([
            'borders' => [
                'top' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ],
            ]
        ]);
        $sheet->getStyle('G' . ($lastRowDetail+5) . ':G' . ($lastRowDetail+8))->applyFromArray([
            'borders' => [
                'left' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ],
            ]
        ]);
        $sheet->getStyle('J' . ($lastRowDetail+5) . ':J' . ($lastRowDetail+8))->applyFromArray([
            'borders' => [
                'right' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ],
            ]
        ]);
        $sheet->getStyle('G' . ($lastRowDetail+8) . ':J' . ($lastRowDetail+8))->applyFromArray([
            'borders' => [
                'bottom' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ],
            ]
        ]);
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save(FCPATH . '/files/' . $fname);
        $objPHPExcel->disconnectWorksheets();
        unset($objPHPExcel);

        $responseObj = [
            "name" => "Bills Export",
            "item" => $fname
        ];
    }

    public function action(&$responseObj, &$responsecode, &$responseMessage)
    {
        switch ($this->_command) {
            case 'bills':
                $this->_export_bills($responseObj, $responsecode, $responseMessage);
                break;
        }
    }
}
