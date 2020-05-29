<?php
require_once('Api.php');
require_once('User.php');

class UserApi extends Api
{
    static $apiName = 'users';
    protected $model = User::Class;
}