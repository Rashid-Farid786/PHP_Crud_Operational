<?php
namespace MyApp;


class Error{
    public function __construct(){
    
        function errorHandler($errorno,$errorstr,$errorfile,$errorline){
            echo "<script>message('Error : {$errorstr} , the line number is : {$errorline} and the file is : ".basename($errorfile)."','crudwhite');</script>";
        }
        
        
        function exeptionHandler(Throwable $exception){
            echo '<script>message("Error : '.$exception->getmessage().' on line number is : '.$exception->getLine().' and file is : '.basename($exception->getfile()).'","crudwhite");</script>';
        }
        
        set_error_handler("errorHandler");
        set_exception_handler("exeptionHandler");
        

        $Error='<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="src/css/style.css">
            <script>
                function message(message,status){
                let tag=document.createElement("h3");
                let text=document.createTextNode(message);
                tag.classList.add(status);
                tag.appendChild(text);
                document.write(tag.outerHTML);
                setTimeout(function(){
                    tag.remove();
                },1000);
            }

            </script>';
    }
}
?>