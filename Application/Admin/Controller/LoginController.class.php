<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    private $userObj;

    private function isLogin(){
    	$uname = I('cookie.uname');
    	if(session($uname) && $uname){
    		session(array('name'=>$uname,'expire'=>600));
            return true;
    	}else{
    		return false;
    	}
    }

    public function login(){
        if(!IS_POST){
            return ;
        }
        $uname = I('post.uname');
        $passwd = I('post.passwd');
    	$this->userObj = M('user');
    	$res = $this->userObj->where("admin_user_name = '%s'", array($uname))->field('admin_user_pwd as passwd')->select();
    	if($res[0]['passwd'] == $passwd){
    		session(array('name'=>$uname,'expire'=>600));
    		session($uname, 1);
            setcookie('uname', $uname);
            $this->redirect('manage/index');
    	}else{
            $this->redirect('login/index', array(), 1, L('login_err'));
        }
    }

    public function logout(){
    	session(null);
        $this->redirect('login/index');
    }

    public function index(){
        if($this->isLogin()){
            $this->redirect('manage/index');
        }else{
           $this->display('./Login/login');
        }
    	
    }
    
}