<?php
//require_once(__dir__.'/../core/Api.php');
require_once(__dir__ . '/../models/Image.php');


class ImageApi extends Api
{

    static $apiName = 'images';
    protected $model = Image::Class;

    public function readAction()
    {
        $filter=[];
//        if ($_GET['search']) {
//            $filter = [
//                'title__icontains'=>$_GET['search'],
//                'description__icontains'=>$_GET['search'],
//            ];
//
//        }
        $data = $this->model::read($filter);
        if ($data) {
            return $this->response($data, 200);

        }
        return $this->response('Data not found', 404);
    }

    public function destroyAction()
    {
        $target_dir = "uploads/";
        $target_thumbnail_dir = "uploads/thumbnail/";

        $id = array_shift($this->requestUri);
        $data = Image::retrieve($id);
        if (!$id || !$data['data']) {
            return $this->response("Data with id=$id not found", 404);
        }
        $file_name = $data['data'][0]['file_name'];
        $filter = [
            'file_name' => $file_name,
        ];
        $exclude = [
            'id' => $id,
        ];
        $ret = Image::read($filter, $exclude);

        if (!$ret['data']) {
            unlink($target_dir . $file_name);
            unlink($target_thumbnail_dir . $file_name);
        }

        if (Image::destroy($id)) {
            return $this->response('Data deleted.', 200);
        }
        return $this->response("Delete error", 500);
    }


}