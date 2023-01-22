<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
include_once(APPPATH . "controllers/Constant.php");

class Getname {
    protected $CI;

    public function __construct()
    {
    }

    public function filePath($prefix = "", $time = "")
    {
        $firstPrefix = explode("_", $prefix)[0];
        $dateCreated = date("Ym", intval($time));
        if (in_array($firstPrefix, json_decode(PREFIX_ATTACHMENT))) {
            $filePath = "attachment/" . $dateCreated;
        } else if (in_array($firstPrefix, json_decode(PREFIX_CHAT))) {
            $filePath = "chat/" . $dateCreated;
        } else if (in_array($firstPrefix, ["ticket"])) {
            $filePath = "ticket/" . $dateCreated;
        } else if (in_array($firstPrefix, json_decode(PREFIX_STATIC))) {
            $filePath = $firstPrefix;
        } else {
            $filePath = "";
        }

        return $filePath;
    }
    
    public function prefix($fileName = "")
    {
        $prefixName = "";
        $arrFileName = explode("_", $fileName);
        $lengthFileName = count($arrFileName);
        if ($lengthFileName == 1) {
            $prefixName = substr($fileName, 0, 3);
        } else {
            $prefixName = $arrFileName[0];
        }

        return $prefixName;
    }

    public function dateFolder($fileName = "")
    {
        $dateFName = 0;
        $arrFileName = explode("_", $fileName);
        $lengthFileName = count($arrFileName);

        if ($lengthFileName == 1) {
            $datetime = intval(substr($fileName, 3, 10));
        } else {
            $datetime = end($arrFileName);
            $datetime = explode(".", $datetime)[0];
            $datetime = intval($datetime);
        }
        $dateFName = date("Ym", $datetime);

        return $dateFName;
    }

    public function sequenceDate($str = "")
    {
        // $str = "admin@sne.co.id_prd_159860166147.2891_1.jpg";
        // $str = "abdulmuin1453@gmail.com_prd_0703200425440.jpg";

        $seqDate = "197001";
        $number = "";
        foreach (str_split($str) as $s) {
            if (is_numeric($s)) {
                $number .= $s;
                if (strlen($number) == 10) break;
            } else {
                if (strlen($number) == 8) {
                    break;
                } else {
                    $number = "";
                    continue;
                }
            }
        }

        var_dump($number);
        if (strlen($number) == 10) {
            var_dump("10A");
            $setDate = date("Ym", $number);
            var_dump($setDate);
        } else if (strlen($number) == 8) {
            var_dump("8A");
            $setDate = substr($number, 6, 2) . "-" . substr($number, 4, 2) . "-" . substr($number, 0, 4);
            if (strtotime($setDate) != false && strtotime($setDate) > 0) {
                var_dump("DATE");
                $seqDate = date("Ym", strtotime($setDate));
            } else {
                $setDate = substr($number, 0, 2) . "-" . substr($number, 2, 2) . "-" . substr($number, 4, 4);
                if (strtotime($setDate) != false && strtotime($setDate) > 0) {
                    $seqDate = date("Ym", strtotime($setDate));
                }
            }
        } else {
            var_dump("0A");
        }

        var_dump("Date : " . $seqDate);
        // if (strlen($number) == 8) {
        //     var_dump("A");
        //     $setDate = substr($number, 0, 2) . "-" . substr($number, 2, 2) . "-" . substr($number, 4, 4);
        //     // var_dump($setDate);
        //     // var_dump(strtotime($setDate));
        //     // var_dump(DateTime::createFromFormat('Ymd', date("Ymd", strtotime($setDate))));
        //     if (strtotime($setDate) != false && strtotime($setDate) > 0) {
        //         var_dump("B");
        //         $seqDate = date("Ym", strtotime($setDate));
        //     } else {
        //         var_dump("C");
        //         $setDate = substr($number, 6, 2) . "-" . substr($number, 4, 2) . "-" . substr($number, 0, 4);
        //         if (strtotime($setDate) != false && strtotime($setDate) > 0) {
        //             var_dump("D");
        //             $seqDate = date("Ym", strtotime($setDate));
        //         } else {
        //             $setDate = substr($number, 4, 2) . "-" . substr($number, 2, 2) . "-" . substr($number, 0, 2);
        //             var_dump("E");
        //             if (strtotime($setDate) != false && strtotime($setDate) > 0) {
        //                 var_dump($setDate);
        //                 var_dump("F");
        //                 $seqDate = date("Ym", strtotime($setDate));
        //             } else {
        //                 var_dump("G");
        //                 $seqDate = date("Ym", $number);
        //             }
        //         }
        //     }
        // } else if (strlen($number) == 10) {
        //     $seqDate = date("Ym", $number);
        // } else {
        //     // $arrStr = explode()
        //     $seqDate = "197001";
        // }

        return $seqDate;
    }
}