<?php
//更改会员等级
function changeusergroup($uid){
	$member = M('member');
	$user = $member->where("id='{$uid}' AND groupid <> '10' AND groupid <> '11'")->field('id,point')->find();
	if($user){
		$membergroup = M('membergroup')->where('isagent<>1')->cache(600)->field('groupid,shengjiedu')->order('groupid ASC')->select();//查找会员组
		if($user['point'] <= $membergroup[0]["shengjiedu"])$user['groupid']=1;  //比较会员积分确认会员组别
		for($i=1;$i<count($membergroup);$i++){
			if($membergroup[$i]["shengjiedu"]<=$user['point'] && $user['point'] < $membergroup[$i+1]["shengjiedu"]){
				$user['groupid']=$i+1;
			}
		}
		if($user['point'] >= $membergroup[8]["shengjiedu"])$user['groupid']=9;
		$_data['groupid'] = $user['groupid'];
		$member->where("id='{$user['id']}'")->setField(array('groupid'=>$_data['groupid']));
	}
}
function filter_money($money,$accuracy=2)
{
	$str_ret = 0;
	if (empty($money) === false) {
		$str_ret = sprintf("%.".$accuracy."f", substr(sprintf("%.".($accuracy+1)."f", floatval($money)), 0, -1));
	}

	return floatval($str_ret);
}
function getIpAddress($ip){
	/*$ipContent  = file_get_contents("http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=".$ip);
	$jsonData = explode("=",$ipContent);
	$jsonAddress = substr($jsonData[1], 0, -1);
	return $jsonAddress;*/
}
//分页初始化
function startPage($page){
	//设置分页参数
	$page->setConfig('first','首　页');
	$page->setConfig('prev','上一页');
	$page->setConfig('next','下一页');
	$page->setConfig('last','末　页');
	$page->setConfig('theme', '<span class="pagerows">%HEADER%</span>  <span  class="pagecount">%TOTAL_PAGE%页</span>
%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
}
function clientIP(){   
	$cIP = getenv('REMOTE_ADDR');   
	$cIP1 = getenv('HTTP_X_FORWARDED_FOR');   
	$cIP2 = getenv('HTTP_CLIENT_IP');   
	$cIP1 ? $cIP = $cIP1 : null;   
	$cIP2 ? $cIP = $cIP2 : null;   
	return $cIP;   
}
function object_to_array($obj){
	$_arr = is_object($obj)? get_object_vars($obj) :$obj;
	foreach ($_arr as $key => $val){
		$val=(is_array($val)) || is_object($val) ? object_to_array($val) :$val;
		$arr[$key] = $val;
	}
	return $arr;
}
function serverIP(){   
	return gethostbyname($_SERVER["SERVER_NAME"]);   
}
function rand_strings($len=6,$type=0,$addChars='') {
	$String      = new \Org\Util\String();
	$randString  = $String->randStrings($len,$type,$addChars);
	return $randString;
}
    
function islogin(){

	$sessionid = session('member_sessionid');
	$auth_id   = session('member_auth_id');
	if(!$sessionid || !$auth_id){
		return ['sign'=>false,'message'=>'未登陆','data'=>['islogin'=>0]];
	}
	$apiparam['auth'] = array(
		'member_auth_id'   => $auth_id,
		'member_sessionid' => $sessionid,
	);
	$_api = new \Lib\api;
	$Result = $_api->sendHttpClient('Api/Member/checkislogin',$apiparam);
	if($Result['sign']==true && $Result['data']['islogin']==1){
	//if($Result['sign']==true && $Result['data']['islogin']==1 && $Result['data']['islock']!=1){
		session('userinfo',$Result['data']);
	}else{
		//session('userinfo',NULL);
	}
	unset($Result['data']['banklist']);unset($Result['data']['question']);
	return $Result;
}

function  indexdata(){
    $json = '[
      {
        "id": "43",
        "name": "欧美精品",
        "live": [
          {
            "id": "1038",
            "name": "性感溜冰女孩获得中出",
            "image_link": "/Uploads/file/11.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1041",
            "name": "她真的很喜欢维也纳香肠",
            "image_link": "/Uploads/file/22.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1044",
            "name": "给我一小时",
            "image_link": "/Uploads/file/33.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1047",
            "name": "自然乳房的金发女郎被性交",
            "image_link": "/Uploads/file/44.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1050",
            "name": "肛门冒险",
            "image_link": "/Uploads/file/55.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1053",
            "name": "打赌让她湿了",
            "image_link": "/Uploads/file/66.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1056",
            "name": "瘦身泡热水浴缸的乐趣",
            "image_link": "/Uploads/file/77.jpg",
            "fraction": "9.9"
          },
          {
            "id": "802",
            "name": "ewqeqwvideo_2021-03-06_13-09-13",
            "image_link": "/Uploads/file/88.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1059",
            "name": "Bangin的伴娘",
            "image_link": "/Uploads/file/99.jpg",
            "fraction": "9.9"
          },
          {
            "id": "805",
            "name": "肥大阴唇妹子镜头前掰逼大秀",
            "image_link": "/Uploads/file/1010.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "73",
        "name": "日韩女优",
        "live": [
          {
            "id": "1065",
            "name": "身材不错的师范学妹穿着情趣内衣装，阴毛有些稀疏，被精瘦小伙快速抽插浪叫呻吟",
            "image_link": "/Uploads/file/1111.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1068",
            "name": "极品华裔白嫩女神与大屌洋男友尝试高难姿势 爽得嗷嗷大叫",
            "image_link": "/Uploads/file/1212.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1071",
            "name": "超级美女与男友在酒店交玩足，这颜值让我看得撸了三次",
            "image_link": "/Uploads/file/1313.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1074",
            "name": "穿开档情趣内衣的无毛粉木耳少女和狼友啪啪 然后用苦瓜插穴自慰",
            "image_link": "/Uploads/file/1515.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1077",
            "name": "中年男约了位丰满气质的大奶少妇酒店迫不及待开操,干的相当激烈",
            "image_link": "/Uploads/file/1616.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1080",
            "name": "白嫩美臀骑坐J8呻吟扭动 无套抽插没忍住内射中出淫穴 冰屌插穴",
            "image_link": "/Uploads/file/11.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1083",
            "name": "约炮单位财务部毕业生出纳妹奶子坚挺够大吃JJ很仔细",
            "image_link": "/Uploads/file/22.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1086",
            "name": "丰臀嫩模穿形式各异性感情趣絲襪衣物",
            "image_link": "/Uploads/file/33.jpg",
            "fraction": "9.9"
          },
          {
            "id": "853",
            "name": "玩着电脑游戏老婆非要来惹我不玩游戏了直接玩娘们",
            "image_link": "/Uploads/file/44.jpg",
            "fraction": "9.9"
          },
          {
            "id": "856",
            "name": "红发骚妹找了个粉丝一起来直播但是男的不给力满足不了她",
            "image_link": "/Uploads/file/55.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "34",
        "name": "亚洲无码",
        "live": [
          {
            "id": "1026",
            "name": "处理成熟女人的方式强烈而舒适!!",
            "image_link": "/Uploads/file/66.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1029",
            "name": "回应指令的女人如此面无表情",
            "image_link": "/Uploads/file/77.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1032",
            "name": "玩具责备爱南西！",
            "image_link": "/Uploads/file/88.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1035",
            "name": "33",
            "image_link": "/Uploads/file/99.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1333",
            "name": "搭讪美女大学生约炮",
            "image_link": "/Uploads/file/1010.jpg",
            "fraction": "9.9"
          },
          {
            "id": "823",
            "name": "看着挺清纯的漂亮长发萌妹子全裸漏奶漏逼自慰大秀喜欢不要错过",
            "image_link": "/Uploads/file/1111.jpg",
            "fraction": "9.9"
          },
          {
            "id": "826",
            "name": "骚货出来偷情了",
            "image_link": "/Uploads/file/1212.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1339",
            "name": "性感高挑的美女空姐",
            "image_link": "/Uploads/file/1313.jpg",
            "fraction": "9.9"
          },
          {
            "id": "829",
            "name": "爆乳美少女嫩妹【完具少女】",
            "image_link": "/Uploads/file/1515.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1342",
            "name": "草翻性感E奶肉丝妹",
            "image_link": "/Uploads/file/1616.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "40",
        "name": "国产无码",
        "live": [
          {
            "id": "772",
            "name": "我爱女友实境秀",
            "image_link": "/Uploads/file/11.jpg",
            "fraction": "9.9"
          },
          {
            "id": "775",
            "name": " 紧身裤白衣妹子坐身上摸摸 舔奶掰穴镜头前口交抬腿侧入",
            "image_link": "/Uploads/file/22.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1288",
            "name": "泳装少女_泳装啪啪_口_乘骑_后入_乳推_道具",
            "image_link": "/Uploads/file/33.jpg",
            "fraction": "9.9"
          },
          {
            "id": "778",
            "name": "援交妹子情趣黑丝开档被干大叫爸爸干我用力",
            "image_link": "/Uploads/file/44.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1291",
            "name": "JK美少女  翘臀",
            "image_link": "/Uploads/file/55.jpg",
            "fraction": "9.9"
          },
          {
            "id": "781",
            "name": "这次跟哥们一起尝尝瘦弱高挑的泰国美女",
            "image_link": "/Uploads/file/66.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1294",
            "name": "爆口 粉嫩 二次元少女",
            "image_link": "/Uploads/file/77.jpg",
            "fraction": "9.9"
          },
          {
            "id": "784",
            "name": "小姐姐全程露脸无毛白虎逼",
            "image_link": "/Uploads/file/88.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1297",
            "name": "粉嫩_可爱_蓝白条纹双马尾萌妹_电棒自慰_肉粉粉",
            "image_link": "/Uploads/file/99.jpg",
            "fraction": "9.9"
          },
          {
            "id": "787",
            "name": "皮肤白皙身材不错美乳妹子床上自慰没摸几下就出水高潮直接尿尿",
            "image_link": "/Uploads/file/1010.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "22",
        "name": "热门精选",
        "live": [
          {
            "id": "1282",
            "name": "旅游约炮刚毕业大学女生娜娜",
            "image_link": "/Uploads/file/1111.jpg",
			"video_link": "https://www.super1996.vip/Template/Mobile/video/11111.mp4",
            "fraction": "9.2"
          },
          {
            "id": "1285",
            "name": "高级会所新来的性感气质美女技师，用尽全力干的呻吟大叫!",
            "image_link": "/Uploads/file/1212.jpg",
			"video_link": "https://www.super1996.vip/Template/Mobile/video/11111.mp4",
            "fraction": "9.9"
          }
        ]
      }
    ]';
    return json_decode($json,true);
}
function rmdata(){
    $json = '[
      {
        "id": "43",
        "name": "欧美精品",
        "live": [
          {
            "id": "1038",
            "name": "性感溜冰女孩获得中出",
            "image_link": "/Uploads/file/11.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1041",
            "name": "她真的很喜欢维也纳香肠",
            "image_link": "/Uploads/file/22.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1044",
            "name": "给我一小时",
            "image_link": "/Uploads/file/33.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1047",
            "name": "自然乳房的金发女郎被性交",
            "image_link": "/Uploads/file/44.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1050",
            "name": "肛门冒险",
            "image_link": "/Uploads/file/55.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1053",
            "name": "打赌让她湿了",
            "image_link": "/Uploads/file/66.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1056",
            "name": "瘦身泡热水浴缸的乐趣",
            "image_link": "/Uploads/file/77.jpg",
            "fraction": "9.9"
          },
          {
            "id": "802",
            "name": "ewqeqwvideo_2021-03-06_13-09-13",
            "image_link": "/Uploads/file/88.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1059",
            "name": "Bangin的伴娘",
            "image_link": "/Uploads/file/99.jpg",
            "fraction": "9.9"
          },
          {
            "id": "805",
            "name": "肥大阴唇妹子镜头前掰逼大秀",
            "image_link": "/Uploads/file/1010.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "73",
        "name": "日韩女优",
        "live": [
          {
            "id": "1065",
            "name": "身材不错的师范学妹穿着情趣内衣装，阴毛有些稀疏，被精瘦小伙快速抽插浪叫呻吟",
            "image_link": "/Uploads/file/1111.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1068",
            "name": "极品华裔白嫩女神与大屌洋男友尝试高难姿势 爽得嗷嗷大叫",
            "image_link": "/Uploads/file/1212.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1071",
            "name": "超级美女与男友在酒店交玩足，这颜值让我看得撸了三次",
            "image_link": "/Uploads/file/1313.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1074",
            "name": "穿开档情趣内衣的无毛粉木耳少女和狼友啪啪 然后用苦瓜插穴自慰",
            "image_link": "/Uploads/file/1515.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1077",
            "name": "中年男约了位丰满气质的大奶少妇酒店迫不及待开操,干的相当激烈",
            "image_link": "/Uploads/file/1616.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1080",
            "name": "白嫩美臀骑坐J8呻吟扭动 无套抽插没忍住内射中出淫穴 冰屌插穴",
            "image_link": "/Uploads/file/11.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1083",
            "name": "约炮单位财务部毕业生出纳妹奶子坚挺够大吃JJ很仔细",
            "image_link": "/Uploads/file/22.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1086",
            "name": "丰臀嫩模穿形式各异性感情趣絲襪衣物",
            "image_link": "/Uploads/file/33.jpg",
            "fraction": "9.9"
          },
          {
            "id": "853",
            "name": "玩着电脑游戏老婆非要来惹我不玩游戏了直接玩娘们",
            "image_link": "/Uploads/file/44.jpg",
            "fraction": "9.9"
          },
          {
            "id": "856",
            "name": "红发骚妹找了个粉丝一起来直播但是男的不给力满足不了她",
            "image_link": "/Uploads/file/55.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "34",
        "name": "亚洲无码",
        "live": [
          {
            "id": "1026",
            "name": "处理成熟女人的方式强烈而舒适!!",
            "image_link": "/Uploads/file/66.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1029",
            "name": "回应指令的女人如此面无表情",
            "image_link": "/Uploads/file/77.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1032",
            "name": "玩具责备爱南西！",
            "image_link": "/Uploads/file/88.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1035",
            "name": "33",
            "image_link": "/Uploads/file/99.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1333",
            "name": "搭讪美女大学生约炮",
            "image_link": "/Uploads/file/1010.jpg",
            "fraction": "9.9"
          },
          {
            "id": "823",
            "name": "看着挺清纯的漂亮长发萌妹子全裸漏奶漏逼自慰大秀喜欢不要错过",
            "image_link": "/Uploads/file/1111.jpg",
            "fraction": "9.9"
          },
          {
            "id": "826",
            "name": "骚货出来偷情了",
            "image_link": "/Uploads/file/1212.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1339",
            "name": "性感高挑的美女空姐",
            "image_link": "/Uploads/file/1313.jpg",
            "fraction": "9.9"
          },
          {
            "id": "829",
            "name": "爆乳美少女嫩妹【完具少女】",
            "image_link": "/Uploads/file/1515.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1342",
            "name": "草翻性感E奶肉丝妹",
            "image_link": "/Uploads/file/1616.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "40",
        "name": "国产无码",
        "live": [
          {
            "id": "772",
            "name": "我爱女友实境秀",
            "image_link": "/Uploads/file/11.jpg",
            "fraction": "9.9"
          },
          {
            "id": "775",
            "name": " 紧身裤白衣妹子坐身上摸摸 舔奶掰穴镜头前口交抬腿侧入",
            "image_link": "/Uploads/file/22.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1288",
            "name": "泳装少女_泳装啪啪_口_乘骑_后入_乳推_道具",
            "image_link": "/Uploads/file/33.jpg",
            "fraction": "9.9"
          },
          {
            "id": "778",
            "name": "援交妹子情趣黑丝开档被干大叫爸爸干我用力",
            "image_link": "/Uploads/file/44.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1291",
            "name": "JK美少女  翘臀",
            "image_link": "/Uploads/file/55.jpg",
            "fraction": "9.9"
          },
          {
            "id": "781",
            "name": "这次跟哥们一起尝尝瘦弱高挑的泰国美女",
            "image_link": "/Uploads/file/66.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1294",
            "name": "爆口 粉嫩 二次元少女",
            "image_link": "/Uploads/file/77.jpg",
            "fraction": "9.9"
          },
          {
            "id": "784",
            "name": "小姐姐全程露脸无毛白虎逼",
            "image_link": "/Uploads/file/88.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1297",
            "name": "粉嫩_可爱_蓝白条纹双马尾萌妹_电棒自慰_肉粉粉",
            "image_link": "/Uploads/file/99.jpg",
            "fraction": "9.9"
          },
          {
            "id": "787",
            "name": "皮肤白皙身材不错美乳妹子床上自慰没摸几下就出水高潮直接尿尿",
            "image_link": "/Uploads/file/1010.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "22",
        "name": "热门精选",
        "live": [
          {
            "id": "1282",
            "name": "旅游约炮刚毕业大学女生娜娜",
            "image_link": "/Uploads/file/1111.jpg",
            "fraction": "9.2"
          },
          {
            "id": "1285",
            "name": "高级会所新来的性感气质美女技师，用尽全力干的呻吟大叫!",
            "image_link": "/Uploads/file/1212.jpg",
            "fraction": "9.9"
          }
        ]
      }
    ]';
return json_decode($json,true);
}
function gcdata(){
    $json = '[
      {
        "id": "43",
        "name": "欧美精品",
        "live": [
          {
            "id": "1038",
            "name": "性感溜冰女孩获得中出",
            "image_link": "/Uploads/file/11.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1041",
            "name": "她真的很喜欢维也纳香肠",
            "image_link": "/Uploads/file/22.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1044",
            "name": "给我一小时",
            "image_link": "/Uploads/file/33.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1047",
            "name": "自然乳房的金发女郎被性交",
            "image_link": "/Uploads/file/44.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1050",
            "name": "肛门冒险",
            "image_link": "/Uploads/file/55.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1053",
            "name": "打赌让她湿了",
            "image_link": "/Uploads/file/66.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1056",
            "name": "瘦身泡热水浴缸的乐趣",
            "image_link": "/Uploads/file/77.jpg",
            "fraction": "9.9"
          },
          {
            "id": "802",
            "name": "ewqeqwvideo_2021-03-06_13-09-13",
            "image_link": "/Uploads/file/88.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1059",
            "name": "Bangin的伴娘",
            "image_link": "/Uploads/file/99.jpg",
            "fraction": "9.9"
          },
          {
            "id": "805",
            "name": "肥大阴唇妹子镜头前掰逼大秀",
            "image_link": "/Uploads/file/1010.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "73",
        "name": "日韩女优",
        "live": [
          {
            "id": "1065",
            "name": "身材不错的师范学妹穿着情趣内衣装，阴毛有些稀疏，被精瘦小伙快速抽插浪叫呻吟",
            "image_link": "/Uploads/file/1111.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1068",
            "name": "极品华裔白嫩女神与大屌洋男友尝试高难姿势 爽得嗷嗷大叫",
            "image_link": "/Uploads/file/1212.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1071",
            "name": "超级美女与男友在酒店交玩足，这颜值让我看得撸了三次",
            "image_link": "/Uploads/file/1313.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1074",
            "name": "穿开档情趣内衣的无毛粉木耳少女和狼友啪啪 然后用苦瓜插穴自慰",
            "image_link": "/Uploads/file/1515.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1077",
            "name": "中年男约了位丰满气质的大奶少妇酒店迫不及待开操,干的相当激烈",
            "image_link": "/Uploads/file/1616.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1080",
            "name": "白嫩美臀骑坐J8呻吟扭动 无套抽插没忍住内射中出淫穴 冰屌插穴",
            "image_link": "/Uploads/file/11.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1083",
            "name": "约炮单位财务部毕业生出纳妹奶子坚挺够大吃JJ很仔细",
            "image_link": "/Uploads/file/22.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1086",
            "name": "丰臀嫩模穿形式各异性感情趣絲襪衣物",
            "image_link": "/Uploads/file/33.jpg",
            "fraction": "9.9"
          },
          {
            "id": "853",
            "name": "玩着电脑游戏老婆非要来惹我不玩游戏了直接玩娘们",
            "image_link": "/Uploads/file/44.jpg",
            "fraction": "9.9"
          },
          {
            "id": "856",
            "name": "红发骚妹找了个粉丝一起来直播但是男的不给力满足不了她",
            "image_link": "/Uploads/file/55.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "34",
        "name": "亚洲无码",
        "live": [
          {
            "id": "1026",
            "name": "处理成熟女人的方式强烈而舒适!!",
            "image_link": "/Uploads/file/66.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1029",
            "name": "回应指令的女人如此面无表情",
            "image_link": "/Uploads/file/77.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1032",
            "name": "玩具责备爱南西！",
            "image_link": "/Uploads/file/88.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1035",
            "name": "33",
            "image_link": "/Uploads/file/99.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1333",
            "name": "搭讪美女大学生约炮",
            "image_link": "/Uploads/file/1010.jpg",
            "fraction": "9.9"
          },
          {
            "id": "823",
            "name": "看着挺清纯的漂亮长发萌妹子全裸漏奶漏逼自慰大秀喜欢不要错过",
            "image_link": "/Uploads/file/1111.jpg",
            "fraction": "9.9"
          },
          {
            "id": "826",
            "name": "骚货出来偷情了",
            "image_link": "/Uploads/file/1212.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1339",
            "name": "性感高挑的美女空姐",
            "image_link": "/Uploads/file/1313.jpg",
            "fraction": "9.9"
          },
          {
            "id": "829",
            "name": "爆乳美少女嫩妹【完具少女】",
            "image_link": "/Uploads/file/1515.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1342",
            "name": "草翻性感E奶肉丝妹",
            "image_link": "/Uploads/file/1616.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "40",
        "name": "国产无码",
        "live": [
          {
            "id": "772",
            "name": "我爱女友实境秀",
            "image_link": "/Uploads/file/11.jpg",
            "fraction": "9.9"
          },
          {
            "id": "775",
            "name": " 紧身裤白衣妹子坐身上摸摸 舔奶掰穴镜头前口交抬腿侧入",
            "image_link": "/Uploads/file/22.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1288",
            "name": "泳装少女_泳装啪啪_口_乘骑_后入_乳推_道具",
            "image_link": "/Uploads/file/33.jpg",
            "fraction": "9.9"
          },
          {
            "id": "778",
            "name": "援交妹子情趣黑丝开档被干大叫爸爸干我用力",
            "image_link": "/Uploads/file/44.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1291",
            "name": "JK美少女  翘臀",
            "image_link": "/Uploads/file/55.jpg",
            "fraction": "9.9"
          },
          {
            "id": "781",
            "name": "这次跟哥们一起尝尝瘦弱高挑的泰国美女",
            "image_link": "/Uploads/file/66.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1294",
            "name": "爆口 粉嫩 二次元少女",
            "image_link": "/Uploads/file/77.jpg",
            "fraction": "9.9"
          },
          {
            "id": "784",
            "name": "小姐姐全程露脸无毛白虎逼",
            "image_link": "/Uploads/file/88.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1297",
            "name": "粉嫩_可爱_蓝白条纹双马尾萌妹_电棒自慰_肉粉粉",
            "image_link": "/Uploads/file/99.jpg",
            "fraction": "9.9"
          },
          {
            "id": "787",
            "name": "皮肤白皙身材不错美乳妹子床上自慰没摸几下就出水高潮直接尿尿",
            "image_link": "/Uploads/file/1010.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "22",
        "name": "热门精选",
        "live": [
          {
            "id": "1282",
            "name": "旅游约炮刚毕业大学女生娜娜",
            "image_link": "/Uploads/file/1111.jpg",
            "fraction": "9.2"
          },
          {
            "id": "1285",
            "name": "高级会所新来的性感气质美女技师，用尽全力干的呻吟大叫!",
            "image_link": "/Uploads/file/1212.jpg",
            "fraction": "9.9"
          }
        ]
      }
    ]';
return json_decode($json,true);
}
function rhdata(){
    $json = '[
      {
        "id": "43",
        "name": "欧美精品",
        "live": [
          {
            "id": "1038",
            "name": "性感溜冰女孩获得中出",
            "image_link": "/Uploads/file/11.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1041",
            "name": "她真的很喜欢维也纳香肠",
            "image_link": "/Uploads/file/22.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1044",
            "name": "给我一小时",
            "image_link": "/Uploads/file/33.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1047",
            "name": "自然乳房的金发女郎被性交",
            "image_link": "/Uploads/file/44.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1050",
            "name": "肛门冒险",
            "image_link": "/Uploads/file/55.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1053",
            "name": "打赌让她湿了",
            "image_link": "/Uploads/file/66.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1056",
            "name": "瘦身泡热水浴缸的乐趣",
            "image_link": "/Uploads/file/77.jpg",
            "fraction": "9.9"
          },
          {
            "id": "802",
            "name": "ewqeqwvideo_2021-03-06_13-09-13",
            "image_link": "/Uploads/file/88.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1059",
            "name": "Bangin的伴娘",
            "image_link": "/Uploads/file/99.jpg",
            "fraction": "9.9"
          },
          {
            "id": "805",
            "name": "肥大阴唇妹子镜头前掰逼大秀",
            "image_link": "/Uploads/file/1010.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "73",
        "name": "日韩女优",
        "live": [
          {
            "id": "1065",
            "name": "身材不错的师范学妹穿着情趣内衣装，阴毛有些稀疏，被精瘦小伙快速抽插浪叫呻吟",
            "image_link": "/Uploads/file/1111.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1068",
            "name": "极品华裔白嫩女神与大屌洋男友尝试高难姿势 爽得嗷嗷大叫",
            "image_link": "/Uploads/file/1212.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1071",
            "name": "超级美女与男友在酒店交玩足，这颜值让我看得撸了三次",
            "image_link": "/Uploads/file/1313.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1074",
            "name": "穿开档情趣内衣的无毛粉木耳少女和狼友啪啪 然后用苦瓜插穴自慰",
            "image_link": "/Uploads/file/1515.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1077",
            "name": "中年男约了位丰满气质的大奶少妇酒店迫不及待开操,干的相当激烈",
            "image_link": "/Uploads/file/1616.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1080",
            "name": "白嫩美臀骑坐J8呻吟扭动 无套抽插没忍住内射中出淫穴 冰屌插穴",
            "image_link": "/Uploads/file/11.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1083",
            "name": "约炮单位财务部毕业生出纳妹奶子坚挺够大吃JJ很仔细",
            "image_link": "/Uploads/file/22.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1086",
            "name": "丰臀嫩模穿形式各异性感情趣絲襪衣物",
            "image_link": "/Uploads/file/33.jpg",
            "fraction": "9.9"
          },
          {
            "id": "853",
            "name": "玩着电脑游戏老婆非要来惹我不玩游戏了直接玩娘们",
            "image_link": "/Uploads/file/44.jpg",
            "fraction": "9.9"
          },
          {
            "id": "856",
            "name": "红发骚妹找了个粉丝一起来直播但是男的不给力满足不了她",
            "image_link": "/Uploads/file/55.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "34",
        "name": "亚洲无码",
        "live": [
          {
            "id": "1026",
            "name": "处理成熟女人的方式强烈而舒适!!",
            "image_link": "/Uploads/file/66.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1029",
            "name": "回应指令的女人如此面无表情",
            "image_link": "/Uploads/file/77.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1032",
            "name": "玩具责备爱南西！",
            "image_link": "/Uploads/file/88.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1035",
            "name": "33",
            "image_link": "/Uploads/file/99.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1333",
            "name": "搭讪美女大学生约炮",
            "image_link": "/Uploads/file/1010.jpg",
            "fraction": "9.9"
          },
          {
            "id": "823",
            "name": "看着挺清纯的漂亮长发萌妹子全裸漏奶漏逼自慰大秀喜欢不要错过",
            "image_link": "/Uploads/file/1111.jpg",
            "fraction": "9.9"
          },
          {
            "id": "826",
            "name": "骚货出来偷情了",
            "image_link": "/Uploads/file/1212.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1339",
            "name": "性感高挑的美女空姐",
            "image_link": "/Uploads/file/1313.jpg",
            "fraction": "9.9"
          },
          {
            "id": "829",
            "name": "爆乳美少女嫩妹【完具少女】",
            "image_link": "/Uploads/file/1515.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1342",
            "name": "草翻性感E奶肉丝妹",
            "image_link": "/Uploads/file/1616.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "40",
        "name": "国产无码",
        "live": [
          {
            "id": "772",
            "name": "我爱女友实境秀",
            "image_link": "/Uploads/file/11.jpg",
            "fraction": "9.9"
          },
          {
            "id": "775",
            "name": " 紧身裤白衣妹子坐身上摸摸 舔奶掰穴镜头前口交抬腿侧入",
            "image_link": "/Uploads/file/22.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1288",
            "name": "泳装少女_泳装啪啪_口_乘骑_后入_乳推_道具",
            "image_link": "/Uploads/file/33.jpg",
            "fraction": "9.9"
          },
          {
            "id": "778",
            "name": "援交妹子情趣黑丝开档被干大叫爸爸干我用力",
            "image_link": "/Uploads/file/44.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1291",
            "name": "JK美少女  翘臀",
            "image_link": "/Uploads/file/55.jpg",
            "fraction": "9.9"
          },
          {
            "id": "781",
            "name": "这次跟哥们一起尝尝瘦弱高挑的泰国美女",
            "image_link": "/Uploads/file/66.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1294",
            "name": "爆口 粉嫩 二次元少女",
            "image_link": "/Uploads/file/77.jpg",
            "fraction": "9.9"
          },
          {
            "id": "784",
            "name": "小姐姐全程露脸无毛白虎逼",
            "image_link": "/Uploads/file/88.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1297",
            "name": "粉嫩_可爱_蓝白条纹双马尾萌妹_电棒自慰_肉粉粉",
            "image_link": "/Uploads/file/99.jpg",
            "fraction": "9.9"
          },
          {
            "id": "787",
            "name": "皮肤白皙身材不错美乳妹子床上自慰没摸几下就出水高潮直接尿尿",
            "image_link": "/Uploads/file/1010.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "22",
        "name": "热门精选",
        "live": [
          {
            "id": "1282",
            "name": "旅游约炮刚毕业大学女生娜娜",
            "image_link": "/Uploads/file/1111.jpg",
            "fraction": "9.2"
          },
          {
            "id": "1285",
            "name": "高级会所新来的性感气质美女技师，用尽全力干的呻吟大叫!",
            "image_link": "/Uploads/file/1212.jpg",
            "fraction": "9.9"
          }
        ]
      }
    ]';
return json_decode($json,true);
}
function omdata(){
    $json = '[
      {
        "id": "43",
        "name": "欧美精品",
        "live": [
          {
            "id": "1038",
            "name": "性感溜冰女孩获得中出",
            "image_link": "/Uploads/file/11.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1041",
            "name": "她真的很喜欢维也纳香肠",
            "image_link": "/Uploads/file/22.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1044",
            "name": "给我一小时",
            "image_link": "/Uploads/file/33.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1047",
            "name": "自然乳房的金发女郎被性交",
            "image_link": "/Uploads/file/44.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1050",
            "name": "肛门冒险",
            "image_link": "/Uploads/file/55.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1053",
            "name": "打赌让她湿了",
            "image_link": "/Uploads/file/66.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1056",
            "name": "瘦身泡热水浴缸的乐趣",
            "image_link": "/Uploads/file/77.jpg",
            "fraction": "9.9"
          },
          {
            "id": "802",
            "name": "ewqeqwvideo_2021-03-06_13-09-13",
            "image_link": "/Uploads/file/88.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1059",
            "name": "Bangin的伴娘",
            "image_link": "/Uploads/file/99.jpg",
            "fraction": "9.9"
          },
          {
            "id": "805",
            "name": "肥大阴唇妹子镜头前掰逼大秀",
            "image_link": "/Uploads/file/1010.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "73",
        "name": "日韩女优",
        "live": [
          {
            "id": "1065",
            "name": "身材不错的师范学妹穿着情趣内衣装，阴毛有些稀疏，被精瘦小伙快速抽插浪叫呻吟",
            "image_link": "/Uploads/file/1111.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1068",
            "name": "极品华裔白嫩女神与大屌洋男友尝试高难姿势 爽得嗷嗷大叫",
            "image_link": "/Uploads/file/1212.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1071",
            "name": "超级美女与男友在酒店交玩足，这颜值让我看得撸了三次",
            "image_link": "/Uploads/file/1313.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1074",
            "name": "穿开档情趣内衣的无毛粉木耳少女和狼友啪啪 然后用苦瓜插穴自慰",
            "image_link": "/Uploads/file/1515.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1077",
            "name": "中年男约了位丰满气质的大奶少妇酒店迫不及待开操,干的相当激烈",
            "image_link": "/Uploads/file/1616.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1080",
            "name": "白嫩美臀骑坐J8呻吟扭动 无套抽插没忍住内射中出淫穴 冰屌插穴",
            "image_link": "/Uploads/file/11.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1083",
            "name": "约炮单位财务部毕业生出纳妹奶子坚挺够大吃JJ很仔细",
            "image_link": "/Uploads/file/22.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1086",
            "name": "丰臀嫩模穿形式各异性感情趣絲襪衣物",
            "image_link": "/Uploads/file/33.jpg",
            "fraction": "9.9"
          },
          {
            "id": "853",
            "name": "玩着电脑游戏老婆非要来惹我不玩游戏了直接玩娘们",
            "image_link": "/Uploads/file/44.jpg",
            "fraction": "9.9"
          },
          {
            "id": "856",
            "name": "红发骚妹找了个粉丝一起来直播但是男的不给力满足不了她",
            "image_link": "/Uploads/file/55.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "34",
        "name": "亚洲无码",
        "live": [
          {
            "id": "1026",
            "name": "处理成熟女人的方式强烈而舒适!!",
            "image_link": "/Uploads/file/66.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1029",
            "name": "回应指令的女人如此面无表情",
            "image_link": "/Uploads/file/77.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1032",
            "name": "玩具责备爱南西！",
            "image_link": "/Uploads/file/88.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1035",
            "name": "33",
            "image_link": "/Uploads/file/99.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1333",
            "name": "搭讪美女大学生约炮",
            "image_link": "/Uploads/file/1010.jpg",
            "fraction": "9.9"
          },
          {
            "id": "823",
            "name": "看着挺清纯的漂亮长发萌妹子全裸漏奶漏逼自慰大秀喜欢不要错过",
            "image_link": "/Uploads/file/1111.jpg",
            "fraction": "9.9"
          },
          {
            "id": "826",
            "name": "骚货出来偷情了",
            "image_link": "/Uploads/file/1212.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1339",
            "name": "性感高挑的美女空姐",
            "image_link": "/Uploads/file/1313.jpg",
            "fraction": "9.9"
          },
          {
            "id": "829",
            "name": "爆乳美少女嫩妹【完具少女】",
            "image_link": "/Uploads/file/1515.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1342",
            "name": "草翻性感E奶肉丝妹",
            "image_link": "/Uploads/file/1616.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "40",
        "name": "国产无码",
        "live": [
          {
            "id": "772",
            "name": "我爱女友实境秀",
            "image_link": "/Uploads/file/11.jpg",
            "fraction": "9.9"
          },
          {
            "id": "775",
            "name": " 紧身裤白衣妹子坐身上摸摸 舔奶掰穴镜头前口交抬腿侧入",
            "image_link": "/Uploads/file/22.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1288",
            "name": "泳装少女_泳装啪啪_口_乘骑_后入_乳推_道具",
            "image_link": "/Uploads/file/33.jpg",
            "fraction": "9.9"
          },
          {
            "id": "778",
            "name": "援交妹子情趣黑丝开档被干大叫爸爸干我用力",
            "image_link": "/Uploads/file/44.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1291",
            "name": "JK美少女  翘臀",
            "image_link": "/Uploads/file/55.jpg",
            "fraction": "9.9"
          },
          {
            "id": "781",
            "name": "这次跟哥们一起尝尝瘦弱高挑的泰国美女",
            "image_link": "/Uploads/file/66.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1294",
            "name": "爆口 粉嫩 二次元少女",
            "image_link": "/Uploads/file/77.jpg",
            "fraction": "9.9"
          },
          {
            "id": "784",
            "name": "小姐姐全程露脸无毛白虎逼",
            "image_link": "/Uploads/file/88.jpg",
            "fraction": "9.9"
          },
          {
            "id": "1297",
            "name": "粉嫩_可爱_蓝白条纹双马尾萌妹_电棒自慰_肉粉粉",
            "image_link": "/Uploads/file/99.jpg",
            "fraction": "9.9"
          },
          {
            "id": "787",
            "name": "皮肤白皙身材不错美乳妹子床上自慰没摸几下就出水高潮直接尿尿",
            "image_link": "/Uploads/file/1010.jpg",
            "fraction": "9.9"
          }
        ]
      },
      {
        "id": "22",
        "name": "热门精选",
        "live": [
          {
            "id": "1282",
            "name": "旅游约炮刚毕业大学女生娜娜",
            "image_link": "/Uploads/file/1111.jpg",
            "fraction": "9.2"
          },
          {
            "id": "1285",
            "name": "高级会所新来的性感气质美女技师，用尽全力干的呻吟大叫!",
            "image_link": "/Uploads/file/1212.jpg",
            "fraction": "9.9"
          }
        ]
      }
    ]';
return json_decode($json,true);
}
function videodata(){
    $json = '[{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei01.mp4","id":"1038","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei02.mp4","id":"1041","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei03.mp4","id":"1044","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei04.mp4","id":"1047","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei05.mp4","id":"1050","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei05.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei06.mp4","id":"1053","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei06.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei07.mp4","id":"1056","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei07.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-9oumei\/7-9oumei02.mp4","id":"802","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-9oumei\/7-9oumei02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei08.mp4","id":"1059","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei08.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-9oumei\/7-9oumei03.mp4","id":"805","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-9oumei\/7-9oumei03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan01.mp4","id":"1065","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan02.mp4","id":"1068","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan03.mp4","id":"1071","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan04.mp4","id":"1074","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan05.mp4","id":"1077","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan05.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan06.mp4","id":"1080","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan06.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan07.mp4","id":"1083","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan07.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan08.mp4","id":"1086","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan08.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-9rihan\/7-9rihan01.mp4","id":"853","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-9rihan\/7-9rihan01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-9rihan\/7-9rihan02.mp4","id":"856","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-9rihan\/7-9rihan02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou05.mp4","id":"1026","image_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou05.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou06.mp4","id":"1029","image_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou06.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou07.mp4","id":"1032","image_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou07.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou08.mp4","id":"1035","image_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou08.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/8-16yazhou\/8-16yazhou01.mp4","id":"1333","image_link":"https:\/\/start.91leyuan.top\/qita\/8-16yazhou\/8-16yazhou01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/7-9yazhou\/7-9yazhou01.mp4","id":"823","image_link":"https:\/\/start.91leyuan.top\/qita\/7-9yazhou\/7-9yazhou01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/7-9yazhou\/7-9yazhou02.mp4","id":"826","image_link":"https:\/\/start.91leyuan.top\/qita\/7-9yazhou\/7-9yazhou02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/8-16yazhou\/8-16yazhou03.mp4","id":"1339","image_link":"https:\/\/start.91leyuan.top\/qita\/8-16yazhou\/8-16yazhou03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/7-9yazhou\/7-9yazhou03.mp4","id":"829","image_link":"https:\/\/start.91leyuan.top\/qita\/7-9yazhou\/7-9yazhou03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/8-16yazhou\/8-16yazhou04.mp4","id":"1342","image_link":"https:\/\/start.91leyuan.top\/qita\/8-16yazhou\/8-16yazhou04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan01.mp4","id":"772","image_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan02.mp4","id":"775","image_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan01.mp4","id":"1288","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan03.mp4","id":"778","image_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan02.mp4","id":"1291","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan04.mp4","id":"781","image_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan03.mp4","id":"1294","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan05.mp4","id":"784","image_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan05.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan04.mp4","id":"1297","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan06.mp4","id":"787","image_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan06.jpg"},{"video_link":"http:\/\/start.91leyuan.top\/shouye\/8-16shouye\/8-16shouye01.mp4","id":"1282","image_link":"https:\/\/start.91leyuan.top\/shouye\/8-16shouye\/8-16shouye01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/shouye\/8-16shouye\/8-16shouye02.mp4","id":"1285","image_link":"http:\/\/start.91leyuan.top\/shouye\/8-16shouye\/8-16shouye02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan15.mp4","id":"1468","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan15.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan14.mp4","id":"1465","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan14.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan13.mp4","id":"1462","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan13.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan12.mp4","id":"1459","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan12.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan11.mp4","id":"1456","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan11.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan10.mp4","id":"1453","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan10.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan09.mp4","id":"1450","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan09.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan08.mp4","id":"1447","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan08.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan07.mp4","id":"1444","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan07.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan06.mp4","id":"1441","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan06.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan05.mp4","id":"1438","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan05.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan04.mp4","id":"1435","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan03.mp4","id":"1432","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan02.mp4","id":"1429","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan01.mp4","id":"1426","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan16.mp4","id":"1279","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan16.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan15.mp4","id":"1276","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan15.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan14.mp4","id":"1273","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan14.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan13.mp4","id":"1270","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan13.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan12.mp4","id":"1267","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan12.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei15.mp4","id":"1423","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei15.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei14.mp4","id":"1420","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei14.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei13.mp4","id":"1417","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei13.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei12.mp4","id":"1414","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei12.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei11.mp4","id":"1411","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei11.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei10.mp4","id":"1408","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei10.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei09.mp4","id":"1405","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei09.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei08.mp4","id":"1402","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei08.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei07.mp4","id":"1399","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei07.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei06.mp4","id":"1396","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei06.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei05.mp4","id":"1393","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei05.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei04.mp4","id":"1390","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei03.mp4","id":"1387","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei02.mp4","id":"1384","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei01.mp4","id":"1381","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei16.mp4","id":"1231","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei16.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei15.mp4","id":"1228","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei15.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei14.mp4","id":"1225","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei14.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei13.mp4","id":"1222","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei13.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei12.mp4","id":"1219","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei12.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan15.mp4","id":"1330","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan15.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan14.mp4","id":"1327","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan14.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan13.mp4","id":"1324","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan13.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan12.mp4","id":"1321","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan12.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan11.mp4","id":"1318","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan11.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan10.mp4","id":"1315","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan10.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan09.mp4","id":"1312","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan09.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan08.mp4","id":"1309","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan08.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan07.mp4","id":"1306","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan07.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan06.mp4","id":"1303","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan06.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan05.mp4","id":"1300","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan05.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan04.mp4","id":"1297","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan03.mp4","id":"1294","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan02.mp4","id":"1291","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan01.mp4","id":"1288","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan14.mp4","id":"1180","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan14.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan13.mp4","id":"1177","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan13.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan12.mp4","id":"1174","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan12.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan11.mp4","id":"1171","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan11.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan10.mp4","id":"1168","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan10.jpg"}]';
    return json_decode($json,true);
}

function xuanmei($key){
    $json = '{
        "beijing" : [
            {
                "name": "北京留学生173 5",
                "image_link": "/Template/Mobile/xuanmei/beijing/1-20111521392BG.jpg",
                "fraction": "9.9"
              },
              {
                "name": "北京170D 马甲线 蜜桃臀",
                "image_link": "/Template/Mobile/xuanmei/beijing/1-2010051635329E.jpg",
                "fraction": "9.9"
              },
              {
                "name": "北京身高180D 99年极品模特 5",
                "image_link": "/Template/Mobile/xuanmei/beijing/1-201005163340G8.jpg",
                "fraction": "9.9"
              },
              {
                "name": "北京️171D 真实艺术学院‍ 舞蹈 一",
                "image_link": "/Template/Mobile/xuanmei/beijing/1-200922140K5135.jpg",
                "fraction": "9.9"
              },
              {
                "name": "北京在线淘宝模特167C",
                "image_link": "/Template/Mobile/xuanmei/beijing/1-200922135452532.jpg",
                "fraction": "9.9"
              }
        ],
        "shanghai" : [
            {
                "name": "上海 166E杯 蜜桃臀A4腰  5",
                "image_link": "/Template/Mobile/xuanmei/shanghai/1-201115211451B0.jpg",
                "fraction": "9.9"
              },
              {
                "name": "上海model 净身高180 D（车展，",
                "image_link": "/Template/Mobile/xuanmei/shanghai/1-2011031G345253.jpg",
                "fraction": "9.9"
              },
              {
                "name": "上海.171D平面model  擅长钢琴",
                "image_link": "/Template/Mobile/xuanmei/shanghai/1-2011031G0122F.jpg",
                "fraction": "9.9"
              },
              {
                "name": "上海99年大 身高172 95斤 天然F",
                "image_link": "/Template/Mobile/xuanmei/shanghai/1-2011031FA2362.jpg",
                "fraction": "9.9"
              },
              {
                "name": "上海模特170D 性感翘臀 黄金身材比例",
                "image_link": "/Template/Mobile/xuanmei/shanghai/1-2011031F226406.jpg",
                "fraction": "9.9"
              }
        ],
        "guangzhou" : [
            {
                "name": "广州健身教练",
                "image_link": "/Template/Mobile/xuanmei/guangzhou/1-20111521553X25.jpg",
                "fraction": "9.9"
              },
              {
                "name": "广州 175 D",
                "image_link": "/Template/Mobile/xuanmei/guangzhou/1-201115214959459.jpg",
                "fraction": "9.9"
              },
              {
                "name": "广州双胞胎",
                "image_link": "/Template/Mobile/xuanmei/guangzhou/1-20091213412W94.jpg",
                "fraction": "9.9"
              },
              {
                "name": "广州 168D 98年",
                "image_link": "/Template/Mobile/xuanmei/guangzhou/1-200RR0323U42.jpg",
                "fraction": "9.9"
              },
              {
                "name": "广州海航175D",
                "image_link": "/Template/Mobile/xuanmei/guangzhou/1-200GQZG9256.jpg",
                "fraction": "9.9"
              }
        ],
        "shenzhen" : [
            {
                "name": "深圳 日本人",
                "image_link": "/Template/Mobile/xuanmei/shenzhen/1-201115212435U0.jpg",
                "fraction": "9.9"
              },
              {
                "name": "深圳  00年172e极品网红  5",
                "image_link": "/Template/Mobile/xuanmei/shenzhen/1-201115212009408.jpg",
                "fraction": "9.9"
              },
              {
                "name": "深圳人身高175D 白 乖巧",
                "image_link": "/Template/Mobile/xuanmei/shenzhen/1-201102203144305.jpg",
                "fraction": "9.9"
              }
        ],
        "chengdu" : [
            {
                "name": "成都 176D  ",
                "image_link": "/Template/Mobile/xuanmei/chengdu/1-200FQ95232216.jpg",
                "fraction": "9.9"
              },
              {
                "name": "成都 173E  ",
                "image_link": "/Template/Mobile/xuanmei/chengdu/1-200FQ95155612.jpg",
                "fraction": "9.9"
              },
              {
                "name": "成都 169G  ",
                "image_link": "/Template/Mobile/xuanmei/chengdu/1-200FQ9513O42.jpg",
                "fraction": "9.9"
              }
        ],
        "hangzhou" : [
            {
                "name": "杭州168F  ",
                "image_link": "/Template/Mobile/xuanmei/hangzhou/1-200ZG52Z53I.jpg",
                "fraction": "9.9"
              },
              {
                "name": "杭州极品 净高176/D 车模",
                "image_link": "/Template/Mobile/xuanmei/hangzhou/1-200ZG52P2633.jpg",
                "fraction": "9.9"
              },
              {
                "name": "杭州 170D 5起",
                "image_link": "/Template/Mobile/xuanmei/hangzhou/1-200RR03401K5.jpg",
                "fraction": "9.9"
              }
        ],
        "wuhan" : [
            {
                "name": "武汉 170C",
                "image_link": "/Template/Mobile/xuanmei/wuhan/1-20062H25042331.jpg",
                "fraction": "9.9"
              },
              {
                "name": "武汉 170D",
                "image_link": "/Template/Mobile/xuanmei/wuhan/1-20062H25000J5.jpg",
                "fraction": "9.9"
              },
              {
                "name": "武汉 167D 00年",
                "image_link": "/Template/Mobile/xuanmei/wuhan/1-20062H24925L6.jpg",
                "fraction": "9.9"
              }
        ],
        "tianjin" : [
            {
                "name": "天津 健身教练 气质可爱 168天然E杯",
                "image_link": "/Template/Mobile/xuanmei/tianjin/1-200P31G55M61.jpg",
                "fraction": "9.9"
              },
              {
                "name": "天津  真实身高170cm 胸围E",
                "image_link": "/Template/Mobile/xuanmei/tianjin/1-200P31G031I8.jpg",
                "fraction": "9.9"
              },
              {
                "name": "天津176E，初次抵达，皮肤雪白",
                "image_link": "/Template/Mobile/xuanmei/tianjin/1-200P31F341Z1.jpg",
                "fraction": "9.9"
              }
        ],
        "nanjing" : [
            {
                "name": "南京 173D",
                "image_link": "/Template/Mobile/xuanmei/nanjing/1-200523222914924.jpg",
                "fraction": "9.9"
              },
              {
                "name": "南京 净高177E",
                "image_link": "/Template/Mobile/xuanmei/nanjing/1-2005232223494T.jpg",
                "fraction": "9.9"
              },
              {
                "name": "南京，身高173E 身材苗条",
                "image_link": "/Template/Mobile/xuanmei/nanjing/1-200523221F6102.jpg",
                "fraction": "9.9"
              }
        ],
        "chongqing" : [
            {
                "name": "重庆 171D",
                "image_link": "/Template/Mobile/xuanmei/chongqing/1-20061219335WW.jpg",
                "fraction": "9.9"
              },
              {
                "name": "重庆 170D",
                "image_link": "/Template/Mobile/xuanmei/chongqing/1-200612193341134.jpg",
                "fraction": "9.9"
              },
              {
                "name": "重庆 173D",
                "image_link": "/Template/Mobile/xuanmei/chongqing/1-200612193324133.jpg",
                "fraction": "9.9"
              }
        ],
        "xian" : [
            {
                "name": "西安 172C 90斤 筷子腿 ",
                "image_link": "/Template/Mobile/xuanmei/xian/1-200922134330L6.jpg",
                "fraction": "9.9"
              },
              {
                "name": "西安美院学生 身高170cm_胸围D杯_",
                "image_link": "/Template/Mobile/xuanmei/xian/1-20042R20439B3.jpg",
                "fraction": "9.9"
              },
              {
                "name": "西安 身高175cm_胸围E杯_95年",
                "image_link": "/Template/Mobile/xuanmei/xian/1-20042R20032342.jpg",
                "fraction": "9.9"
              }
        ],
        "changsha" : [
            {
                "name": "长沙 175E  ",
                "image_link": "/Template/Mobile/xuanmei/changsha/1-200FQ95005458.jpg",
                "fraction": "9.9"
              },
              {
                "name": "长沙 173D  ",
                "image_link": "/Template/Mobile/xuanmei/changsha/1-200FQ94945O6.jpg",
                "fraction": "9.9"
              },
              {
                "name": "长沙 165D  ",
                "image_link": "/Template/Mobile/xuanmei/changsha/1-200FQ94UR43.jpg",
                "fraction": "9.9"
              }
        ],
        "qingdao" : [
            {
                "name": "青岛 172D 5起",
                "image_link": "/Template/Mobile/xuanmei/qingdao/1-200RR0351O48.jpg",
                "fraction": "9.9"
              },
              {
                "name": "青岛 172D",
                "image_link": "/Template/Mobile/xuanmei/qingdao/1-200RR03501426.jpg",
                "fraction": "9.9"
              },
              {
                "name": "青岛 172H",
                "image_link": "/Template/Mobile/xuanmei/qingdao/1-200RR03439A6.jpg",
                "fraction": "9.9"
              }
        ],
        "shenyang" : [
            {
                "name": "沈阳 ? 97年 173 D极品  皮肤",
                "image_link": "/Template/Mobile/xuanmei/shenyang/1-1910191IHL20.jpg",
                "fraction": "9.9"
              },
              {
                "name": "沈阳  气质白领长腿 175 D 性格超",
                "image_link": "/Template/Mobile/xuanmei/shenyang/1-1910191I612435.jpg",
                "fraction": "9.9"
              },
              {
                "name": "沈阳 170d 00年沈阳大学学生 清纯",
                "image_link": "/Template/Mobile/xuanmei/shenyang/1-1910191I116308.jpg",
                "fraction": "9.9"
              }
        ],
        "dalian" : [
            {
                "name": "大连172e 气质模特",
                "image_link": "/Template/Mobile/xuanmei/dalian/1-200922133SJ60.jpg",
                "fraction": "9.9"
              },
              {
                "name": "大连音乐学院在校生 175D",
                "image_link": "/Template/Mobile/xuanmei/dalian/1-20051G52FE01.jpg",
                "fraction": "9.9"
              },
              {
                "name": "大连 170C 00 c",
                "image_link": "/Template/Mobile/xuanmei/dalian/1-20051G52412D2.jpg",
                "fraction": "9.9"
              }
        ],
        "xiamen" : [
            {
                "name": "厦门 171F",
                "image_link": "/Template/Mobile/xuanmei/xiamen/1-20062R24U51c.jpg",
                "fraction": "9.9"
              },
              {
                "name": "厦门 171E 99年",
                "image_link": "/Template/Mobile/xuanmei/xiamen/1-20062R24R4M7.jpg",
                "fraction": "9.9"
              },
              {
                "name": "厦门 174D",
                "image_link": "/Template/Mobile/xuanmei/xiamen/1-20062R24K1Q2.jpg",
                "fraction": "9.9"
              }
        ],
        "suzhou" : [
            {
                "name": "苏州 清纯 170D 00年",
                "image_link": "/Template/Mobile/xuanmei/suzhou/1-201004163643L3.jpg",
                "fraction": "9.9"
              },
              {
                "name": "苏州外国 人",
                "image_link": "/Template/Mobile/xuanmei/suzhou/1-2005201GF4Q8.jpg",
                "fraction": "9.9"
              },
              {
                "name": "苏州 ",
                "image_link": "/Template/Mobile/xuanmei/suzhou/1-200512002303613.jpg",
                "fraction": "9.9"
              }
        ],
        "ningbo" : [
            {
                "name": "宁波 170C 01年",
                "image_link": "/Template/Mobile/xuanmei/ningbo/1-200Q623210M09.jpg",
                "fraction": "9.9"
              },
              {
                "name": "宁波 166C 02年",
                "image_link": "/Template/Mobile/xuanmei/ningbo/1-200Q623203T60.jpg",
                "fraction": "9.9"
              },
              {
                "name": "宁波 168D",
                "image_link": "/Template/Mobile/xuanmei/ningbo/1-200Q6232023560.jpg",
                "fraction": "9.9"
              }
        ],
        "wuxi" : [
            {
                "name": "无锡 172E 97年",
                "image_link": "/Template/Mobile/xuanmei/wuxi/1-2006221ZS4616.jpg",
                "fraction": "9.9"
              },
              {
                "name": "无锡 174D 南航",
                "image_link": "/Template/Mobile/xuanmei/wuxi/1-2006221ZKE04.jpg",
                "fraction": "9.9"
              },
              {
                "name": "无锡 170D",
                "image_link": "/Template/Mobile/xuanmei/wuxi/1-2006221ZILD.jpg",
                "fraction": "9.9"
              }
        ],
        "fuzhou" : [
            {
                "name": "福州新人宝宝，169D",
                "image_link": "/Template/Mobile/xuanmei/fuzhou/1-200P51H333511.jpg",
                "fraction": "9.9"
              },
              {
                "name": "福州瑜伽教练，身高168， D胸",
                "image_link": "/Template/Mobile/xuanmei/fuzhou/1-20051319403KX.jpg",
                "fraction": "9.9"
              },
              {
                "name": "福州 170DV 58kg  ",
                "image_link": "/Template/Mobile/xuanmei/fuzhou/1-200513193F2453.jpg",
                "fraction": "9.9"
              }
        ],
        "hefei" : [
            {
                "name": "合肥 173D",
                "image_link": "/Template/Mobile/xuanmei/hefei/1-20062Q111501Z.jpg",
                "fraction": "9.9"
              },
              {
                "name": "合肥 173D",
                "image_link": "/Template/Mobile/xuanmei/hefei/1-20062Q1112b58.jpg",
                "fraction": "9.9"
              },
              {
                "name": "合肥 166E",
                "image_link": "/Template/Mobile/xuanmei/hefei/1-20062Q11109457.jpg",
                "fraction": "9.9"
              }
        ],
        "zhenzhou" : [
            {
                "name": "郑州 175D",
                "image_link": "/Template/Mobile/xuanmei/zhenzhou/1-20060919350A49.jpg",
                "fraction": "9.9"
              },
              {
                "name": " 郑州 168 94斤 21s",
                "image_link": "/Template/Mobile/xuanmei/zhenzhou/1-200609193344939.jpg",
                "fraction": "9.9"
              },
              {
                "name": "郑州 168D",
                "image_link": "/Template/Mobile/xuanmei/zhenzhou/1-2006091932355T.jpg",
                "fraction": "9.9"
              }
        ],
        "haerbing" : [
            {
                "name": "哈尔滨真实模特兼职171前凸后翘",
                "image_link": "/Template/Mobile/xuanmei/haerbing/1-20040422002WB.jpg",
                "fraction": "9.9"
              },
              {
                "name": "哈尔滨170d 00后在校学生",
                "image_link": "/Template/Mobile/xuanmei/haerbing/1-20040421592C46.jpg",
                "fraction": "9.9"
              },
              {
                "name": "哈尔滨.真实00童颜巨乳.168天",
                "image_link": "/Template/Mobile/xuanmei/haerbing/1-200404215559192.jpg",
                "fraction": "9.9"
              }
        ],
        "jinan" : [
            {
                "name": "济南 170D",
                "image_link": "/Template/Mobile/xuanmei/jinan/1-20062Q11H4293.jpg",
                "fraction": "9.9"
              },
              {
                "name": "济南 178D",
                "image_link": "/Template/Mobile/xuanmei/jinan/1-20060QR3422F.jpg",
                "fraction": "9.9"
              },
              {
                "name": "济南 170 G",
                "image_link": "/Template/Mobile/xuanmei/jinan/1-20060QQP41U.jpg",
                "fraction": "9.9"
              }
        ],
        "dongguan" : [
            {
                "name": "东莞 168E",
                "image_link": "/Template/Mobile/xuanmei/dongguan/1-20062Q11JX48.jpg",
                "fraction": "9.9"
              }
        ],
        "kunming" : [
            {
                "name": "昆明舞蹈老师 一枚 170D，身材辣，乖",
                "image_link": "/Template/Mobile/xuanmei/kunming/1-200P31A422648.jpg",
                "fraction": "9.9"
              },
              {
                "name": "昆明新人 168C 兼职开",
                "image_link": "/Template/Mobile/xuanmei/kunming/1-200P31A309301.jpg",
                "fraction": "9.9"
              },
              {
                "name": "昆明 172D 00年",
                "image_link": "/Template/Mobile/xuanmei/kunming/1-20062Q10952129.jpg",
                "fraction": "9.9"
              }
        ],
        "taiyuan" : [
            {
                "name": "太原 170E  ",
                "image_link": "/Template/Mobile/xuanmei/taiyuan/1-200F4233952O9.jpg",
                "fraction": "9.9"
              },
              {
                "name": "太原 178D  ",
                "image_link": "/Template/Mobile/xuanmei/taiyuan/1-200F4233919624.jpg",
                "fraction": "9.9"
              },
              {
                "name": "太原 172E  ",
                "image_link": "/Template/Mobile/xuanmei/taiyuan/1-200F4233TXJ.jpg",
                "fraction": "9.9"
              }
        ],
        "nanchang" : [
            {
                "name": "南昌  166  34e  50kg ",
                "image_link": "/Template/Mobile/xuanmei/nanchang/1-200609191631428.jpg",
                "fraction": "9.9"
              },
              {
                "name": "南昌 170 80E/ 00",
                "image_link": "/Template/Mobile/xuanmei/nanchang/1-200609191551110.jpg",
                "fraction": "9.9"
              },
              {
                "name": "南昌 168D  98年",
                "image_link": "/Template/Mobile/xuanmei/nanchang/1-200609191459206.jpg",
                "fraction": "9.9"
              }
        ],
        "wenzhou" : [
            {
                "name": "温州 170D",
                "image_link": "/Template/Mobile/xuanmei/wenzhou/1-20062Q11643D9.jpg",
                "fraction": "9.9"
              },
              {
                "name": "温州 172C",
                "image_link": "/Template/Mobile/xuanmei/wenzhou/1-20062Q11533927.jpg",
                "fraction": "9.9"
              },
              {
                "name": "温州 170D",
                "image_link": "/Template/Mobile/xuanmei/wenzhou/1-20062Q1150Q00.jpg",
                "fraction": "9.9"
              }
        ],
        "shijiazhuang" : [
            {
                "name": "石家庄 172D 新人",
                "image_link": "/Template/Mobile/xuanmei/shijiazhuang/1-200RR03926333.jpg",
                "fraction": "9.9"
              },
              {
                "name": "石家庄 175D",
                "image_link": "/Template/Mobile/xuanmei/shijiazhuang/1-200RR03ZLD.jpg",
                "fraction": "9.9"
              },
              {
                "name": "石家庄 172D",
                "image_link": "/Template/Mobile/xuanmei/shijiazhuang/1-200RR03U3125.jpg",
                "fraction": "9.9"
              }
        ]
    }';
    $data = json_decode($json,true);
    if(isset($data[$key])){
        return $data[$key];
    }else{
        return $data['beijing'];
    }
}