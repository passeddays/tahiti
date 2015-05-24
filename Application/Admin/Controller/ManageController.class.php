<?php
namespace Admin\Controller;
use Think\Controller;
class ManageController extends Controller {
    
    public function __construct(){
        parent::__construct();
        if(!$this->isLogin()){
           $this->redirect('login/index', array(), 1, L('not_login'));
        }
        $data = array(
            'chinese' => '中文',
            'english' => 'English',
            'portuguese' => 'Português',
            );
        if(!I('cookie.think_language')){
            cookie('think_language','chinese');
        }
        $currentLan = $data[I('cookie.think_language')];
        $this->assign('current_language', $currentLan);
        $this->assign('language', $data);
    }
	private function auth(){

        
    }

    private function isLogin(){
    	$uname = I('cookie.uname');
    	if(session($uname) && $uname){
    		session(array('name'=>$uname,'expire'=>600));
            return true;
    	}else{
    		return false;
    	}
    }

	private function _before_index(){
		
	}
    public function index(){
    	$this->redirect('admin/manage/clublist');
    }

    public function clubList(){
        $this->display('./Manage/clublist');
    }

    public function changePwd(){
        $this->display('./Manage/changepwd');
    }
    
    public function changepwdApi(){
        if(IS_POST){
            $uname = I('cookie.uname');
            $oldPasswd = I('post.old_pwd');
            $newPasswd = I('post.new_pwd');
            $userObj = M('user');
            $res = $userObj->where("admin_user_name = '%s'", array($uname))->field('admin_user_pwd as passwd, admin_user_id as user_id')->select();
            session(null);//退出登陆
            if($res[0]['passwd'] == $oldPasswd){
                $data['admin_user_pwd'] = $newPasswd;
                $ret = $userObj->where('admin_user_id='.$res[0]['user_id'])->data($data)->save();
                $this->redirect('login/index', array(), 1, L('changepwd_success'));
            }else{
                $this->redirect('login/index', array(), 1, L('login_err'));
            }
        }
    }


    public function getclublist(){
        $clubBaseObj = M('base', 't_club_');
        $cityBaseObj = M('city', 't_club_');
        $clubType = L('CLUB_TYPE_VAL');//类型列表
        $data = array('err_no' => 0, 'data' => '');//返回值
        $currentPage = I('get.current_page')?I('get.current_page'):1;
        $countPerPage = I('get.count_per_page')?I('get.count_per_page'):5;
        if(I('get.club_id')){
            $cond = 'b.club_id = '.I('get.club_id').'';
        }
        if(I('get.club_name')){
            $cond = 'b.club_name like "%'.I('get.club_name').'%"';
        }
        if(I('get.club_type')){
            $typeIdArr = array();
            foreach ($clubType as $key => $value) {
                if(strstr($value, I('get.club_type'))){
                    $typeIdArr[] = $key;
                }
            }
            if(empty($typeIdArr)){
                echo json_encode($data);
                exit(); 
            }
            $cond = 'b.club_type in ('.implode(",", $typeIdArr).')';
        }
        if(I('get.club_city')){
            $res = $cityBaseObj->where("city_name like '%".I('get.club_city')."%'")->field('city_id')->select();
            $cityIdArr = array();
            foreach ($res as $key => $value) {
                $cityIdArr[] = $value['city_id'];
            }
            if(empty($cityIdArr)){
                echo json_encode($data);
                exit(); 
            }
            $cond = 'b.club_city in ('.implode(",", $cityIdArr).")";
        }
        
        $data['data']['current_page'] = $currentPage;
        if($cond){
            $res = $clubBaseObj->query("select count(*) as cnt from  t_club_base b,t_club_city c where b.club_city = c.city_id and ".$cond);

            $data['data']['total_count'] = $res[0]['cnt'];
            $sql = "select b.club_id, b.club_name, b.club_type, c.city_name as club_city from t_club_base b,t_club_city c where ".$cond." and b.club_city = c.city_id limit ".$countPerPage*($currentPage - 1).",".$countPerPage;    
        }else{
            $res = $clubBaseObj->query("select count(*) as cnt from  t_club_base b,t_club_city c where b.club_city = c.city_id");
            $data['data']['total_count'] = $res[0]['cnt'];
            $sql = "select b.club_id, b.club_name, b.club_type, c.city_name as club_city from t_club_base b,t_club_city c where b.club_city = c.city_id  limit ".$countPerPage*($currentPage - 1).",".$countPerPage;
        }
        $data['data']['list'] = $clubBaseObj->query($sql);
       
        foreach ($data['data']['list'] as &$value) {
            $value['club_type'] = $clubType[$value['club_type']];
        }
        echo json_encode($data);
    }

    public function deleteClubByClubId($club_id){
        $data = array('err_no' => 0, 'data' => '');
        $clubBaseObj = M('base', 't_club_');
        $res = $clubBaseObj->where("club_id=%d", array($club_id))->delete();
        if(!$res){
            $data['err_no'] = -1;
        }
        echo json_encode($data);
    }

    public function editClub($club_id){
        $baseObj = M('base', 't_club_');
        $detailObj = M('detail', 't_club_');
        $imgObj = M('img', 't_club_');
        $eventObj = M('event', 't_club_');
        $cityObj = M('city', 't_club_');
        $base = $baseObj->where("club_id=%d", array($club_id))->select();
        $detail = $detailObj->where("club_id=%d", array($club_id))->select();
        $imgs = $imgObj->where("club_id=%d", array($club_id))->select();
        $events = $eventObj->where("club_id=%d", array($club_id))->select();
        $cityList = $cityObj->select();
        $res = array_merge($base[0], $detail[0]);
        $res['imgs'] = $imgs;
        $res['events'] = $events;
        //echo json_encode($res);exit();
        $this->assign('data', $res);
        $this->assign('citylist', $cityList);
        $this->display('./Manage/editClub');
    }


    public function updateClub(){

    }

}