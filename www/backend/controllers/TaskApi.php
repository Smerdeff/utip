<?php
require_once(__dir__.'/../core/Api.php');
require_once(__dir__.'/../models/Task.php');

class TaskApi extends Api
{
    static $apiName = 'tasks';
    protected $model = Task::Class;
}