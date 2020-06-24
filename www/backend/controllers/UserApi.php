<?php
require_once(__dir__ . '/../core/Api.php');
require_once(__dir__ . '/../models/User.php');


class UserApi extends Api
{
    static $apiName = 'accounts';
    protected $model = User::Class;


    public function tokenUser()
    {
        if (isset($this->requestUri[0])) {
            $filter = array(
                "token" => $this->requestUri[0],
            );
            $ret = User::read($filter);
            if ($ret) {
                $user = $ret[0];
                $ret_data = [
                    "user" => $user
                ];
                return $this->response($ret_data, 200);
            }
        }
    }

    public function loginUser()
    {
        $data = json_decode($this->requestBody, TRUE);

        $filter = [
            "email" => $data['login'],
            "password" => md5($data['password'])
        ];

        $ret = User::read($filter);
        if ($ret) {
            $user = $ret[0];
            $token = bin2hex(openssl_random_pseudo_bytes(8));
            $upd_data = array("token" => $token,);

            User::update(['id' => $user['id']], $upd_data); #Сохранили токен
            $ret_data = [
                "token" => $token,
                "user" => $user
            ];
            return $this->response($ret_data, 200);

        } else {
            return $this->response([], 401);
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

