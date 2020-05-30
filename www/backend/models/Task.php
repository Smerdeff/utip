<?php
require_once(__dir__.'/../core/Model.php');
require_once(__dir__.'/../core/DB.php');

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