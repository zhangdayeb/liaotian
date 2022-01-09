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
function rmdata(){
    $json = '[
  {
    "id": "1468",
    "name": "美女扮鬼子进村",
    "image_link": "/rihan/8-16rihan/8-16rihan15.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1465",
    "name": "极品外围御姐情趣网袜啪啪 ",
    "image_link": "/rihan/8-16rihan/8-16rihan14.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1462",
    "name": "第一次拍摄 受过高等教育的清醒女儿",
    "image_link": "/rihan/8-16rihan/8-16rihan13.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1459",
    "name": "成熟的女人 ~ 可耻的滴大乳房丰满的成熟女人 ~",
    "image_link": "/rihan/8-16rihan/8-16rihan12.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1456",
    "name": "约操性感包臀裙美乳少妇 ",
    "image_link": "/rihan/8-16rihan/8-16rihan11.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1453",
    "name": "老婆卖身还债后欲求不满 ",
    "image_link": "/rihan/8-16rihan/8-16rihan10.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1450",
    "name": "Mari 25 岁，性感的好女人，Pakopako 射精！",
    "image_link": "/rihan/8-16rihan/8-16rihan09.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1447",
    "name": "贪婪极品大嫂的肉体 ",
    "image_link": "/rihan/8-16rihan/8-16rihan08.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1444",
    "name": "木崎亮请看我老公淘气",
    "image_link": "/rihan/8-16rihan/8-16rihan07.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1441",
    "name": "一个寡妇被一个shoji后面的shoji拥抱",
    "image_link": "/rihan/8-16rihan/8-16rihan06.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1438",
    "name": "超大奶的妹妹",
    "image_link": "/rihan/8-16rihan/8-16rihan05.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1435",
    "name": "已婚女杀手伊藤丽奈27岁",
    "image_link": "/rihan/8-16rihan/8-16rihan04.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1432",
    "name": "月亮般的三十成熟女人和矛狂欢",
    "image_link": "/rihan/8-16rihan/8-16rihan03.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1429",
    "name": "有很棒的奖励视频！！Buttjob ！！涂有乳液的隐形泳衣！！",
    "image_link": "/rihan/8-16rihan/8-16rihan02.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1426",
    "name": "用淫秽内衣勾引男人",
    "image_link": "/rihan/8-16rihan/8-16rihan01.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1423",
    "name": "大学生当应召女郎",
    "image_link": "/oumei/8-16oumei/8-16oumei15.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1420",
    "name": "自拍性爱美臀秀",
    "image_link": "/oumei/8-16oumei/8-16oumei14.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1417",
    "name": "娼妓模特儿",
    "image_link": "/oumei/8-16oumei/8-16oumei13.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1414",
    "name": "黑丝大屁股美女",
    "image_link": "/oumei/8-16oumei/8-16oumei12.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1411",
    "name": "性感大奶",
    "image_link": "/oumei/8-16oumei/8-16oumei11.jpg",
    "fraction": "9.9"
  }
]';
return json_decode($json,true);
}
function gcdata(){
    $json = '[
  {
    "id": "1330",
    "name": "野战  #强奸 第一人称射精游戏",
    "image_link": "/guochan/8-16guochan/8-16guochan15.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1327",
    "name": "性感长腿女主播 自慰 超温柔 白虎",
    "image_link": "/guochan/8-16guochan/8-16guochan14.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1324",
    "name": "偷情_插得水汪汪_多姿势爆操_丰臀操弄_美穴特写_#轻骑",
    "image_link": "/guochan/8-16guochan/8-16guochan13.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1321",
    "name": "涉世未深的气质漂亮美女大学生被迷晕各种猥亵啪啪啪干完还给穿上裤子当什么事都没发生720P高清",
    "image_link": "/guochan/8-16guochan/8-16guochan12.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1318",
    "name": "多姿势爆操 丰臀操弄 美穴特写高清",
    "image_link": "/guochan/8-16guochan/8-16guochan11.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1315",
    "name": "寂寞难耐到隔壁挑逗屌丝_反被撞爆子宫滚烫精液喷的我衣服都湿了",
    "image_link": "/guochan/8-16guochan/8-16guochan10.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1312",
    "name": "偷情正爽时男友回家_偷偷在他旁边被别人的大鸡巴狂插",
    "image_link": "/guochan/8-16guochan/8-16guochan09.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1309",
    "name": "情趣 性感 巨乳 自慰 AV  少妇",
    "image_link": "/guochan/8-16guochan/8-16guochan08.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1306",
    "name": "老公把上司约到家里喝酒，没想到自己给自己带了绿帽，听话的妻子被动变为主动",
    "image_link": "/guochan/8-16guochan/8-16guochan07.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1303",
    "name": "蕾丝 道具 模拟充气娃娃 无声 内射",
    "image_link": "/guochan/8-16guochan/8-16guochan06.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1300",
    "name": "国产_AV_剧情_后入_射精_尾随漂亮主播到家_强奸",
    "image_link": "/guochan/8-16guochan/8-16guochan05.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1297",
    "name": "粉嫩_可爱_蓝白条纹双马尾萌妹_电棒自慰_肉粉粉",
    "image_link": "/guochan/8-16guochan/8-16guochan04.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1294",
    "name": "爆口 粉嫩 二次元少女",
    "image_link": "/guochan/8-16guochan/8-16guochan03.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1291",
    "name": "JK美少女  翘臀",
    "image_link": "/guochan/8-16guochan/8-16guochan02.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1288",
    "name": "泳装少女_泳装啪啪_口_乘骑_后入_乳推_道具",
    "image_link": "/guochan/8-16guochan/8-16guochan01.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1180",
    "name": "施虐的巨乳女孩想被玩弄！",
    "image_link": "/guochan/8-8guochan/8-8guochan14.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1177",
    "name": "非常感谢 MXX 34 老手高级酒店妹能够搞上吗！？～枕营业也很擅长～ 夏目奈奈",
    "image_link": "/guochan/8-8guochan/8-8guochan13.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1174",
    "name": "毫无客气地享受真实萝莉美女的肉体。",
    "image_link": "/guochan/8-8guochan/8-8guochan12.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1171",
    "name": "被搬来隔壁的巨乳大姐搾乾",
    "image_link": "/guochan/8-8guochan/8-8guochan11.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1168",
    "name": "让人想一口气插到最深处的超色超艳美女:",
    "image_link": "/guochan/8-8guochan/8-8guochan10.jpg",
    "fraction": "9.9"
  }
]';
return json_decode($json,true);
}
function rhdata(){
    $json = '[
  {
    "id": "1468",
    "name": "美女扮鬼子进村",
    "image_link": "/rihan/8-16rihan/8-16rihan15.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1465",
    "name": "极品外围御姐情趣网袜啪啪 ",
    "image_link": "/rihan/8-16rihan/8-16rihan14.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1462",
    "name": "第一次拍摄 受过高等教育的清醒女儿",
    "image_link": "/rihan/8-16rihan/8-16rihan13.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1459",
    "name": "成熟的女人 ~ 可耻的滴大乳房丰满的成熟女人 ~",
    "image_link": "/rihan/8-16rihan/8-16rihan12.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1456",
    "name": "约操性感包臀裙美乳少妇 ",
    "image_link": "/rihan/8-16rihan/8-16rihan11.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1453",
    "name": "老婆卖身还债后欲求不满 ",
    "image_link": "/rihan/8-16rihan/8-16rihan10.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1450",
    "name": "Mari 25 岁，性感的好女人，Pakopako 射精！",
    "image_link": "/rihan/8-16rihan/8-16rihan09.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1447",
    "name": "贪婪极品大嫂的肉体 ",
    "image_link": "/rihan/8-16rihan/8-16rihan08.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1444",
    "name": "木崎亮请看我老公淘气",
    "image_link": "/rihan/8-16rihan/8-16rihan07.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1441",
    "name": "一个寡妇被一个shoji后面的shoji拥抱",
    "image_link": "/rihan/8-16rihan/8-16rihan06.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1438",
    "name": "超大奶的妹妹",
    "image_link": "/rihan/8-16rihan/8-16rihan05.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1435",
    "name": "已婚女杀手伊藤丽奈27岁",
    "image_link": "/rihan/8-16rihan/8-16rihan04.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1432",
    "name": "月亮般的三十成熟女人和矛狂欢",
    "image_link": "/rihan/8-16rihan/8-16rihan03.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1429",
    "name": "有很棒的奖励视频！！Buttjob ！！涂有乳液的隐形泳衣！！",
    "image_link": "/rihan/8-16rihan/8-16rihan02.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1426",
    "name": "用淫秽内衣勾引男人",
    "image_link": "/rihan/8-16rihan/8-16rihan01.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1279",
    "name": "年纪不大奶子不小嫩妹主播和狼友唠嗑 炮友来了开操 很是淫荡",
    "image_link": "/rihan/8-8rihan/8-8rihan16.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1276",
    "name": "一男二女啪啪大秀,女的还很主动,男的可以说是很享受了",
    "image_link": "/rihan/8-8rihan/8-8rihan15.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1273",
    "name": "史上最骚极品骚货小董洁超诱惑口交胯下裹屌",
    "image_link": "/rihan/8-8rihan/8-8rihan14.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1270",
    "name": "居家少妇小娟露脸非常风骚4,给猛男吃屌被道具插入骚穴,激情上位爆草露脸呻吟内射特写骚逼",
    "image_link": "/rihan/8-8rihan/8-8rihan13.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1267",
    "name": "白嫩豪乳神仙姐姐户外凉亭碰到个老司机上来就给舔逼然后再约到树林站着草",
    "image_link": "/rihan/8-8rihan/8-8rihan12.jpg",
    "fraction": "9.9"
  }
]';
return json_decode($json,true);
}
function omdata(){
    $json = '[
  {
    "id": "1423",
    "name": "大学生当应召女郎",
    "image_link": "/oumei/8-16oumei/8-16oumei15.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1420",
    "name": "自拍性爱美臀秀",
    "image_link": "/oumei/8-16oumei/8-16oumei14.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1417",
    "name": "娼妓模特儿",
    "image_link": "/oumei/8-16oumei/8-16oumei13.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1414",
    "name": "黑丝大屁股美女",
    "image_link": "/oumei/8-16oumei/8-16oumei12.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1411",
    "name": "性感大奶",
    "image_link": "/oumei/8-16oumei/8-16oumei11.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1408",
    "name": "少女的监狱生活",
    "image_link": "/oumei/8-16oumei/8-16oumei10.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1405",
    "name": "他妈的梦幻女孩",
    "image_link": "/oumei/8-16oumei/8-16oumei09.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1402",
    "name": "邻家少女",
    "image_link": "/oumei/8-16oumei/8-16oumei08.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1399",
    "name": "年轻又性感自拍 7",
    "image_link": "/oumei/8-16oumei/8-16oumei07.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1396",
    "name": "大屌男孩們-Ashlynn Brooke 珍藏版",
    "image_link": "/oumei/8-16oumei/8-16oumei06.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1393",
    "name": "有趣的生活方式",
    "image_link": "/oumei/8-16oumei/8-16oumei05.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1390",
    "name": "33",
    "image_link": "/oumei/8-16oumei/8-16oumei04.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1387",
    "name": "超级性感的杰西卡摩尔",
    "image_link": "/oumei/8-16oumei/8-16oumei03.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1384",
    "name": "拉伸她的屁股",
    "image_link": "/oumei/8-16oumei/8-16oumei02.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1381",
    "name": "加利福尼亚女孩崇拜巨大的黑色迪克",
    "image_link": "/oumei/8-16oumei/8-16oumei01.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1231",
    "name": "逼毛性感的制服护士姐姐圣水沐浴鸡巴专治阳痿不举",
    "image_link": "/oumei/8-8oumei/8-8oumei16.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1228",
    "name": "HD小情侣沙发做爱 完事后不过瘾妹子自慰 最后直播了洗澡",
    "image_link": "/oumei/8-8oumei/8-8oumei15.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1225",
    "name": "超级性感校花",
    "image_link": "/oumei/8-8oumei/8-8oumei14.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1222",
    "name": "马来全日大学校花与男友不雅视频流出 无套插馒头逼",
    "image_link": "/oumei/8-8oumei/8-8oumei13.jpg",
    "fraction": "9.9"
  },
  {
    "id": "1219",
    "name": "白嫩性感美女情趣裝全裸艷舞手淫秀",
    "image_link": "/oumei/8-8oumei/8-8oumei12.jpg",
    "fraction": "9.9"
  }
]';
return json_decode($json,true);
}
function videodata(){
    $json = '[{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei01.mp4","id":"1038","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei02.mp4","id":"1041","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei03.mp4","id":"1044","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei04.mp4","id":"1047","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei05.mp4","id":"1050","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei05.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei06.mp4","id":"1053","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei06.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei07.mp4","id":"1056","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei07.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-9oumei\/7-9oumei02.mp4","id":"802","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-9oumei\/7-9oumei02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei08.mp4","id":"1059","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-25oumei\/7-25oumei08.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/7-9oumei\/7-9oumei03.mp4","id":"805","image_link":"https:\/\/start.91leyuan.top\/oumei\/7-9oumei\/7-9oumei03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan01.mp4","id":"1065","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan02.mp4","id":"1068","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan03.mp4","id":"1071","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan04.mp4","id":"1074","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan05.mp4","id":"1077","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan05.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan06.mp4","id":"1080","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan06.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan07.mp4","id":"1083","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan07.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan08.mp4","id":"1086","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-25rihan\/7-25rihan08.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-9rihan\/7-9rihan01.mp4","id":"853","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-9rihan\/7-9rihan01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/7-9rihan\/7-9rihan02.mp4","id":"856","image_link":"https:\/\/start.91leyuan.top\/rihan\/7-9rihan\/7-9rihan02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou05.mp4","id":"1026","image_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou05.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou06.mp4","id":"1029","image_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou06.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou07.mp4","id":"1032","image_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou07.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou08.mp4","id":"1035","image_link":"https:\/\/start.91leyuan.top\/qita\/7-25yazhou\/7-25yazhou08.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/8-16yazhou\/8-16yazhou01.mp4","id":"1333","image_link":"https:\/\/start.91leyuan.top\/qita\/8-16yazhou\/8-16yazhou01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/7-9yazhou\/7-9yazhou01.mp4","id":"823","image_link":"https:\/\/start.91leyuan.top\/qita\/7-9yazhou\/7-9yazhou01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/7-9yazhou\/7-9yazhou02.mp4","id":"826","image_link":"https:\/\/start.91leyuan.top\/qita\/7-9yazhou\/7-9yazhou02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/8-16yazhou\/8-16yazhou03.mp4","id":"1339","image_link":"https:\/\/start.91leyuan.top\/qita\/8-16yazhou\/8-16yazhou03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/7-9yazhou\/7-9yazhou03.mp4","id":"829","image_link":"https:\/\/start.91leyuan.top\/qita\/7-9yazhou\/7-9yazhou03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/qita\/8-16yazhou\/8-16yazhou04.mp4","id":"1342","image_link":"https:\/\/start.91leyuan.top\/qita\/8-16yazhou\/8-16yazhou04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan01.mp4","id":"772","image_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan02.mp4","id":"775","image_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan01.mp4","id":"1288","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan03.mp4","id":"778","image_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan02.mp4","id":"1291","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan04.mp4","id":"781","image_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan03.mp4","id":"1294","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan05.mp4","id":"784","image_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan05.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan04.mp4","id":"1297","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan06.mp4","id":"787","image_link":"https:\/\/start.91leyuan.top\/guochan\/7-9guochan\/7-9guochan06.jpg"},{"video_link":"http:\/\/start.91leyuan.top\/shouye\/8-16shouye\/8-16shouye01.mp4","id":"1282","image_link":"https:\/\/start.91leyuan.top\/shouye\/8-16shouye\/8-16shouye01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/shouye\/8-16shouye\/8-16shouye02.mp4","id":"1285","image_link":"http:\/\/start.91leyuan.top\/shouye\/8-16shouye\/8-16shouye02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan15.mp4","id":"1468","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan15.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan14.mp4","id":"1465","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan14.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan13.mp4","id":"1462","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan13.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan12.mp4","id":"1459","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan12.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan11.mp4","id":"1456","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan11.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan10.mp4","id":"1453","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan10.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan09.mp4","id":"1450","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan09.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan08.mp4","id":"1447","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan08.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan07.mp4","id":"1444","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan07.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan06.mp4","id":"1441","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan06.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan05.mp4","id":"1438","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan05.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan04.mp4","id":"1435","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan03.mp4","id":"1432","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan02.mp4","id":"1429","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan01.mp4","id":"1426","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-16rihan\/8-16rihan01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan16.mp4","id":"1279","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan16.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan15.mp4","id":"1276","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan15.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan14.mp4","id":"1273","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan14.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan13.mp4","id":"1270","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan13.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan12.mp4","id":"1267","image_link":"https:\/\/start.91leyuan.top\/rihan\/8-8rihan\/8-8rihan12.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei15.mp4","id":"1423","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei15.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei14.mp4","id":"1420","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei14.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei13.mp4","id":"1417","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei13.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei12.mp4","id":"1414","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei12.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei11.mp4","id":"1411","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei11.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei10.mp4","id":"1408","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei10.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei09.mp4","id":"1405","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei09.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei08.mp4","id":"1402","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei08.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei07.mp4","id":"1399","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei07.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei06.mp4","id":"1396","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei06.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei05.mp4","id":"1393","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei05.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei04.mp4","id":"1390","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei03.mp4","id":"1387","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei02.mp4","id":"1384","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei01.mp4","id":"1381","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-16oumei\/8-16oumei01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei16.mp4","id":"1231","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei16.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei15.mp4","id":"1228","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei15.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei14.mp4","id":"1225","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei14.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei13.mp4","id":"1222","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei13.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei12.mp4","id":"1219","image_link":"https:\/\/start.91leyuan.top\/oumei\/8-8oumei\/8-8oumei12.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan15.mp4","id":"1330","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan15.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan14.mp4","id":"1327","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan14.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan13.mp4","id":"1324","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan13.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan12.mp4","id":"1321","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan12.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan11.mp4","id":"1318","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan11.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan10.mp4","id":"1315","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan10.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan09.mp4","id":"1312","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan09.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan08.mp4","id":"1309","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan08.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan07.mp4","id":"1306","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan07.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan06.mp4","id":"1303","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan06.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan05.mp4","id":"1300","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan05.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan04.mp4","id":"1297","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan04.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan03.mp4","id":"1294","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan03.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan02.mp4","id":"1291","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan02.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan01.mp4","id":"1288","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-16guochan\/8-16guochan01.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan14.mp4","id":"1180","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan14.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan13.mp4","id":"1177","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan13.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan12.mp4","id":"1174","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan12.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan11.mp4","id":"1171","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan11.jpg"},{"video_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan10.mp4","id":"1168","image_link":"https:\/\/start.91leyuan.top\/guochan\/8-8guochan\/8-8guochan10.jpg"}]';
    return json_decode($json,true);
}