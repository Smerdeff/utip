<?php
require_once(__dir__.'/../core/Api.php');
require_once(__dir__.'/../models/User.php');

class UserApi extends Api
{
    static $apiName = 'accounts';
    protected $model = User::Class;




    public function readAction()
    {
        return parent::readAction();
    }
    public function retrieveAction()
    {
        return;
    }
    public function destroyAction()
    {
        return;
    }
    public function updateAction()
    {
        return;
    }
    public function createAction()
    {
        return;
    }



}

