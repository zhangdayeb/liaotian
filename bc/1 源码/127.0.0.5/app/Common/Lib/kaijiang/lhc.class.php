<?php
namespace Lib\kaijiang;
class lhc{
	/*
	 * //六合彩
	** 二维数组
	** $params 二维数组
	** 字段列表 必须包含
	** typeid 彩票种类（ssc,k3,Game,kl10f,pk10,keno,xy28,lhc）
	** playid 玩法标识
	** opencode 开奖号码
	** tzcode 投注号码
	*/
	public $_lhcsx = array();
	function __construct($params = []){
		$this->params = $params;
        $time = strtotime('2018-02-15 21:30:00');
		/*if(time()>$time){  //六合彩2018生肖表
			$this->_lhcsx = [
				"鼠" => ['11','23','35','47'],
				'牛' => ['10','22','34','46'],
				"虎" => ['09','21','33','45'],
				"兔" => ['08','20','32','44'],
				"龙" => ['07','19','31','43'],
				"蛇" => ['06','18','30','42'],
				"马" => ['05','17','29','41'],
				"羊" => ['04','16','28','40'],
				"猴" => ['03','15','27','39'],
				"鸡" => ['02','14','26','38'],
				"狗" => ['01','13','25','37','49'],
				"猪" => ['12','24','36','48']
			];
		}else{ //六合彩2017生肖表
			$this->_lhcsx = [
				"鼠" => ['10','22','34','46'],
				'牛' => ['09','21','33','45'],
				"虎" => ['08','20','32','44'],
				"兔" => ['07','19','31','43'],
				"龙" => ['06','18','30','42'],
				"蛇" => ['05','17','29','41'],
				"马" => ['04','16','28','40'],
				"羊" => ['03','15','27','39'],
				"猴" => ['02','14','26','38'],
				"鸡" => ['01','13','25','37','49'],
				"狗" => ['12','24','36','48'],
				"猪" => ['11','23','35','47']
			];
		}*/
		$this->_lhcsx = [
						 '鼠'=>['12','24','36','48'],
						 '牛'=>['11','23','35','47'],
                         '虎'=>['10','22','34','46'],
						 '兔'=>['09','21','33','45'],
                         '龙'=>['08','20','32','44'],
						 '蛇'=>['07','19','31','43'],
                         '马'=>['06','18','30','42'],
						 '羊'=>['05','17','29','41'],
                         '猴'=>['04','16','28','40'],
						 '鸡'=>['03','15','27','39'],
                         '狗'=>['02','14','26','38'],
						 '猪'=>['01','13','25','37','49'],
						];

		$this->_lhcerwl = [
			"0尾" => ['10','20','30','40'],
			'1尾' => ['01','11','21','31','41'],
			"2尾" => ['02','12','22','32','42'],
			"3尾" => ['03','13','23','33','43'],
			"4尾" => ['04','14','24','34','44'],
			"5尾" => ['05','15','25','35','45'],
			"6尾" => ['06','16','26','36','46'],
			"7尾" => ['07','17','27','37','47'],
			"8尾" => ['08','18','28','38','48'],
			"9尾" => ['09','19','29','39','49'],
		];

	}

