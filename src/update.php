<?php
namespace updare;
session_start();
// echo "<pre>";
// print_r($_SESSION);die;
use MyApp\Connection;
$con=mysqli_connect($_SESSION['crud']['h'],$_SESSION['crud']['u'],$_SESSION['crud']['p'],$_SESSION['crud']['d']);
$sql="SELECT * FROM {$_SESSION['crud']['t']}";
$result=mysqli_query($con,$sql);
if(mysqli_num_rows($result)>0){
    $string="";
    foreach($data=mysqli_fetch_assoc($result) as $key=>$value){
        $string.=$key."=".$value." , ";
    }
    $sql1="UPDATE {$_SESSION['crud']['t']} SET trim($string,',')";
    echo $string;die;
    if(mysqli_query($con,$sql1)){
        echo 1;
    }else{
        echo 2;
    }
    
}else{
    echo 3;
}
?>