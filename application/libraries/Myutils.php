<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Myutils
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    // write api logs
    public function writeApiLogs($cName, $mName, &$content, $ip = null, $singleFile = false)
    {
        $dirName = "./logs/" . date("Ymd") . "/api/" . $cName;
        if (!is_dir($dirName)) {
            mkdir($dirName, 0777, true);
        }

        $fpath = $dirName . "/" . $mName . ".json";
        $myfile = fopen($fpath, "a") or die("Unable to open file!");

        if ($singleFile) {
            fwrite($myfile, $content);
        } else {
            if ($ip == null || $ip == "") {
                fwrite($myfile, date("Y-m-d H:i:s") . "\r\n" . $content . "\r\n");
            } else {
                fwrite($myfile, date("Y-m-d H:i:s") . "(" . $ip . ")" . "\r\n" . $content . "\r\n");
            }
        }

        fclose($myfile);
    }

    // generate random string
    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i ++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generatePassword($str)
    {
        if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%\^&*\(\)_\-\+\=\[\]\{\};\\\|:\'\"\/\?\.>,\`<])[A-Za-z\d!@#$%\^&*\(\)_\-\+\=\[\]\{\};\\\|:\'\"\/\?\.>,\`<]{8,}$/", $str)) {
            return false;
        }

        $crypt_options = [
            "cost" => 8
        ];

        return password_hash(md5($str), PASSWORD_BCRYPT, $crypt_options);
    }

    public function startsWith($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }

    // simple input validation
    function simpleValidate($jsonStr, $html = true)
    {
        $words = array(
            "<?php",
            "<script",
            "<noscript"
        );
        $found = false;
        foreach ($words as $word) {
            $offset = strpos($jsonStr, $word);
            if ($offset !== false) {
                $found = true;
            }
            if ($found)
                break;
        }

        if (! $found && $html) {
            $found = ($jsonStr != strip_tags($jsonStr));
        }

        if ($found) {
            echo json_encode(array(
                "result" => 422,
                "message" => "Unprocessable Entity!"
            ));
            die();
        }
    }

    public function saveFile($fileImg, $prefix, $section, $rotate = false)
    {
        $filename = null;
        $prefix .= "_" . $this->generateRandomString(3);

        $filename = null;
        if (strlen($prefix) > 4 && substr($prefix, -4) == ".pdf") {
            $prefixName = $prefix;
        } else {
            $prefixName = $prefix . "_" . $this->generateRandomString(3);
        }
        if ($this->startsWith($fileImg, "http://") || $this->startsWith($fileImg, "https://")) {
            $handle = @fopen($fileImg, 'r');
            if (!$handle) {
                return $filename;
            } else {
                $type = pathinfo($fileImg, PATHINFO_EXTENSION);
                $data = file_get_contents($fileImg);
                if ($type == "pdf") {
                    $fileImg = 'data:application/' . $type . ';base64,' . base64_encode($data);
                } else {
                    $fileImg = 'data:image/' . $type . ';base64,' . base64_encode($data);
                }
            }
        }

        $image_parts = explode(";base64,", $fileImg);
        if ($image_parts[0] == 'data:application/pdf') {
            $base64data = base64_decode($image_parts[1]);
            if (strlen($prefix) > 4 && substr($prefix, -4) == ".pdf")
            $filename = $prefixName;
            else
                $filename = $prefixName . "_" . time() . ".pdf";

            $pdfDirName = "./files/pdf/";
            if (!is_dir($pdfDirName)) {
                mkdir($pdfDirName, 0777, true);
            }
            $file_path = $pdfDirName . $filename;

            if (file_put_contents($file_path, $base64data)) {
                return $filename;
            };
        }

        $image_base64 = null;
        if ($image_parts != null && count($image_parts) > 1) {
            $image_base64 = base64_decode($image_parts[1]);
        } else {
            $image_base64 = base64_decode($fileImg);
        }

        // Load GD resource from binary data
        $im = imageCreateFromString($image_base64);

        // Make sure that the GD library was able to load the image
        // This is important, because you should not miss corrupted or unsupported images
        if (!$im) {
            // image is invalid
        } else {
            // Specify the location where you want to save the image
            $filename = $prefix . "_" . time() . ".png";
            $img_file = "./files/images/" . $section . "/" . $filename;

            // Save the GD resource as PNG in the best possible quality (no compression)
            // This will strip any metadata or invalid contents (including, the PHP backdoor)
            // To block any possible exploits, consider increasing the compression level
            imagepng($im, $img_file, 0);

            if ($filename != null) {
                if ($rotate === false) {
                    $this->CI->load->library('image_autorotate', array(
                        'filepath' => $filename
                    ));
                }
            }
        }

        return $filename;
    }

    function convertDate($date, $withDay = false)
    {
        $newDate = date("Y-m-d", strtotime($date));
        $day = date("l", strtotime($date));
        $month = [
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        $days = [
            "sunday" => "Minggu",
            "monday" => "Senin",
            "tuesday" => "Selasa",
            "wednesday" => "Rabu",
            "thursday" => "Kamis",
            "friday" => "Jum'at",
            "saturday" => "Sabtu"
        ];

        $split = explode('-', $newDate);
        $dayName = $days[strtolower($day)];
        $dateConvert = $split[2] . ' ' . $month[(int)$split[1]] . ' ' . $split[0];

        if ($withDay) {
            return $dayName . ', ' . $dateConvert;
        } else {
            return $dateConvert;
        }
    }

    /**
     * Function that groups an array of associative arrays by some key.
     * 
     * @param {String} $key Property to sort by.
     * @param {Array} $data Array that stores multiple associative arrays.
     */
    function group_by($key, $data)
    {
        $result = array();

        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                $result[$val[$key]][] = $val;
            } else {
                $result[""][] = $val;
            }
        }

        return $result;
    }
}