	//特码直选
	function tmzx($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if(strstr($tzcode,$opencodes[6])){
			$zjcount++;
		};
		return $zjcount;
	}
	//任选
	function zmrx($opencode,$tzcode){
		$tzcodes = explode(',',$tzcode);
		$opencodes = array_slice(explode(',',$opencode),0,-1);
		$zjcount = count(array_intersect($tzcodes,$opencodes));
		return $zjcount;
	}
	//正1特
	function zm1t($opencode,$tzcode){
		$opencodes = explode(',',$opencode);
		return $this->zmnt($opencodes[0],$tzcode);
	}
	//正2特
	function zm2t($opencode,$tzcode){
		$opencodes = explode(',',$opencode);
		return $this->zmnt($opencodes[1],$tzcode);
	}
	//正3特
	function zm3t($opencode,$tzcode){
		$opencodes = explode(',',$opencode);
		return $this->zmnt($opencodes[2],$tzcode);
	}
	//正4特
	function zm4t($opencode,$tzcode){
		$opencodes = explode(',',$opencode);
		return $this->zmnt($opencodes[3],$tzcode);
	}
	//正5特
	function zm5t($opencode,$tzcode){
		$opencodes = explode(',',$opencode);
		return $this->zmnt($opencodes[4],$tzcode);
	}
	//正6特
	function zm6t($opencode,$tzcode){
		$opencodes = explode(',',$opencode);
		return $this->zmnt($opencodes[5],$tzcode);
	}
	function zmnt($opencode,$tzcode){
		$zjcount = 0;
		if(strstr($tzcode,$opencode)){
			$zjcount++;
		}
		return $zjcount;
	}
	//三全中
	function lm3qz($opencode,$tzcode){
		$zjcount = 0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = array_slice(explode(',',$opencode),0,-1);
		$combination = $this->combination($tzcodes,3);
		foreach($combination as $v){
			if(count(array_diff($opencodes,$v))==3){
				$zjcount++;
			}
		}
		return $zjcount;
	}
	//三中二
	function lm3z2($opencode,$tzcode){
		$zjcount1 = $zjcount2=0;
		$tzcodes = explode(',',$tzcode);
		$opencode1 = array_slice(explode(',',$opencode),0,-1);
		$opencode2 = explode(',',$opencode);
		$combination1 = $this->combination($tzcodes,2);
		$combination2 = $this->combination($tzcodes,3);
		foreach($combination1 as $v){
			if(count(array_diff($opencode1,$v))==4){
				$zjcount1++;
			}
		}
		foreach($combination2 as $v){
			if(count(array_diff($opencode2,$v))==4){
				$zjcount2++;
			}
		}
		if($zjcount1==0 && $zjcount2==0){      //全不中
			  $zjcount = 0;
		}elseif($zjcount1!=0 && $zjcount2!=0){ //全中
			$zjcount[0] = 0;
			$zjcount[1] = $zjcount2;
		}else{
			$zjcount[0] = $zjcount1;    //一个中
			$zjcount[1] = $zjcount2;
		}
		return $zjcount;
	}
	//二全中
	function lm2qz($opencode,$tzcode){
		$zjcount = 0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = array_slice(explode(',',$opencode),0,-1);
		$combination = $this->combination($tzcodes,2);
		foreach($combination as $v){
			if(count(array_diff($opencodes,$v))==4){
				$zjcount++;
			}
		}
		return $zjcount;
	}
	//二中特
	function lm2zt($opencode,$tzcode){
		$zjcount = [];
		$zjcount1 = $zjcount2=0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = explode(',',$opencode);
		$combination = $this->combination($tzcodes,2);
		foreach($combination as $v){
			if(count(array_diff($opencodes,$v))==5){
				if(!in_array($opencodes[6],$v)){
					$zjcount1++;  //中二
				}else{
					$zjcount2++;  //中特
				}
			}
		}
		if($zjcount1==0 && $zjcount2==0){       //全不中
			$zjcount = 0;
		}elseif($zjcount1!=0 && $zjcount2!=0){  //全中
			$zjcount[0] = 0;
			$zjcount[1] = $zjcount2;
		}else{
			$zjcount[0] = $zjcount1;            //一个中
			$zjcount[1] = $zjcount2;
		}
		return $zjcount;
	}
	//特串
	function lmtc($opencode,$tzcode){
		$zjcount = 0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = explode(',',$opencode);
		$combination = $this->combination($tzcodes,2);
		foreach($combination as $v){
			if(count(array_diff($opencodes,$v))==5){
				if(in_array($opencodes[6],$v)){
					$zjcount++;
				}
			}
		}
		return $zjcount;
	}
	//红大
	function hongda($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="红大")return $zjcount;
		$hongda = ['29','30','34','35','40','45','46'];
		if(in_array($opencodes[6],$hongda)){
			$zjcount++;
		}
		return $zjcount;
	}
	//红小
	function hongxiao($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="红小")return $zjcount;
		$hongxiao = ['01','02','07','08','12','13','18','19','23','24'];
		if(in_array($opencodes[6],$hongxiao)){
			$zjcount++;
		}
		return $zjcount;
	}
	//红单
	function hongdan($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="红单")return $zjcount;
		$hongdan = ['01','07','13','19','23','29','35','45'];
		if(in_array($opencodes[6],$hongdan)){
			$zjcount++;
		}
		return $zjcount;
	}
	//红双
	function hongshuang($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="红双")return $zjcount;
		$hongshuang = ['02','08','12','18','24','30','34','40','46'];
		if(in_array($opencodes[6],$hongshuang)){
			$zjcount++;
		}
		return $zjcount;
	}
	//红合单
	function honghedan($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="红合单")return $zjcount;
		$honghedan = ['07','12','18','23','29','30','34','45'];
		if(in_array($opencodes[6],$honghedan)){
			$zjcount++;
		}
		return $zjcount;
	}
	//红合双
	function hongheshuang($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="红合双")return $zjcount;
		$hongheshuang = ['02','08','13','19','24','35','40','46'];
		if(in_array($opencodes[6],$hongheshuang)){
			$zjcount++;
		}
		return $zjcount;
	}
	//绿大
	function lvda($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="绿大")return $zjcount;
		$lvda = ['27','28','32','33','38','39','43','44','49'];
		if(in_array($opencodes[6],$lvda)){
			$zjcount++;
		}
		return $zjcount;
	}
	//绿小
	function lvxiao($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="绿小")return $zjcount;
		$lvxiao = ['05','06','11','16','17','21','22'];
		if(in_array($opencodes[6],$lvxiao)){
			$zjcount++;
		}
		return $zjcount;
	}
	//绿单
	function lvdan($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="绿单")return $zjcount;
		$lvdan = ['05','11','17','21','27','33','39','43','49'];
		if(in_array($opencodes[6],$lvdan)){
			$zjcount++;
		}
		return $zjcount;
	}
	//绿双
	function lvshuang($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="绿双")return $zjcount;
		$lvshuang = ['06','16','22','28','32','38','44'];
		if(in_array($opencodes[6],$lvshuang)){
			$zjcount++;
		}
		return $zjcount;
	}
	//绿合单
	function lvhedan($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="绿合单")return $zjcount;
		$lvhedan = ['05','16','21','27','32','38','43','49'];
		if(in_array($opencodes[6],$lvhedan)){
			$zjcount++;
		}
		return $zjcount;
	}
	//绿合双
	function lvheshuang($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="绿合双")return $zjcount;
		$lvheshuang = ['06','11','17','22','28','33','39','44'];
		if(in_array($opencodes[6],$lvheshuang)){
			$zjcount++;
		}
		return $zjcount;
	}
	//蓝大
	function landa($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="蓝大")return $zjcount;
		$landa = ['25','26','31','36','37','41','42','47','48'];
		if(in_array($opencodes[6],$landa)){
			$zjcount++;
		}
		return $zjcount;
	}
	//蓝小
	function lanxiao($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="蓝小")return $zjcount;
		$lanxiao = ['03','04','09','10','14','15','20'];
		if(in_array($opencodes[6],$lanxiao)){
			$zjcount++;
		}
		return $zjcount;
	}
	//蓝单
	function landan($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="蓝单")return $zjcount;
		$landan = ['03','09','15','25','31','37','41','47'];
		if(in_array($opencodes[6],$landan)){
			$zjcount++;
		}
		return $zjcount;
	}
	//蓝双
	function lanshuang($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="蓝双")return $zjcount;
		$lanshuang = ['04','10','14','20','26','36','42','48'];
		if(in_array($opencodes[6],$lanshuang)){
			$zjcount++;
		}
		return $zjcount;
	}
	//蓝合单
	function lanhedan($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="蓝合单")return $zjcount;
		$lanhedan = ['03','09','10','14','25','36','41','47'];
		if(in_array($opencodes[6],$lanhedan)){
			$zjcount++;
		}
		return $zjcount;
	}
	//蓝合双
	function lanheshuang($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="蓝合双")return $zjcount;
		$lanheshuang =['04','15','20','26','31','37','42','48'];
		if(in_array($opencodes[6],$lanheshuang)){
			$zjcount++;
		}
		return $zjcount;
	}
	//特肖鼠
	function sxtxshu($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="鼠")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcsx['鼠'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//特肖牛
	function sxtxniu($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="牛")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcsx['牛'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//特肖虎
	function sxtxhu($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="虎")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcsx['虎'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//特肖兔
	function sxtxtu($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="兔")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcsx['兔'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//特肖龙
	function sxtxlong($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="龙")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcsx['龙'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//特肖蛇
	function sxtxshe($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="蛇")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcsx['蛇'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//特肖马
	function sxtxma($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="马")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcsx['马'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//特肖羊
	function sxtxyang($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="羊")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcsx['羊'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//特肖猴
	function sxtxhou($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="猴")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcsx['猴'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//特肖鸡
	function sxtxji($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="鸡")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcsx['鸡'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//特肖狗
	function sxtxgou($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="狗")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcsx['狗'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//特肖猪
	function sxtxzhu($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="猪")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcsx['猪'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//一肖鼠
	function sx1xshu($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="鼠")return $zjcount;
		foreach ($this->_lhcsx['鼠'] as $v){
			if(in_array($v,$opencodes)){
				$zjcount++;
				break;
			}
		}
		return $zjcount;
	}
	//一肖牛
	function sx1xniu($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="牛")return $zjcount;
		foreach ($this->_lhcsx['牛'] as $v){
			if(in_array($v,$opencodes)){
				$zjcount++;
				break;
			}
		}
		return $zjcount;
	}
	//一肖虎
	function sx1xhu($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="虎")return $zjcount;
		foreach ($this->_lhcsx['虎'] as $v){
			if(in_array($v,$opencodes)){
				$zjcount++;
				break;
			}
		}
		return $zjcount;
	}
	//一肖兔
	function sx1xtu($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="兔")return $zjcount;
		foreach ($this->_lhcsx['兔'] as $v){
			if(in_array($v,$opencodes)){
				$zjcount++;
				break;
			}
		}
		return $zjcount;
	}
	//一肖龙
	function sx1xlong($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="龙")return $zjcount;
		foreach ($this->_lhcsx['龙'] as $v){
			if(in_array($v,$opencodes)){
				$zjcount++;
				break;
			}
		}
		return $zjcount;
	}
	//一肖蛇
	function sx1xshe($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="蛇")return $zjcount;
		foreach ($this->_lhcsx['蛇'] as $v){
			if(in_array($v,$opencodes)){
				$zjcount++;
				break;
			}
		}
		return $zjcount;
	}
	//一肖马
	function sx1xma($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="马")return $zjcount;
		foreach ($this->_lhcsx['马'] as $v){
			if(in_array($v,$opencodes)){
				$zjcount++;
				break;
			}
		}
		return $zjcount;
	}
	//一肖羊
	function sx1xyang($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="羊")return $zjcount;
		foreach ($this->_lhcsx['羊'] as $v){
			if(in_array($v,$opencodes)){
				$zjcount++;
				break;
			}
		}
		return $zjcount;
	}
	//一肖猴
	function sx1xhou($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="猴")return $zjcount;
		foreach ($this->_lhcsx['猴'] as $v){
			if(in_array($v,$opencodes)){
				$zjcount++;
				break;
			}
		}
		return $zjcount;
	}
	//一肖鸡
	function sx1xji($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="鸡")return $zjcount;
		foreach ($this->_lhcsx['鸡'] as $v){
			if(in_array($v,$opencodes)){
				$zjcount++;
				break;
			}
		}
		return $zjcount;
	}
	//一肖狗
	function sx1xgou($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="狗")return $zjcount;
		foreach ($this->_lhcsx['狗'] as $v){
			if(in_array($v,$opencodes)){
				$zjcount++;
				break;
			}
		}
		return $zjcount;
	}
	//一肖猪
	function sx1xzhu($opencode,$tzcode){
		$zjcount = 0;
		$opencodes = explode(',',$opencode);
		if($tzcode!="猪")return $zjcount;
		foreach ($this->_lhcsx['猪'] as $v){
			if(in_array($v,$opencodes)){
				$zjcount++;
				break;
			}
		}
		return $zjcount;
	}
	//二肖连
	function sx2xl($opencode,$tzcode){
		$zjcount1 = $zjcount2 = 0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = explode(',',$opencode);
		$combination = $this->combination($tzcodes,2);
		foreach ($combination as $v){
			$count1 = count($this->_lhcsx[$v[0]]);
			$count2 = count($this->_lhcsx[$v[1]]);
			if($count1==5 or $count2==5) {
				if (count(array_diff($this->_lhcsx[$v[0]], $opencodes)) < $count1 && count(array_diff($this->_lhcsx[$v[1]], $opencodes)) < $count2) {
					$zjcount1++;
				};
			}else{
				if (count(array_diff($this->_lhcsx[$v[0]], $opencodes)) < $count1 && count(array_diff($this->_lhcsx[$v[1]], $opencodes)) < $count2) {
					$zjcount2++;
				};
			}

		}
		if($zjcount1==0 && $zjcount2==0){   //全不中
			$zjcount = 0;
		}else{
			$zjcount[0] = $zjcount1;            //一个中
			$zjcount[1] = $zjcount2;
		}
		return $zjcount;
	}
	//三肖连
	function sx3xl($opencode,$tzcode){
		$zjcount1 = $zjcount2 = 0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = explode(',',$opencode);
		$combination = $this->combination($tzcodes,3);
		foreach ($combination as $v){
			$count1 = count($this->_lhcsx[$v[0]]);
			$count2 = count($this->_lhcsx[$v[1]]);
			$count3 = count($this->_lhcsx[$v[2]]);
			if($count1==5 or $count2==5 or $count3==5) {
				if (count(array_diff($this->_lhcsx[$v[0]], $opencodes))<$count1 && count(array_diff($this->_lhcsx[$v[1]], $opencodes))<$count2 && count(array_diff($this->_lhcsx[$v[2]], $opencodes))<$count3) {
					$zjcount1++;
				};
			}else{
				if (count(array_diff($this->_lhcsx[$v[0]], $opencodes))<$count1 && count(array_diff($this->_lhcsx[$v[1]], $opencodes))<$count2 && count(array_diff($this->_lhcsx[$v[2]], $opencodes))<$count3 ) {
					$zjcount2++;
				};
		   }
		}
			if($zjcount1==0 && $zjcount2==0){       //全不中
				$zjcount = 0;
			}else{
				$zjcount[0] = $zjcount1;            //一个中
				$zjcount[1] = $zjcount2;
			}
		return $zjcount;
	}
	//四肖连
	function sx4xl($opencode,$tzcode){
		$zjcount1 = $zjcount2 = 0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = explode(',',$opencode);
		$combination = $this->combination($tzcodes,4);
		foreach ($combination as $v){
				$count1 = count($this->_lhcsx[$v[0]]);
				$count2 = count($this->_lhcsx[$v[1]]);
				$count3 = count($this->_lhcsx[$v[2]]);
				$count4 = count($this->_lhcsx[$v[3]]);
			if($count1==5 or $count2==5 or $count3==5 or $count4==5) {
				if (count(array_diff($this->_lhcsx[$v[0]], $opencodes))<$count1 && count(array_diff($this->_lhcsx[$v[1]], $opencodes))<$count2 && count(array_diff($this->_lhcsx[$v[2]], $opencodes))<$count3 && count(array_diff($this->_lhcsx[$v[3]], $opencodes))<$count4) {
			        $zjcount1++;
				};
			}else{
				if (count(array_diff($this->_lhcsx[$v[0]], $opencodes))<$count1 && count(array_diff($this->_lhcsx[$v[1]], $opencodes))<$count2 && count(array_diff($this->_lhcsx[$v[2]], $opencodes))<$count3 && count(array_diff($this->_lhcsx[$v[3]], $opencodes))<$count4 ) {
					$zjcount2++;
				};
			}
		}
		if($zjcount1==0 && $zjcount2==0){       //全不中
			$zjcount = 0;
		}else{
			$zjcount[0] = $zjcount1;            //一个中
			$zjcount[1] = $zjcount2;
		}
		return $zjcount;
	}
	//0头
	function lingtou($opencode,$tzcode){
		$zjcount = 0;$opencodes = explode(',',$opencode);
		if($tzcode!="0头")return $zjcount;
		$lingtou = ['01','02','03','04','05','06','07','08','09'];
		if(in_array($opencodes[6],$lingtou)){
			$zjcount++;
		}
		return $zjcount;
	}
	//1头
	function yitou($opencode,$tzcode){
		$zjcount = 0;$opencodes = explode(',',$opencode);
		if($tzcode!="1头")return $zjcount;
		$yitou = ['10','11','12','13','14','15','16','17','18','19'];
		if(in_array($opencodes[6],$yitou)){
			$zjcount++;
		}
		return $zjcount;
	}
	//2头
	function ertou($opencode,$tzcode){
		$zjcount = 0;$opencodes = explode(',',$opencode);
		if($tzcode!="2头")return $zjcount;
		$ertou = ['20','21','22','23','24','25','26','27','28','29'];
		if(in_array($opencodes[6],$ertou)){
			$zjcount++;
		}
		return $zjcount;
	}
	//3头
	function santou($opencode,$tzcode){
		$zjcount = 0;$opencodes = explode(',',$opencode);
		if($tzcode!="3头")return $zjcount;
		$santou = ['30','31','32','33','34','35','36','37','38','39'];
		if(in_array($opencodes[6],$santou)){
			$zjcount++;
		}
		return $zjcount;
	}
	//4头
	function sitou($opencode,$tzcode){
		$zjcount = 0;$opencodes = explode(',',$opencode);
		if($tzcode!="4头")return $zjcount;
		$sitou = ['40','41','42','43','44','45','46','47','48','49'];
		if(in_array($opencodes[6],$sitou)){
			$zjcount++;
		}
		return $zjcount;
	}
	//0尾
	function lingwei($opencode,$tzcode){
		$zjcount = 0;$opencodes = explode(',',$opencode);
		if($tzcode!="0尾")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcerwl['0尾'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//1尾
	function yiwei($opencode,$tzcode){
		$zjcount = 0;$opencodes = explode(',',$opencode);
		if($tzcode!="1尾")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcerwl['1尾'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//2尾
	function erwei($opencode,$tzcode){
		$zjcount = 0;$opencodes = explode(',',$opencode);
		if($tzcode!="2尾")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcerwl['2尾'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//3尾
	function sanwei($opencode,$tzcode){
		$zjcount = 0;$opencodes = explode(',',$opencode);
		if($tzcode!="3尾")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcerwl['3尾'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//4尾
	function siwei($opencode,$tzcode){
		$zjcount = 0;$opencodes = explode(',',$opencode);
		if($tzcode!="4尾")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcerwl['4尾'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//5尾
	function wuwei($opencode,$tzcode){
		$zjcount = 0;$opencodes = explode(',',$opencode);
		if($tzcode!="5尾")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcerwl['5尾'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//6尾
	function liuwei($opencode,$tzcode){
		$zjcount = 0;$opencodes = explode(',',$opencode);
		if($tzcode!="6尾")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcerwl['6尾'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//7尾
	function qiwei($opencode,$tzcode){
		$zjcount = 0;$opencodes = explode(',',$opencode);
		if($tzcode!="7尾")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcerwl['7尾'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//8尾
	function bawei($opencode,$tzcode){
		$zjcount = 0;$opencodes = explode(',',$opencode);
		if($tzcode!="8尾")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcerwl['8尾'])){
			$zjcount++;
		}
		return $zjcount;
	}
	//9尾
	function jiuwei($opencode,$tzcode){
		$zjcount = 0;$opencodes = explode(',',$opencode);
		if($tzcode!="9尾")return $zjcount;
		if(in_array($opencodes[6],$this->_lhcerwl['9尾'])){
			$zjcount++;
		}
		return $zjcount;
	}

	//二尾连
	function ws2wl($opencode,$tzcode){
		$zjcount1 = $zjcount2 = 0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = explode(',',$opencode);
		$combination = $this->combination($tzcodes,2);
		foreach ($combination as $v){
					$count1 = count($this->_lhcerwl[$v[0]]);
					$count2 = count($this->_lhcerwl[$v[1]]);
					if($count1==4 or $count2==4){
						if (count(array_diff($this->_lhcerwl[$v[0]], $opencodes)) < $count1 && count(array_diff($this->_lhcerwl[$v[1]], $opencodes)) < $count2) {
                           $zjcount1++;
						};
					}else{
						if (count(array_diff($this->_lhcerwl[$v[0]], $opencodes)) < $count1 && count(array_diff($this->_lhcerwl[$v[1]], $opencodes)) < $count2) {
						     $zjcount2++;
						};
			       }
		}
		if($zjcount1==0 && $zjcount2==0){       //全不中
			$zjcount = 0;
		}else{
			$zjcount[0] = $zjcount1;            //一个中
			$zjcount[1] = $zjcount2;
		}
		return $zjcount;
	}
	//三尾连
	function ws3wl($opencode,$tzcode){
		$zjcount1 = $zjcount2 = 0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = explode(',',$opencode);
		$combination = $this->combination($tzcodes,3);
		foreach ($combination as $v){
			$count1 = count($this->_lhcerwl[$v[0]]);
			$count2 = count($this->_lhcerwl[$v[1]]);
			$count3 = count($this->_lhcerwl[$v[2]]);
			if($count1==4 or $count2==4){
				if (count(array_diff($this->_lhcerwl[$v[0]], $opencodes)) < $count1 && count(array_diff($this->_lhcerwl[$v[1]], $opencodes)) < $count2 && count(array_diff($this->_lhcerwl[$v[2]], $opencodes)) < $count3) {
					$zjcount1++;
				};
			}else{
				if (count(array_diff($this->_lhcerwl[$v[0]], $opencodes)) < $count1 && count(array_diff($this->_lhcerwl[$v[1]], $opencodes)) < $count2 && count(array_diff($this->_lhcerwl[$v[2]], $opencodes)) < $count3) {
					$zjcount2++;
				};
			}
		}

		if($zjcount1==0 && $zjcount2==0){       //全不中
			$zjcount = 0;
		}else{
			$zjcount[0] = $zjcount1;            //一个中
			$zjcount[1] = $zjcount2;
		}
		return $zjcount;
	}
	//四尾连
	function ws4wl($opencode,$tzcode){
		$zjcount1 = $zjcount2 = 0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = explode(',',$opencode);
		$combination = $this->combination($tzcodes,4);
		foreach ($combination as $v){
			$count1 = count($this->_lhcerwl[$v[0]]);
			$count2 = count($this->_lhcerwl[$v[1]]);
			$count3 = count($this->_lhcerwl[$v[2]]);
			$count4 = count($this->_lhcerwl[$v[3]]);
			if($count1==4 or $count2==4){
				if (count(array_diff($this->_lhcerwl[$v[0]], $opencodes)) < $count1 && count(array_diff($this->_lhcerwl[$v[1]], $opencodes)) < $count2 && count(array_diff($this->_lhcerwl[$v[2]], $opencodes)) < $count3 && count(array_diff($this->_lhcerwl[$v[3]], $opencodes)) < $count4) {
					$zjcount1++;
				};
			}else{
				if (count(array_diff($this->_lhcerwl[$v[0]], $opencodes)) < $count1 && count(array_diff($this->_lhcerwl[$v[1]], $opencodes)) < $count2 && count(array_diff($this->_lhcerwl[$v[2]], $opencodes)) < $count3 && count(array_diff($this->_lhcerwl[$v[3]], $opencodes)) < $count4) {
 					$zjcount2++;
				};
			}
		}
		if($zjcount1==0 && $zjcount2==0){       //全不中
			$zjcount = 0;
		}else{
			$zjcount[0] = $zjcount1;            //一个中
			$zjcount[1] = $zjcount2;
		}
		return $zjcount;
	}
	//五不中
	function bz5bz($opencode,$tzcode){
		$zjcount=0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = explode(',',$opencode);
		$combination = $this->combination($tzcodes,5);
		foreach($combination as $v){
			if(count(array_diff($v,$opencodes))==5){
				$zjcount++;
			}
		}
		return $zjcount;
	}
	//六不中
	function bz6bz($opencode,$tzcode){
		$zjcount=0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = explode(',',$opencode);
		$combination = $this->combination($tzcodes,6);
		foreach($combination as $v){
			if(count(array_diff($v,$opencodes))==6){
				$zjcount++;
			}
		}
		return $zjcount;
	}
	//七不中
	function bz7bz($opencode,$tzcode){
		$zjcount=0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = explode(',',$opencode);
		$combination = $this->combination($tzcodes,7);
		foreach($combination as $v){
			if(count(array_diff($v,$opencodes))==7){
 				$zjcount++;
			}
		}
		return $zjcount;
	}
	//八不中
	function bz8bz($opencode,$tzcode){
		$zjcount=0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = explode(',',$opencode);
		$combination = $this->combination($tzcodes,8);
		foreach($combination as $v){
			if(count(array_diff($v,$opencodes))==8){
				$zjcount++;
			}
		}
		return $zjcount;
	}
	//九不中
	function bz9bz($opencode,$tzcode){
		$zjcount=0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = explode(',',$opencode);
		$combination = $this->combination($tzcodes,9);
		foreach($combination as $v){
			if(count(array_diff($v,$opencodes))==9){
				$zjcount++;
			}
		}
		return $zjcount;
	}
	//十不中
	function bz10bz($opencode,$tzcode){
		$zjcount=0;
		$tzcodes = explode(',',$tzcode);
		$opencodes = explode(',',$opencode);
		$combination = $this->combination($tzcodes,10);
		foreach($combination as $v){
			if(count(array_diff($v,$opencodes))==10){
				$zjcount++;
			}
		}
		return $zjcount;
	}

/*以下是特码两面,正1两面,正2两面,正3两面,正4两面,正5两面,正6两面,*/
	//大
	function tmlmda($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="大" or $opencode ==49)return $zjcount;
		if($opencode>=25){
			$zjcount++;
		}
		return $zjcount;
	}
	//小
	function tmlmxiao($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="小" or $opencode==49)return $zjcount;
		if($opencode<=24){
			$zjcount++;
		}
		return $zjcount;
	}
	//单
	function tmlmdan($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="单" or $opencode==49)return $zjcount;
		if($opencode%2==1){
			$zjcount++;
		}
		return $zjcount;
	}
	//双
	function tmlmshuang($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="双" or $opencode==49)return $zjcount;
		if($opencode%2==0){
			$zjcount++;
		}
		return $zjcount;
	}
	//大单
	function tmlmdadan($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="大单" or $opencode==49)return $zjcount;
		if($opencode%2==1&&$opencode>=25){
			$zjcount++;
		}
		return $zjcount;
	}
	//大双
	function tmlmdashuang($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="大双" or $opencode==49)return $zjcount;
		if($opencode%2==0 && $opencode>=25){
			$zjcount++;
		}
		return $zjcount;
	}
	//小单
	function tmlmxiaodan($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="小单" or $opencode==49)return $zjcount;
		if($opencode%2==1 && $opencode<=24){
			$zjcount++;
		}
		return $zjcount;
	}
	//小双
	function tmlmxiaoshuang($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="小双" or $opencode==49)return $zjcount;
		if($opencode%2==0 && $opencode<=24){
			$zjcount++;
		}
		return $zjcount;
	}
	//合大
	function tmlmheda($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="合大" or $opencode==49)return $zjcount;
		$no1=substr($opencode,0,1);$no2=substr($opencode,1,1);
		$num = $no1+$no2;
		if($num>6){
			$zjcount++;
		}
		return $zjcount;
	}
	//合小
	function tmlmhexiao($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="合小" or $opencode==49)return $zjcount;
		$no1=substr($opencode,0,1);$no2=substr($opencode,1,1);
		$num = $no1+$no2;
		if($num<=6){
			$zjcount++;
		}
		return $zjcount;
	}
	//合单
	function tmlmhedan($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="合单" or $opencode==49)return $zjcount;
		$no1=substr($opencode,0,1);$no2=substr($opencode,1,1);
		$num = $no1+$no2;
		if($num%2==1){
			$zjcount++;
		}
		return $zjcount;
	}
	//合双
	function tmlmheshuang($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="合双" or $opencode==49)return $zjcount;
		$no1=substr($opencode,0,1);$no2=substr($opencode,1,1);
		$num = $no1+$no2;
		if($num%2==0){
			$zjcount++;
		}
		return $zjcount;
	}
	//尾大
	function tmlmweida($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="尾大" or $opencode==49)return $zjcount;
		$num=substr($opencode,1,1);
		if($num>4){
			$zjcount++;
		}
		return $zjcount;
	}
	//尾小
	function tmlmweixiao($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="尾小" or $opencode==49)return $zjcount;
		$num=substr($opencode,1,1);
		if($num<=4){
			$zjcount++;
		}
		return $zjcount;
	}
	//红波
	function tmlmhongbo($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="红波")return $zjcount;
		$hongbo = ['01','02','07','08','12','13','18','19','23','24','29','30','34','35','40','45','46'];
		if(in_array($opencode,$hongbo)){
			$zjcount++;
		}
		return $zjcount;
	}
	//绿波
	function tmlmlvbo($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="绿波")return $zjcount;
		$lvbo = ['05','06','11','16','17','21','22','27','28','32','33','38','39','43','44','49'];
		if(in_array($opencode,$lvbo)){
			$zjcount++;
		}
		return $zjcount;
	}
	//蓝波
	function tmlmlanbo($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="蓝波")return $zjcount;
		$lanbo = ['03','04','09','10','14','15','20','25','26','31','36','37','41','42','47','48'];
		if(in_array($opencode,$lanbo)){
			$zjcount++;
		}
		return $zjcount;
	}
	//家禽
	function tmlmjiaqin($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="家禽")return $zjcount;
		$jiaqin =  array_merge($this->_lhcsx['牛'],$this->_lhcsx['马'],$this->_lhcsx['羊'],$this->_lhcsx['鸡'],$this->_lhcsx['狗'],$this->_lhcsx['猪']);
 		if(in_array($opencode,$jiaqin)){
			$zjcount++;
		}
		return $zjcount;
	}
	//野兽
	function tmlmyeshou($opencode,$tzcode){
		$zjcount = 0;
        $opencodes = explode(',',$opencode);
        $opencode = $opencodes[6];
		if($tzcode!="野兽")return $zjcount;
		$yeshou = array_merge($this->_lhcsx['鼠'],$this->_lhcsx['虎'],$this->_lhcsx['兔'],$this->_lhcsx['龙'],$this->_lhcsx['蛇'],$this->_lhcsx['猴']);
		if(in_array($opencode,$yeshou)){
			$zjcount++;
		}
		return $zjcount;
	}
