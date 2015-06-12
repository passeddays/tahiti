<?php
namespace ImgServer\Controller;
use Think\Controller;

class IndexController extends Controller {
    public function uploadpic(){
        $path = C('file_path');
        $filetype = $_FILES['img']['type'];
        if (($filetype == 'image/gif') || ($filetype == 'image/jpeg') || ($filetype == 'image/png') || ($filetype == 'image/jpg')){
            if ($_FILES['img']['error'] > 0){
                switch ($_FILES['img']['error']) {
                    case '1':
                        $errMsg = "over upload_max_filesize " ;
                        break;
                    case '2':
                        $errMsg = "over MAX_FILE_SIZE  " ;
                        break;
                    case '3':
                        $errMsg = "upload Incomplete  " ;
                        break;
                    case '4':
                        $errMsg = "no file upload " ;
                        break;
                    default:
                        $errMsg = "unknow error" ;
                        break;
                }
                $ret = array(
                    'err_no' => $_FILES['img']['error'],
                    'data' => '',
                    'err_msg'=> $errMsg,
                );
            }else{
                if($filetype == 'image/jpeg'){ 
                    $type = '.jpeg'; 
                } 
                if ($filetype == 'image/png') { 
                    $type = '.png'; 
                } 
                if ($filetype == 'image/jpg') { 
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
                    'data' => "http://".$_SERVER['HTTP_HOST'].__APP__."/ImgServer/index/downloadpic&img_name=$img_name",
                    'err_msg'=> '',
                );   
            }
        }else{
            $ret = array(
                'err_no' => -1,
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
        if($db->where('count>=1')->setDec('count',1)){
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
