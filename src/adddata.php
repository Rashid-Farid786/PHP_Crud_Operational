<?php
session_start();
$con=mysqli_connect($_SESSION['crud']['h'],$_SESSION['crud']['u'],$_SESSION['crud']['p'],$_SESSION['crud']['d']);
    $sql="SHOW FIELDS FROM {$_SESSION['crud']['t']}";
$result=mysqli_query($con,$sql);
if(mysqli_num_rows($result)>0){
    print_r(mysqli_fetch_all($result));
}else{
    return false;
}
?>