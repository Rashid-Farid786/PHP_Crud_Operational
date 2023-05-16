<?php
//         error_reporting(0);
//  ini_set("display_errors",0);
function errorHandler($errorno,$errorstr,$errorfile,$errorline){
    echo "<script>message('Error : {$errorstr} , the line number is : {$errorline} and the file is : ".basename($errorfile)."','crudwhite');</script>";
}
function exeptionHandler(Throwable $exception){
   echo '<script>message("Error : '.$exception->getmessage().' on line number is : '.$exception->getLine().' and file is : '.basename($exception->getfile()).'","crudwhite");</script>';
}
set_error_handler("errorHandler");
set_exception_handler("exeptionHandler");
?>