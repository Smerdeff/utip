<?php
require_once('Model.php');
require_once('DB.php');

class User extends Model
{
    static $table_name = 'users';
    static $fields = ['id', 'name', 'email', 'created_at'];
    static $read_only_fields = ['id', 'created_at'];
    static $key_field = 'id';

    static function db()
    {
        return Db::getInstance();
    }

}