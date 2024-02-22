<?php
$con=mysqli_connect(DB_HOST,DN_USER,DN_PASSWORD,DB_NAME) OR die("Connection Failed");
if(isset($_SERVER['HTTPS'])){
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
}
else{
    $protocol = 'http';
}
$base_url=$protocol."://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

const URL="";

const DEBUG='off';

// website mantanace or not
const STATUS='off'; // on/off


// Database Setting
const DB_HOST='localhost';
const DB_USER='root';
const DB_PASSWORD='';
const DATABASE='';


// SMTP Settings
const SMTP_MAIL='rashidfarid40@gmail.com';
const SMTP_USERNAME='rashidfarid40@gmail.com';
const SMTP_PASS='kbnb rcnk rwld dvjk';
const SMTP_PORT='465';



if( STATUS == 'on'){
echo '<style>body{padding:0; margin:0; width:100%; height:100vh; display:flex; align-item:center; align-conten:center; justify-content:center; color:gray; background:#f1f1f1;}</style><div style="position:absolute; top:50%; height:50%; transform:translation(-50%,-50%); font-size:50px;">Website In Progress</div>';die();
}

if(DEBUG == 'off'){
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
}else{
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
}

?>