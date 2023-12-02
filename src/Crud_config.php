<?php
namespace MyApp;
class Crud_config{

    public static $db_host='localhost';
    public static $db_user='root';
    public static $db_password='';
    public static $db_name='sms';

    // SMTP Setting
    public static $smtp_email='';
    public static $smtp_password='';
    public static $smtp_port='';

    // theme
    public static $theme_name='bootstrap';
    public static $theme_path='theme';

    // pagination
    public static $offset=1;
    public static $limit=100;
}

?>