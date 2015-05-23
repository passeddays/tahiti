<?php
namespace ImgServer\Controller;
use Think\Controller;

class IndexController extends Controller {
    public function uploadpic(){
        $path = C('file_path');
        $filetype = $_FILES['img']['type'];
        if (($filetype === 'image/gif') || ($filetype === 'image/jpeg') || ($filetype === 'image/png') || ($filetype === 'image/jpg')){
            if ($_FILES['img']['error'] > 0){
                $ret = array(
                    'err_no' => 1,
                    'data' => '',
                    'err_msg'=> 'error>0',
                );
            }else{
                if($filetype == 'image/jpeg'){ 
                    $type = '.jpg'; 
                } 
                if ($filetype == 'image/jpg') { 
                    $type = '.jpg'; 
                } 
                if ($filetype == 'image/pjpeg') { 
                    $type = '.jpg'; 
                } 
                if($filetype == 'image/gif'){ 
                    $type = '.gif'; 
                } 
                $img_name = time().$type;
                //文件名，可存数据库
                $img_path = "$path/$img_name";
                move_uploaded_file($_FILES['img']['tmp_name'], $img_path);
                $ret = array(
                    'err_no' => 0,
                    'data' => "http://".$_SERVER['SERVER_ADDR'].__APP__."/ImgServer/index/downloadpic?&img_name=$img_name",
                    'err_msg'=> '',
                );   
            }
        }else{
            $ret = array(
                'err_no' => 1,
                'data' => '',
                'err_msg'=> 'error type',
            );
        }
        $this->ajaxReturn($ret);
    }

    public function downloadpic($img_name){
        $path = C('file_path');
        $img_name = I('img_name');
        if(!$img_name){
            $this->ajaxReturn(array(
                'err_no' => -1,
                'data' => '',
                'err_msg'=> 'file name is empty',
            ));
        }
        $db = M('count', 'download_', 'mysql');
        if($db->where('count<100')->setDec('count',1)){
            $file = "$path/$img_name";
            header('Content-Type: application/force-download');
            header('Content-Disposition: attachment; filename='.basename($file));
            readfile($file);
            $db->where('id=0')->setInc('count',1);
            //echo 'done';
        }else{
            echo 'wait';
        }
    }
}