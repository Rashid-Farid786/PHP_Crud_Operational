<?php
namespace updare;
session_start();
// echo "<pre>";
// print_r($_SESSION);die;
use MyApp\Connection;
$con=mysqli_connect($_SESSION['crud']['h'],$_SESSION['crud']['u'],$_SESSION['crud']['p'],$_SESSION['crud']['d']);
$sql="SHOW FIELDS FROM {$_SESSION['crud']['t']}";
$result=mysqli_query($con,$sql);
if(mysqli_num_rows($result)>0){
    $data=mysqli_fetch_assoc($result);
        $keys=implode('=>',$data);
        echo "<pre>";
    print_r($keys);

}else{

}
?>