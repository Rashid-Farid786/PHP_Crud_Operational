<?php
if(isset($_POST['de'])){
session_start();
$con=mysqli_connect($_SESSION['crud']['h'],$_SESSION['crud']['u'],$_SESSION['crud']['p'],$_SESSION['crud']['d']);
if(is_array($_POST['de'])){
    $arr=implode(',',($_POST['de']));
    $sql="DELETE FROM {$_SESSION['crud']['t']} WHERE {$_SESSION['crud']['id']} IN ({$arr})";
    $result=mysqli_query($con,$sql);
    echo 1;
}else{
   $sql="DELETE FROM {$_SESSION['crud']['t']} WHERE {$_SESSION['crud']['id']}={$_POST['de']}";
   $result=mysqli_query($con,$sql);
   echo 1;
}
if(mysqli_error($con)){
    return 2;
}
}
?>