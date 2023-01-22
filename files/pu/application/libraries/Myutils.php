<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Myutils
{
    // write api logs
    public function writeApiLogs($cName, $content, $ip = null, $singleFile = false)
    {
        $dirName = "./logs/" . date("Ymd");
        if (!is_dir($dirName)) {
            mkdir($dirName, 0777, true);
        }

        $fpath = $dirName . "/" . $cName . ".json";
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

    private function scandir($parentDir, &$results = array())
    {
        $subDir = array();
        $directories = array_filter(glob($parentDir), 'is_dir');
        $subDir = array_merge($subDir, $directories);
        foreach ($directories as $directory) $subDir = array_merge($subDir, $this->scandir($directory . '/*'));
        return $subDir;
    }

    public function forbidden($parentDir = "", $isShow = false)
    {
        if ($isShow) echo '<pre>';
        $listDir = (empty($parentDir) ? $this->scandir("./files/") : $this->scandir($parentDir . "/"));
        foreach ($listDir as $dir) {
            if ($isShow) echo $dir . "\n";
            if (@file_get_contents($dir . "/index.html") === false) {
                $fileName = "index.html";
                $html = "<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>";
                $forbiddenFile = fopen($dir . '/' . $fileName, "w");
                fwrite($forbiddenFile, $html);
                if ($isShow) echo "Index.html >> Created \n";
                fclose($forbiddenFile);
            } else {
                if ($isShow) echo "Index.html >> Existing \n";
            }
            // if ($isShow) var_dump("========================= ** =========================");
        }
    }
}
