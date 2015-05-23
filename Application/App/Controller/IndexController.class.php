<?php
namespace App\Controller;
use Think\Controller;
class IndexController extends Controller {
    private $clubObj;
    public function __construct(){
        $this->clubObj = new \App\Logic\ClubLogic();
    }
	private function auth(){
    	echo 'auth<br>';
    }

	public function _before_index(){
		$this->auth();
	}
    public function index(){
    	echo 'app index';
    }
    
    public function search($rid, $ct, $city = 0, $co, $un, $uid, $wd){
    	$res = array(
            'rid' => $rid,
            'wd'  => $wd,
            'ret' => '',
        );
        try {
            $res['ret'] = $this->clubObj->search($ct, $city, $co, $wd);
        } catch (Exception $e) {
            //var_dump($e);
        }
        echo json_encode($res);
    }

    public function type($rid, $ct, $city = 0, $co, $un, $uid, $tp){
        $res = array(
            'rid' => $rid,
            'ret' => '',
        );
        try {
            $res['ret'] = $this->clubObj->type($ct, $city, $co, $tp);
        } catch (Exception $e) {
            //var_dump($e);
        }
        echo json_encode($res);
    }

    public function detail($rid, $ct, $city, $co ,$un, $uid, $cid){
        $res = $this->clubObj->detail($cid, $co, $city);
        $res['rid'] = $rid;
        echo json_encode($res);
    }

    public function map($rid, $ct, $city = 0, $co, $un, $uid, $tp){
        $res = array(
            'rid' => $rid,
            'ret' => '',
        );
        try {
            $res['ret'] = $this->clubObj->hot($ct, $city, $co, $tp);
            //var_dump($res);exit();            
        } catch (Exception $e) {
            //var_dump($e);
        }
        echo json_encode($res);
    }

    public function hot($rid, $ct, $city, $co ,$un, $uid, $tp){
        $res = array(
            'rid' => $rid,
            'ret' => '',
        );
        try {
            $res['ret'] = $this->clubObj->hot($ct, $city, $co, $tp);
        } catch (Exception $e) {
            //var_dump($e);
        }
        echo json_encode($res);
    }

    public function hotImg($rid, $ct, $city, $co ,$un, $uid, $tp){
        $res = array(
            'rid' => $rid,
            'ret' => '',
        );
        try {
            $res['ret'] = $this->clubObj->hotImg($ct, $city, $co, $tp);
        } catch (Exception $e) {
            //var_dump($e);
        }
        echo json_encode($res);
    }

    public function test(){
        sleep(30);
        echo '5 seconds';
    }
}