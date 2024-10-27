<?php
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'weeding';

$conn = mysqli_connect($hostname, $username, $password, $dbname) or die('gagal terhubung');

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($koneksi, $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($koneksi, $theValue) : mysqli_escape_string($koneksi, $theValue);

        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }
}
?>