<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transformer
{
    public static function convertUserRole($role)
    {
        $result = "Unknown";

        switch (intval($role)) {
            case -1:
                $result = "Super Admin";
                break;
            case 0:
                $result = "Admin";
                break;
            case 1:
                $result = "RS Admin";
                break;
        }

        return $result;
    }

    public static function convertHospitalOwner($owner)
    {
        $result = "Unknown";

        switch (intval($owner)) {
            case 0:
                $result = "Prmerintah Provinsi";
                break;
            case 1:
                $result = "Pemerintah Daerah";
                break;
            case 2:
                $result = "Swasta";
                break;
        }

        return $result;
    }

}