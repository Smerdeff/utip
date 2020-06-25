<?php

require_once(__dir__ . '/core/DB.php');
require_once(__dir__ . '/controllers/UserApi.php');
require_once(__dir__ . '/controllers/ImageApi.php');
/**
 * Router
 * !work with web-server redirect!
 * nginx: rewrite ^/api/(.*)$ /index.php;
 * apache: RewriteRule ^api/(.*)$ /index.php
 */


$apis = [];
#Add api in auto router
//array_push($apis, ImageApi::class);
//array_push($apis, UserApi::class);

$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

if (array_shift($requestUri) == 'api') {
    if ($apinname = array_shift($requestUri)) {


        if ($apinname == 'thumbnail') {
            $new_api = new ImageApi;
            if ($new_api->method === 'GET') {
                echo $new_api->image(array_shift($requestUri));
            }
        }

        if ($apinname == 'image') {
            $new_api = new ImageApi;
            if ($new_api->method === 'GET') {
                echo $new_api->image(array_shift($requestUri), false);
            }
        }

            if ($apinname == 'images') {
            $new_api = new ImageApi;
            if ($new_api->method === 'GET') {
                echo $new_api->readAction();
            }

            if ($new_api->method === 'PUT') {
                echo $new_api->updateAction();
                return;
            }
            if ($new_api->method === 'POST') {
                if ($apinname = array_shift($requestUri)) {
                    if ($apinname == 'upload') {
                        echo $new_api->upload();
                        return;
                    }
                }
            }
            if ($new_api->method === 'DELETE') {
                echo $new_api->destroyAction();
                return;
            }
        }
        if ($apinname == 'accounts') {
            if ($apinname = array_shift($requestUri)) {
                if ($apinname == 'register') {
                    $new_api = new UserApi;
                    if ($new_api->method === 'POST') {
                        echo $new_api->registerUser();
                        return;
                    }
                }
                if ($apinname == 'login') {
                    $new_api = new UserApi;
                    if ($new_api->method === 'POST') {
                        echo $new_api->loginUser();
                        return;
                    }
                }
                $new_api = new UserApi;
                if ($new_api->method === 'GET') {
                    echo $new_api->tokenUser();
                    return;
                }
            }
        }
    }
}


