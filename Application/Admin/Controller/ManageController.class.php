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
            $cond = 'b.club_id = '.intval(I('get.club_id')).'';
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
        $detail['club_thumb'] = "/thumb/".$detail['club_thumb'];
        $imgs = $imgObj->where("club_id=%d", array($club_id))->select();
        $events = $eventObj->where("club_id=%d", array($club_id))->select();
        $cityList = $cityObj->select();
        $res = array_merge($base[0], $detail[0]);
        $res['club_thumb'] = "/thumb/".$res['club_thumb'];
        $res['imgs'] = $imgs;
        $res['events'] = $events;
        $res['club_type_list'] = $clubType = L('CLUB_TYPE_VAL');
        //var_dump($res);exit();
        $this->assign('data', $res);
        $this->assign('citylist', $cityList);
        $this->display('./Manage/editClub');
    }
    public function addClubApi(){
        if(IS_POST){
            $baseObj = M('base', 't_club_');
            $detailObj = M('detail', 't_club_');
            $base = array(
                'club_name' => I('post.club_name'),
                'club_type' => I('post.club_type'),
                'club_city' => I('post.club_city'),
                'club_lat' => I('post.club_lat'),
                'club_lng' => I('post.club_lng'),
                'club_thumb' => I('post.club_thumb'),
                'club_follow' => I('post.club_follow'),
                'club_price' => I('post.club_price'),
                'club_brief' => I('post.club_brief'),
            );
            $result = $baseObj->add($base);
            if($result){
                // 如果主键是自动增长型 成功后返回值就是最新插入的值
                $cid = $result;
            }
            $detail = array(
                'club_id' => $cid,
                'club_address' => I('post.club_address'),
                'club_website' => I('post.club_website'),
                'club_tel' => I("post.club_tel"),
                'club_canorder' => I('post.club_canorder'),
                'club_pic' => I('post.club_pic'),
                'club_fb' => I('post.club_fb'),
            );
            $detailObj->add($detail);
            $this->redirect('admin/manage/editClub', array('club_id' => $cid));
        }
    }

    public function addClub(){
        $cityObj = M('city', 't_club_');
        $res['club_type_list'] = $clubType = L('CLUB_TYPE_VAL');
        $cityList = $cityObj->select();
        //var_dump($res);exit();
        $this->assign('data', $res);
        $this->assign('citylist', $cityList);
        $this->display('./Manage/addClub');
    }
    public function upload($upload_type){
        $filetype = $_FILES['file']['type'];
        if (($filetype == 'image/gif') || ($filetype == 'image/jpeg') || ($filetype == 'image/png') || ($filetype == 'image/jpg')){
            if ($_FILES['file']['error'] > 0){
                $ret = array(
                    'err_no' => 1,
                    'data' => '',
                    'err_msg'=> 'error>0',
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
                $img_name = md5($_FILES['file']['tmp_name']).$type;
                switch ($upload_type) {
                    case 'thumb':
                        $path = SERVER_PATH."/thumb";
                        break;
                    case 'event':
                        $path = SERVER_PATH."/poster";
                        break;
                    case 'img':
                        $path = SERVER_PATH."/img";
                        break;
                    default:
                        $this->ajaxReturn(array(
                            'err_no' => -1,
                            'data' => '',
                            'err_msg'=> 'wrong upload type',
                        ));
                        return ;
                }
                //文件名，可存数据库
                $img_path = "$path/$img_name";
                move_uploaded_file($_FILES['file']['tmp_name'], $img_path);
                $ret = array(
                    'err_no' => 0,
                    'data' => $img_name,
                    'err_msg'=> '',
                );   
            }
        }else{
            $ret = array(
                'err_no' => -1,
                'data' => '',
                'err_msg'=> 'img type show be jpg/gif/png',
            );
        }
        $this->ajaxReturn($ret);
    }


    public function updateClub($cid){
        if(IS_POST){
            $baseFields = array(
                'club_name' => I('post.club_name'),
                'club_type' => I('post.club_type'),
                'club_city' => I('post.club_city'),
                'club_lat'  => I('post.club_lat'),
                'club_lng'  => I('post.club_lng'),
                'club_thumb'  => I('post.club_thumb'),
                'club_follow'  => I('post.club_follow'),
                'club_price'  => I('post.club_price'),
                'club_brief'  => I('post.club_brief'),
            );
            $baseObj = M('base', 't_club_');
            $baseObj->where("club_id=".$cid)->setField($baseFields);

            $detailObj = M('detail', 't_club_');
            $detailFields = array(
                'club_address' => I('post.club_address'),
                'club_website' => I('post.club_website'),
                'club_tel' => I('post.club_tel'),
                'club_fb' => I('post.club_fb'),
            );
            $detailObj->where("club_id=".$cid)->setField($baseFields);
        }
        $this->redirect('admin/manage/editClub', array('club_id' => $cid));
    }

    public function editEvent($event_id, $cid){
        $eventObj = M('event', 't_club_');
        $event = $eventObj->where("club_id=%d and event_id=%d", array($cid, $event_id))->select();
        $res = $event[0];
        // $res['event_poster'] = "/poster/".$res['event_poster'];
        $res['club_name'] = $this->getClubNameById($cid);
        $this->assign('data', $res);
        $this->display('./Manage/editEvent');
    }

    public function getClubNameById($cid){
        $baseObj = M('base', 't_club_');
        $res = $baseObj->where("club_id=%d", array($cid))->select();
        return $res[0]['club_name'];
    }

    public function updateEvent($event_id, $cid){
        if(IS_POST){
            $eventFields = array(
                'event_name' => I('post.event_name'),
                'event_brief'  => I('post.event_brief'),
                'event_time'  => I('post.event_time'),
                'event_poster'  => I('post.event_poster'),
            );
            $eventObj = M('event', 't_club_');
            $res = $eventObj->where("club_id=%d and event_id=%d",array($cid, $event_id))->setField($eventFields);
        }
        $this->redirect('admin/manage/editClub', array('club_id' => $cid));
    }

    public function addEvent($cid){
        $baseObj = M('base', 't_club_');
        $res = $baseObj->where("club_id=%d", array($cid))->select();
        $this->assign('data', $res[0]);
        $this->display('./Manage/addEvent');
    }

    public function addEventApi($cid){
        if(IS_POST){
            $eventObj = M('event', 't_club_');
            $event = array(
                'club_id' => $cid,
                'event_name' => I('post.event_name'),
                'event_time' => I('post.event_time'),
                'event_brief' => I('post.event_brief'),
                'event_poster' => I('post.event_poster'),
            );
            $eventObj->add($event);
            $this->redirect('admin/manage/editClub', array('club_id' => $cid));
        }
        
    }

    public function getCityIdByCityName($city_name){
        $cityObj = M('city', 't_club_');
        $res = $cityObj->where("city_name = '$city_name'")->select();
        if(empty($res)){
            $cityId = $cityObj->add(array('city_name' => $city_name));
        }else{
            $cityId = $res[0]['city_id'];
        }

        echo $cityId;
    }
}