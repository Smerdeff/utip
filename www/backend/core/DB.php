<?php
/**
 * Class DB
 * Singleton connection
 */
class DB
{
    #TODO need config
    const  DB_HOST = "172.20.0.1";
    const  DB_USER = "root";
    const  DB_PASS = "secret";
    const  DB_NAME = "utip";
    static private $instance = NULL;

    static function getInstance()
    {

        if (self::$instance == NULL)
        {
            self::$instance = new mysqli(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME);
            if(mysqli_connect_errno()) {
                throw new Exception("Database connection failed: ".mysqli_connect_error());
            }
        }
        return self::$instance;
    }

    private function __construct(){ }

    private function __clone() {}

}

?>