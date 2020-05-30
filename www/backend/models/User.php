<?php
require_once(__dir__.'/../core/Model.php');
require_once(__dir__.'/../core/DB.php');

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