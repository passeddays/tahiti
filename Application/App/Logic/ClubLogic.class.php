<?php 
namespace App\Logic;
//use Think\Exception;
Class ClubLogic{
	//Protected $autoCheckFields = false;
	private $baseM;
	
	public function __construct(){
		$this->baseM = M('Base');
		$this->eventM = M('Event');
		$this->detailM = M('Detail');
		$this->imgM = M('Img');
	}

	public function hotImg($ct, $city, $co, $tp){
		//处理type异常
		if(($ct <= 0 && $ct != -1) || $tp == NULL ){
			//throw new \Exception("param error,ct={$ct}", -1);
			return NULL;
		}

		$tmpArr = explode(",", $co);
		$lat = $tmpArr[0];
		$lng = $tmpArr[1];
		//如果坐标字段为空则返回NULL
		if($lat == NULL || $lng == NULL){
			return NULL;
		}

		if($tp == -1){
			$condition = "club_city = '$city' ";
		}else{
			$condition = "club_city = '$city' and club_type='$tp'";
		}

		if($ct > 0){
			$clublist = $this->baseM->where($condition)->order('club_follow desc')->limit($ct)->field('club_id as cid, club_lat, club_lng')->select();
		}else{
			$clublist = $this->baseM->where($condition)->order('club_follow desc')->field('club_id as cid, club_lat, club_lng')->select();
		}

		foreach ($clublist as $key => &$value) {
			$value['dist'] = self::getDistance($value['club_lat'], $value['club_lng'], $lat, $lng);
			unset($value['club_lat']);
			unset($value['club_lng']);
		}

		//按照距离排序
		$clublist = self::arraySort($clublist, 'dist');

		foreach ($clublist as $key => &$value) {
			$res = $this->imgM->where("img_type='1' and club_id='".$value['cid']."'")->field('img_title as tl, img_url as bimg, img_brief as dt, img_info1 as if1, img_info2 as if2, img_time as tm, img_atl as lk ')->select();
			$res = $res[0];
			if(!$res){
				unset($clublist[$key]);
			}
			$res['bimg'] = $_SERVER['HTTP_HOST']."/img/".$res['bimg'];
			$value = array_merge($value, $res);
		}
		$res = array();
		foreach ($clublist as $key => $value) {
			$res[] = $value;
		}
		return $res;
	}

	public function hot($ct, $city, $co, $tp){

		//处理type异常
		if(($ct <= 0 && $ct != -1) || $tp == NULL ){
			//throw new \Exception("param error,ct={$ct}", -1);
			return NULL;
		}

		$tmpArr = explode(",", $co);
		$lat = $tmpArr[0];
		$lng = $tmpArr[1];
		//如果坐标字段为空则返回NULL
		if($lat == NULL || $lng == NULL){
			return NULL;
		}
		
		if($tp == -1){
			$condition = "club_city = '$city' ";
		}else{
			$condition = "club_city = '$city' and club_type='$tp'";
		}
		if($ct > 0){
			$clublist = $this->baseM->where($condition)->order('club_follow desc')->limit($ct)->field('club_id as cid, club_name as cn, club_thumb as scl, club_follow as ca, club_price as pc, club_type as tp, club_lat, club_lng , 0 as nw')->select();
		}else{
			$clublist = $this->baseM->where($condition)->order('club_follow desc')->field('club_id as cid, club_name as cn, club_thumb as scl, club_follow as ca, club_price as pc, club_type as tp, club_lat, club_lng , 0 as nw')->select();
		}
		foreach ($clublist as &$value) {
			if($this->hasEvent($value['cid'])){
				$value['nw'] = 1;
			}
		}
		foreach ($clublist as $key => &$value) {
			$value['dist'] = self::getDistance($value['club_lat'], $value['club_lng'], $lat, $lng);
			unset($value['club_lat']);
			unset($value['club_lng']);
		}

		return $clublist;
	}

	/**
	 * 是否有活动
	 */
	public function hasEvent($cid){
		$res = $this->eventM->where("club_id = '{$cid}'")->count();
		return $res>0 ? true:false;
	}

	public function detail($cid, $co, $city){
		$cid = intval($cid);
		if($cid == NULL){
			return NULL;
		}
		$res['dt'] = $res['ev'] = array();
		$clubInfo1 = $this->baseM->where('club_id = %d',array($cid))->field('club_id as cid, club_name as cn, club_thumb as scl, club_follow as ca, club_price as pc, club_type as tp, club_lat, club_lng , 0 as nw, club_brief as cbf')->select();
		//计算距离
		$tmpArr = explode(",", $co);
		$lat = $tmpArr[0];
		$lng = $tmpArr[1];
		$clubInfo1[0]['dist'] = self::getDistance($clubInfo1[0]['club_lat'], $clubInfo1[0]['club_lng'], $lat, $lng);

		//设置clc字段
		$clubInfo1[0]['clc'] = $clubInfo1[0]['club_lat'].",".$clubInfo1[0]['club_lng'];
		unset($clubInfo1[0]['club_lat']);
		unset($clubInfo1[0]['club_lng']);

		//封装详细信息到dt字段
		$clubInfo2 = $this->detailM->where('club_id = %d',array($cid))->field('club_address as cad, club_website as st, club_tel as ctel, club_canorder as od, club_pic as bcl, club_fb as cfg')->select();
		$res['dt'] = array_merge($clubInfo1[0], $clubInfo2[0]);

		//图片列表
		$imgList = $this->imgM->where('club_id = %d',array($cid))->field('img_url')->select();
		foreach ($imgList as $key => $value) {
			$res['img'][] = $value['img_url'];
		}

		//活动列表
		$eventList = $this->eventM->where('club_id = %d',array($cid))->field('event_id as eid, event_name as etl, event_time as etm, event_brief as ebf, event_poster as epb')->select();
		//是否有活动
		if(count($eventList) > 0){
			$res['dt']['nw'] = 1;
		}
		$res['ev'] = $eventList;

		return $res;
	}


	public function type($ct, $city, $co, $tp){
		$ct = intval($ct);

		if(($ct <= 0 && $ct != -1) || $tp == NULL){
			//throw new \Exception("param error,ct={$ct}", -1);
			return NULL;
		}
		$tmpArr = explode(",", $co);
		$lat = $tmpArr[0];
		$lng = $tmpArr[1];
		//如果坐标字段为空则返回NULL
		if($lat == NULL || $lng == NULL){
			return NULL;
		}

		if($tp != -1){
			$condition = "club_city = '$city' ";
		}else{
			$condition = "club_city = '$city' and club_type='$tp'";
		}
		
		$clublist = $this->baseM->where($condition)->field('club_id as cid, club_name as cn, club_thumb as scl, club_follow as ca, club_price as pc, club_type as tp, club_lat, club_lng , 0 as nw')->select();
		foreach ($clublist as $key => &$value) {
			$value['dist'] = self::getDistance($value['club_lat'], $value['club_lng'], $lat, $lng);
			unset($value['club_lat']);
			unset($value['club_lng']);
		}

		//按照距离排序
		$clublist = self::arraySort($clublist, 'dist');

		//取$ct条数据
		if($ct > 0){
			$res = array_slice($clublist, 0, $ct);
		}
		
		if(empty($res)){
			return NULL;
		}

		//计算nw字段（是否有活动）
		$condition = ' club_id in (';
		foreach ($res as $key => $value) {
			$condition .= $value['cid'].",";
		}
		$condition = substr($condition, 0, -1);
		$condition .= ') ';
		$clubIdArr = $this->eventM->where($condition)->field('distinct(club_id)')->select();
		foreach ($res as $key => &$value) {
			foreach ($clubIdArr as $val) {
				if($value['cid'] == $val['club_id']){
					$value['nw'] = 1;
					break;
				}
			}
			
		}

		return $res;
	}


	public function search($ct, $city, $co, $wd){
		$ct = intval($ct);
		if($ct <= 0 && $ct != -1){
			//throw new \Exception("param error,ct={$ct}", -1);
			return NULL;
		}
		$tmpArr = explode(",", $co);
		$lat = $tmpArr[0];
		$lng = $tmpArr[1];

		//如果坐标字段为空则返回NULL
		if($lat == NULL || $lng == NULL){
			return NULL;
		}

		$condition = "club_city = '$city' ";
		if($wd){
			$condition .= " and club_name like '%".$wd."%'";
		}
		$clublist = $this->baseM->where($condition)->field('club_id as cid, club_name as cn, club_thumb as cl, club_follow as ca, club_price as pc, club_type as tp, club_lat, club_lng, 0 as nw ')->select();
		foreach ($clublist as $key => &$value) {
			$value['dist'] = self::getDistance($value['club_lat'], $value['club_lng'], $lat, $lng);
			unset($value['club_lat']);
			unset($value['club_lng']);
		}

		//按照距离排序
		$clublist = self::arraySort($clublist, 'dist');

		//取$ct条数据
		if($ct > 0){
			$res = array_slice($clublist, 0, $ct);
		}
		
		if(empty($res)){
			return NULL;
		}

		//计算nw字段（是否有活动）
		$condition = ' club_id in (';
		foreach ($res as $key => $value) {
			$condition .= $value['cid'].",";
		}
		$condition = substr($condition, 0, -1);
		$condition .= ') ';
		$clubIdArr = $this->eventM->where($condition)->field('distinct(club_id)')->select();
		//var_dump($clubIdArr);
		foreach ($res as $key => &$value) {
			foreach ($clubIdArr as $val) {
				if($value['cid'] == $val['club_id']){
					$value['nw'] = 1;
					break;
				}
			}
			
		}

		return $res;
	}


	/** 
	* 计算经纬度距离 
	* @param $d 
	*/  
	public static function rad($d) {    
		return $d * 3.1415926535898 / 180.0;    
	}  

	public static function getDistance($lat1, $lng1, $lat2, $lng2) {    
		$EARTH_RADIUS = 6378.137;    
		$radLat1 = self::rad($lat1);    
		$radLat2 = self::rad($lat2);    
		$a = $radLat1 - $radLat2;    
		$b = self::rad($lng1) - self::rad($lng2);    
		$s = 2 * asin(sqrt(pow(sin($a/2),2) +    
		cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));    
		$s = $s *$EARTH_RADIUS;    
		$s = round($s * 10000) / 10000;    
		return $s;    
	}

	/**
     * @desc arraySort php二维数组排序 按照指定的key 对数组进行排序
     * @param array $arr 将要排序的数组
     * @param string $keys 指定排序的key
     * @param string $type 排序类型 asc | desc
     * @return array
     */
    public static function arraySort($arr, $keys, $type = 'asc') {
        $keysvalue = $new_array = array();
        foreach ($arr as $k => $v){
            $keysvalue[$k] = $v[$keys];
        }
        $type == 'asc' ? asort($keysvalue) : arsort($keysvalue);
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) {
           $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }
}