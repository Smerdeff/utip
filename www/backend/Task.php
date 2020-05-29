<?php
require_once('Model.php');
require_once('DB.php');

class Task extends Model
{
    static $table_name = 'tasks';
    static $fields = ['id', 'username', 'body', 'created_at'];
    static $read_only_fields = ['id', 'created_at'];
    static $key_field = 'id';

    static function db()
    {
        return Db::getInstance();
    }
}