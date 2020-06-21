<?php
require_once(__dir__.'/../core/Api.php');
require_once(__dir__.'/../models/Image.php');

class ImageApi extends Api
{
    static $apiName = 'images';
    protected $model = Image::Class;
}