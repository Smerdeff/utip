<?php
require_once(__dir__ . '/../core/Api.php');
require_once(__dir__ . '/../models/User.php');

class UserApi extends Api
{
    static $apiName = 'accounts';
    protected $model = User::Class;

    public function userByToken($token)
    {
        $filter = array(
            "token" => $token,
        );
        User::read($filter);
    }

    public function loginUser()
    {
        $data = json_decode($this->requestBody, TRUE);

        $filter = array(
            "email" => $data['login'],
            "password" => md5($data['password'])
        );

        $ret = User::read($filter);
        if ($ret['data']) {
//            $_SESSION['user_id'] = $ret['data'][0]['id'];
            $user = $ret['data'][0];
            $token = bin2hex(openssl_random_pseudo_bytes(8));
            $upd_data = array("token" => $token,);

            User::update($user['id'], $upd_data); #Сохранили токен
            $ret_data = array(
                "token" => $token,
                "user" => $user);

            header("HTTP/1.1 302 Found");
            return json_encode($ret_data, JSON_UNESCAPED_UNICODE);

        } else {
            header("HTTP/1.1 403 Forbidden");
        }
    }

    public function registerUser()
    {
        if ($this->requestBody) {
            $data = json_decode($this->requestBody, TRUE);
            if ($data) {

                if ($data['password'] == $data['password_confirm']) {
                    $validate_data = User::validate($data);
                    $validate_data['password'] = md5($data['password']);

                    if (User::create($validate_data)) {
                        return $this->response('Data updated.', 200);
                    }
                }
            }
        }

        return $this->response("Create error", 500);
    }


}

