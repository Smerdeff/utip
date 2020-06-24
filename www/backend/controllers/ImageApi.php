<?php
//require_once(__dir__.'/../core/Api.php');
require_once(__dir__ . '/../models/Image.php');
require_once(__dir__ . '/../models/User.php');
require_once(__dir__ . '/../create-thumbnail.php');

class ImageApi extends Api
{

    static $apiName = 'images';
    protected $model = Image::Class;

    public function userAuthorization()
    {
        if (isset($this->headers['Authorization'])) {
            $filter = [
                'token' => $this->headers['Authorization']
            ];
            return User::read($filter)[0];
        }
        return [];
    }


    public function readAction()
    {
        if (!$user = $this->userAuthorization()) {
            return $this->response([], 401);

        }
        $this->filter['user_id'] = $user['id'];
        if ($_GET['search']) {
            $search =
                [
                    '||' => [
                        'title__icontains' => $_GET['search'],
                        'description__icontains' => $_GET['search'],
                    ],
                ];
            $this->filter = array_merge($this->filter, $search);

        }

        return parent::readAction();
    }


    public function updateAction()
    {
        if (!$user = $this->userAuthorization()) {
            return $this->response([], 401);
        };
        $filter = ['user_id' => $user['id']];
        $this->filter = array_merge($this->filter, $filter);
        return parent::updateAction();
    }

    public function destroyAction()
    {
        if (!$user = $this->userAuthorization()) {
            return $this->response([], 401);
        }
        $filter = [
            'user_id' => $user['id'],
        ];
        $this->filter = array_merge($this->filter, $filter);
        $filter[Image::key_field()] = $this->requestUri[0];

        $item = Image::read($filter);

        if ($item) {
            $item=$item[0];
            $target_dir = __dir__ . '/../uploads/';
            $target_thumbnail_dir = __dir__.'/../uploads/thumbnail/';

            $filter = [
                'file_hash' => $item['file_hash'],
            ];
            $ret = Image::read($filter);

            if (!$ret) {
                unlink($target_dir . $item['file_name']);
                unlink($target_thumbnail_dir . $item['file_name']);
            }
            return parent::destroyAction();
        }
    }

    public function upload()
    {
        if (!$user = $this->userAuthorization()) {
            return $this->response([], 401);
        }
        header("Content-Type': image");
        $target_dir = 'uploads/';
        $target_thumbnail_dir = 'uploads/thumbnail/';
        $imageFileType = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        $unique_file_name = uniqid('img_');
        if ($imageFileType) $unique_file_name .= '.' . $imageFileType;
        $target_file = $target_dir . $unique_file_name;


        if ($_FILES['file']['size'] > 500000) {
            return $this->response('Sorry, your file is too large', 413);
        }
        $check = getimagesize($_FILES['file']['tmp_name']);
        if (!$check) {
            return $this->response('File is not an image.', 415);
        }

        $hash_file = hash_file('md5', $_FILES['file']['tmp_name']);

        $filter = [
            'file_hash' => $hash_file,
            'user_id' => $user['id'],
        ];
        $ret = Image::read($filter);

        if ($ret) return $this->response('Sorry, file already exists.', 409);


        $filter = [
            'file_hash' => $hash_file,
        ];
        $ret = Image::read($filter);

        if ($ret) {
            $unique_file_name = $ret[0]['file_name'];
        } else {

            if (!move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
                return $this->response('Sorry, there was an error uploading your file.', 500);
            }
        }

        $data = array(
            'file_name' => $unique_file_name,
            'title' => basename($_FILES['file']['name']),
            'file_hash' => $hash_file,
            'user_id' => $user['id'],
        );

        createThumbnail($target_dir . $unique_file_name, $target_thumbnail_dir . $unique_file_name, 160);
        return $this->response(Image::create($data), 200);
    }

}