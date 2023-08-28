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
        $styleAlign = [
            'horizontal' => [
                'right' => [
                    'alignment' => [
                        'horizontal' => 'right'
                    ]
                ]
                ],
            'vertical' => [
                'middle' => [
                    'alignment' => [
                        'vertical' => 'center'
                    ]
                ]
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
            'background' => [
                'grey' => [
                    'fill' => [
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'D9D9D9')
                    ]
                ],
                'darkgrey' => [
                    'fill' => [
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'BFBFBF')
                    ]
                ]
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

        $detailBills = [];
        if (isset($bills["detail"])) {
            foreach ($bills["detail"] as $yankes => $yankesData) {
                $detailBills[$yankes]["room"][] = (isset($yankesData["room"]) && !is_null($yankesData["room"])) ? array_sum(array_column($yankesData["room"], "total")) : 0;
                $detailBills[$yankes]["admin"][] = (isset($yankesData["admin"]) && !is_null($yankesData["admin"])) ? array_sum(array_column($yankesData["admin"], "total")) : 0;
                $detailBills[$yankes]["medicine"][] = (isset($yankesData["medicine"]) && !is_null($yankesData["medicine"])) ? array_sum(array_column($yankesData["medicine"], "total")) : 0;

                if (isset($yankesData["docter"]) && !is_null($yankesData["docter"])) {
                    $subTotalDocter = 0;
                    $subTotalDocter += array_sum(array_column($yankesData["docter"], "total"));
                    if (isset($yankesData["docter"])) {
                        foreach ($yankesData["docter"] as $docter) {
                            if (isset($docter["do"]) && !is_null($docter["do"]))
                                $subTotalDocter += (isset($docter["do"]) && !is_null($docter["do"])) ? array_sum(array_column($docter["do"], "total")) : 0;
                        }
                    }
                    $detailBills[$yankes]["docter"][] = $subTotalDocter;
                }
    
                if (isset($yankesData["surgery"]) && !is_null($yankesData["surgery"])) {
                    $subTotalSurgery = 0;
                    $subTotalSurgery += array_sum(array_column($yankesData["surgery"], "total"));
                    if (isset($yankesData["surgery"])) {
                        foreach ($yankesData["surgery"] as $surgery) {
                            if (isset($surgery["do"]) && !is_null($surgery["do"]))
                                $subTotalSurgery += (isset($surgery["do"]) && !is_null($surgery["do"])) ? array_sum(array_column($surgery["do"], "total")) : 0;
                        }
                    }
                    $detailBills[$yankes]["docter"][] = $subTotalSurgery;
                }

                if (isset($yankesData["surgery_nurse"]) && !is_null($yankesData["surgery_nurse"]))
                    $detailBills[$yankes]["docter"][] = array_sum(array_column($yankesData["surgery_nurse"], "total"));

                if (isset($yankesData["room_nurse"]) && !is_null($yankesData["room_nurse"]))
                    $detailBills[$yankes]["docter"][] = array_sum(array_column($yankesData["room_nurse"], "total"));

                if (isset($yankesData["anestesi"]) && !is_null($yankesData["anestesi"])) {
                    $subTotalAnestesi = 0;
                    $subTotalAnestesi += array_sum(array_column($yankesData["anestesi"], "total"));
                    if (isset($yankesData["anestesi"])) {
                        foreach ($yankesData["anestesi"] as $anestesi) {
                            if (isset($anestesi["do"]) && !is_null($anestesi["do"]))
                                $subTotalAnestesi += (isset($anestesi["do"]) && !is_null($anestesi["do"])) ? array_sum(array_column($anestesi["do"], "total")) : 0;
                        }
                    }
                    $detailBills[$yankes]["docter"][] = $subTotalAnestesi;
                }

                if (isset($yankesData["medic"]) && !is_null($yankesData["medic"]))
                    $detailBills[$yankes]["docter"][] = array_sum(array_column($yankesData["medic"], "total"));

                $detailBills[$yankes]["laboratory"][] = (isset($yankesData["laboratory"]) && !is_null($yankesData["laboratory"])) ? array_sum(array_column($yankesData["laboratory"], "total")) : 0;
                $detailBills[$yankes]["radiology"][] = (isset($yankesData["radiology"]) && !is_null($yankesData["radiology"])) ? array_sum(array_column($yankesData["radiology"], "total")) : 0;
                $detailBills[$yankes]["ambulance"][] = (isset($yankesData["ambulance"]) && !is_null($yankesData["ambulance"])) ? array_sum(array_column($yankesData["ambulance"], "total")) : 0;
                $detailBills[$yankes]["rehab"][] = (isset($yankesData["rehab"]) && !is_null($yankesData["rehab"])) ? array_sum(array_column($yankesData["rehab"], "total")) : 0;
            }
        }

        if (!empty($bills["detail"])) {
            foreach ($bills["detail"] as $yankes => $detailBill) {
                foreach ($detailBill as $kBill => $dBill) {
                    if ($kBill == "room") {
                        foreach ($dBill as $db) {
                            var_dump($db);
                            if (strtoupper($db['value']) == "ICU" || strtoupper($db['value']) == "HDU") {
                                $icu[strtoupper($db['value'])] = [
                                    "qty" => $db["qty"],
                                    "total" => $db["fare"]
                                ];
                            } else {
                                $kamar[] = [
                                    "qty" => $db["qty"],
                                    "total" => $db["fare"]
                                ];
                            }
                        }
                    }
                }
            }
        }

        $kamarLetter = "A";
        $icuLetter = "C";
        $sheet->setCellValue('A14', 'SEWA KAMAR');

        foreach ($kamar as $kam) {
            $sheet->setCellValue($kamarLetter . '15', $kam["qty"]."x".number_format($kam["total"], 0, ",", "."));
            $kamarLetter++;
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

        $firstRowDetail = 17;
        $nextRowDetail = 17;
        $lastRowDetail = 17;
        $firstSheetRow = 0;

        $columnDetail = [
            "room" => "B",
            "admin" => "C",
            "medicine" => "D",
            "docter" => "E",
            "laboratory" => "F",
            "radiology" => "G",
            "ambulance" => "H",
            "rehab" => "I",
            "total" => "J"
        ];

        
        $totalYankes = [];
        if (!empty($detailBills)) {
            $yankesRow = 17;
            $subTotal = [];
            foreach ($detailBills as $yankes => $dataBills) {
                $yankesData = [];
                $yankesSubtotal = 0;
                $countRow = [];
                foreach ($dataBills as $bill) {
                    $countRow[] = count($bill);
                }

                $sheet->setCellValue("A" . $yankesRow, strtoupper($yankes));
                $sheet->getStyle("A" . $yankesRow)->applyFromArray(array_merge($style, $styleAlignCenter, $styleFontBold));

                $maxCount = max($countRow);
                foreach ($dataBills as $type => $bill) {
                    $billRow = $yankesRow;
                    $billTotalRow = $yankesRow;
                    for ($i = 0 ; $i < $maxCount ; $i++) {
                        // var_dump($i);
                        $yankesData[$i][] = isset($bill[$i]) ? $bill[$i] : 0;
                        $sheet->setCellValue($columnDetail[$type].$billRow, (isset($bill[$i]) ? $bill[$i] : "-"));
                        $sheet->getStyle($columnDetail[$type].$billRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);
                        $sheet->getRowDimension($billRow)->setRowHeight(20);
                        // var_dump(isset($bill[$i]) ? $bill[$i] : "-");

                        $billRow++;
                    }

                    for ($i = 0 ; $i < $maxCount ; $i++) {
                        $sheet->setCellValue($columnDetail["total"].$billTotalRow, array_sum($yankesData[$i]));
                        $sheet->getStyle($columnDetail["total"].$billTotalRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);
                        $sheet->getStyle($columnDetail["total"].$billTotalRow)->applyFromArray(array_merge($style, $styleFill["background"]["darkgrey"]));
                        $sheet->getStyle($columnDetail["total"].$billTotalRow)->getFont()->setSize(11);
                        $billTotalRow++;
                    }

                    $sheet->setCellValue($columnDetail[$type].$billRow, array_sum($bill));
                    $sheet->getStyle($columnDetail[$type].$billRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);
                    $sheet->getStyle($columnDetail[$type].$billRow)->applyFromArray($styleFill["background"]["grey"]);
                    $yankesSubtotal += array_sum($bill);
                    $subTotal[$type][] = array_sum($bill);
                }
                
                $subTotal["total"][] = $yankesSubtotal;
                $sheet->setCellValue($columnDetail["total"].$billRow, $yankesSubtotal);
                $sheet->getStyle($columnDetail["total"].$billRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);
                $sheet->getStyle($columnDetail["total"].$billRow)->applyFromArray(array_merge($style, $styleFill["background"]["darkgrey"]));
                $sheet->getStyle($columnDetail["total"].$billRow)->getFont()->setSize(11);
                $sheet->setCellValue("A".$billRow, "TOTAL " . strtoupper($yankes));
                $sheet->getStyle("A".$billRow)->applyFromArray($styleFill["background"]["grey"]);
                $sheet->getRowDimension($billRow)->setRowHeight(20);
                $sheet->mergeCells("A".$yankesRow.':A'.($billTotalRow-1));
                $yankesRow += $maxCount + 1;

                $totalYankes[$yankes] = $yankesSubtotal;
            }

            foreach ($columnDetail as $key => $column) {
                $sheet->setCellValue($column.$yankesRow, array_sum($subTotal[$key]));
                $sheet->getStyle($column.$yankesRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);
                $sheet->getStyle($column.$yankesRow)->applyFromArray(array_merge($style, $styleFontBold, $styleFill["background"]["darkgrey"]));
                $sheet->getStyle($column.$yankesRow)->getFont()->setSize(11);
            }

            $sheet->setCellValue("A".$yankesRow, "TOTAL");
            $sheet->getStyle("A".$yankesRow)->applyFromArray(array_merge($style, $styleFontBold, $styleFill["background"]["darkgrey"]));
            $sheet->getStyle("A".$yankesRow)->getFont()->setSize(11);
            $sheet->getStyle('A17:J'.$yankesRow)->applyFromArray(array_merge($style, $styleBorders));
            $sheet->getStyle('B17:J'.$yankesRow)->applyFromArray(array_merge($style, $styleAlign["horizontal"]["right"]));
            $sheet->getRowDimension($yankesRow)->setRowHeight(20);
        }

        $sheet->getStyle('A17:J'.$yankesRow)->applyFromArray(array_merge($style, $styleAlign["vertical"]["middle"]));
        
        $newRow = $yankesRow + 3;

        $sheet->setCellValue('A' . $newRow, "TOTAL PENGAJUAN");
        $sheet->mergeCells('A'. $newRow . ':B'. ($newRow + 1));
        $sheet->setCellValue('A' . ($newRow + 2), "TOTAL ACC");
        $sheet->mergeCells('A'. ($newRow + 2) . ':B'. ($newRow + 3));
        $sheet->setCellValue('F' . $newRow, "TOTAL SELISIH");
        $sheet->mergeCells('F'. $newRow . ':G'. ($newRow + 1));
        $sheet->getStyle("A".$newRow.":B".($newRow+3))->applyFromArray($styleAlignCenter);
        $sheet->getStyle("A".($newRow+2).":B".($newRow+3))->applyFromArray($styleFontBold);
        $sheet->getStyle("F".$newRow.":G".($newRow+1))->applyFromArray(array_merge($style, $styleAlignCenter, $styleFontBold));

        $sheet->setCellValue('C' . $newRow, "RANAP TOTAL");
        $sheet->mergeCells('C'. $newRow . ':D'. $newRow);
        $sheet->setCellValue('C' . ($newRow + 1), "RAJAL TOTAL");
        $sheet->mergeCells('C'. ($newRow + 1) . ':D'. ($newRow + 1));
        $sheet->setCellValue('C' . ($newRow + 2), "RANAP TOTAL");
        $sheet->mergeCells('C'. ($newRow + 2) . ':D'. ($newRow + 2));
        $sheet->setCellValue('C' . ($newRow + 3), "RAJAL TOTAL");
        $sheet->mergeCells('C'. ($newRow + 3) . ':D'. ($newRow + 3));
        $sheet->setCellValue('H' . $newRow, "RANAP TOTAL");
        $sheet->mergeCells('H'. $newRow . ':I'. $newRow);
        $sheet->setCellValue('H' . ($newRow + 1), "RAJAL TOTAL");
        $sheet->mergeCells('H'. ($newRow + 1) . ':I'. ($newRow + 1));

        $sheet->setCellValue('E' . $newRow, $bills["total_bayar"]);
        $sheet->mergeCells('E'. $newRow . ':E'. ($newRow + 1));
        $sheet->setCellValue('E' . ($newRow + 2), array_sum($totalYankes));
        $sheet->mergeCells('E'. ($newRow + 2) . ':E'. ($newRow + 3));
        $sheet->setCellValue('J' . $newRow, (array_sum($totalYankes) - intval($bills["total_bayar"])));
        $sheet->mergeCells('J'. $newRow . ':J'. ($newRow + 1));
        $sheet->getStyle("E".$newRow.":E".($newRow+3))->applyFromArray($styleAlign["vertical"]["middle"]);
        $sheet->getStyle("E".($newRow+2).":E".($newRow+3))->applyFromArray($styleFontBold);
        $sheet->getStyle("J".$newRow.":J".($newRow+1))->applyFromArray(array_merge($style, $styleFontBold, $styleAlign["vertical"]["middle"]));
        $sheet->getStyle("E".$newRow.":E".($newRow+3))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);
        $sheet->getStyle("F".$newRow.":F".($newRow+1))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);
        $sheet->getStyle("J".$newRow.":J".($newRow+1))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sheet->getStyle("A".$newRow.":E".($newRow+3))->applyFromArray($styleBorders);
        $sheet->getStyle("F".$newRow.":J".($newRow+1))->applyFromArray($styleBorders);
        $sheet->getStyle("A".$newRow.":J".($newRow+3))->getFont()->setSize(11);

        $sheet->setCellValue('G' . ($newRow+2), 'KETERANGAN / HASIL VERIFIKASI:');
        $sheet->setCellValue('G' . ($newRow+3), $bills["verification"]);
        $sheet->mergeCells('G'. ($newRow+2) . ':L'. ($newRow+2));
        $sheet->mergeCells('G'. ($newRow+3) . ':L'. ($newRow+3));
        $sheet->mergeCells('G'. ($newRow+4) . ':L'. ($newRow+4));
        $sheet->mergeCells('G'. ($newRow+5) . ':L'. ($newRow+5));
        $sheet->getStyle("G".($newRow+3).":L".($newRow+5))->getFont()->setSize(8);

        $sheet->getStyle('G' . ($newRow+2) . ':L' . ($newRow+2))->applyFromArray([
            'borders' => [
                'top' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ],
            ]
        ]);
        $sheet->getStyle('G' . ($newRow+2) . ':L' . ($newRow+5))->applyFromArray([
            'borders' => [
                'left' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ],
            ]
        ]);
        $sheet->getStyle('J' . ($newRow+2) . ':L' . ($newRow+5))->applyFromArray([
            'borders' => [
                'right' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ],
            ]
        ]);
        $sheet->getStyle('G' . ($newRow+5) . ':L' . ($newRow+5))->applyFromArray([
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
