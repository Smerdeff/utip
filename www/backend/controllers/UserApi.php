<?php
require_once(__dir__.'/../core/Api.php');
require_once(__dir__.'/../models/User.php');

class UserApi extends Api
{
    static $apiName = 'users';
    protected $model = User::Class;
}