<?php

$servername = "xpdb01.hihosting.hinet.net:3306";
$dBUsername = "chjb";
$dBPassword = "jiabao@84009552@";
$dBName = "p89846595_mvp";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}