/*特码两面,正1两面,正2两面,正3两面,正4两面,正5两面,正6两面,结束*/


	// 阶乘
	protected function factorial($n) {
		return array_product(range(1, $n));
	}

	// 排列数
	protected function A($n, $m) {
		return self::factorial($n)/self::factorial($n-$m);
	}

	// 组合数
	protected function C($n, $m) {
		return self::A($n, $m)/self::factorial($m);
	}
	// 排列
	protected function arrangement($a, $m) {
		$r = array();

		$n = count($a);
		if ($m <= 0 || $m > $n) {
			return $r;
		}

		for ($i=0; $i<$n; $i++) {
			$b = $a;
			$t = array_splice($b, $i, 1);
			if ($m == 1) {
				$r[] = $t;
			} else {
				$c = self::arrangement($b, $m-1);
				foreach ($c as $v) {
					$r[] = array_merge($t, $v);
				}
			}
		}

		return $r;
	}
	// 组合
	protected function combination($a, $m) {
		$r = array();

		$n = count($a);
		if ($m <= 0 || $m > $n) {
			return $r;
		}

		for ($i=0; $i<$n; $i++) {
			$t = array($a[$i]);
			if ($m == 1) {
				$r[] = $t;
			} else {
				$b = array_slice($a, $i+1);
				$c = self::combination($b, $m-1);
				foreach ($c as $v) {
					$r[] = array_merge($t, $v);
				}
			}
		}

		return $r;
	}
}
?>