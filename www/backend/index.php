<?php

require_once(__dir__.'/core/DB.php');
require_once(__dir__.'/controllers/TaskApi.php');
require_once(__dir__.'/controllers/UserApi.php');

/**
 * Simple auto router
 * !work with web-server redirect!
 * nginx: rewrite ^/api/(.*)$ /index.php;
 * apache: RewriteRule ^api/(.*)$ /index.php
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
