<?php
require_once(__dir__.'/../core/Model.php');
require_once(__dir__.'/../core/DB.php');

class Image extends Model
{
    static $table_name = 'images';
    static $fields = ['id', 'file_name', 'status', 'created_at', 'title', 'description'];
    static $read_only_fields = ['id', 'created_at'];
    static $key_field = 'id';

    static function db()
    {
        return Db::getInstance();
    }

}