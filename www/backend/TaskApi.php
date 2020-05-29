<?php
require_once('Api.php');
require_once('Task.php');

class TaskApi extends Api
{
    static $apiName = 'tasks';
    protected $model = Task::Class;
}