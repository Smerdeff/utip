<?php

require_once('DB.php');
require_once('TaskApi.php');
require_once('UserApi.php');

/**
 * Simple auto router
 */

$apis = [];
#Add api in router
array_push($apis, TaskApi::class);
array_push($apis, UserApi::class);

$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

if (array_shift($requestUri) == 'api') {
    if ($apinname = array_shift($requestUri)) {
        foreach ($apis as &$api) {
            if ($apinname == $api::get_apiname()) {
                $new_api = new $api;
                echo $new_api->run();
            }
        }
    }
}
