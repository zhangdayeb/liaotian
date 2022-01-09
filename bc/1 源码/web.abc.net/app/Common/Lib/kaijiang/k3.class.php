<?php
namespace Lib\kaijiang;
class k3{
	/*
	** 二维数组
	** $params 二维数组
	** 字段列表 必须包含
	** typeid 彩票种类（ssc,k3,Game,kl10f,pk10,keno,xy28）
	** playid 玩法标识
	** opencode 开奖号码
	** tzcode 投注号码
	*/
	function __construct($params = []){
		$this->params = $params;
	}
	function check(){
		$params = $this->params;
		foreach($params as $pk=>$param){
			$playid = '';
			$playid = $param['playid'];
			$zjcount = 0;
			if(method_exists($this,$playid)){
				$zjcount = self::$playid($param['opencode'],$param['tzcode']);
			}
			$param['zjcount'] = $zjcount;
			$params[$pk] = $param;
		}
		return $params;
	}
	/*
	** 二同号复选
	*/
	protected function k3ethfx($opencode,$tzcode){
		$opencodes = explode(',',$opencode);
		$tzcodes   = explode('#',$tzcode);
		sort($opencodes);
		$zjcount   = 0;
		foreach($tzcodes as $k=>$v){
			if(substr_count(implode('',$opencodes),$v) && strlen($v)==2 && substr($v,0,1)==substr($v,-1)){
				$zjcount++;
			}
		}
		return $zjcount;
	}
	/*
	** 二同号单选
	*/
	protected function k3ethdx($opencode,$tzcode){
		$opencodes = explode(',',$opencode);
		$tzcodes   = explode('#',$tzcode);
		$acs       = array_count_values($opencodes);
		sort($opencodes);
		$zjcount   = 0;
		foreach($tzcodes as $k=>$v){
			$array = [];
			$array = str_split($v,1);
			sort($array);
			if(count($acs)==2 && count($array)==3 && substr_count(implode('',$opencodes),implode('',$array))){
				$zjcount = 1;
			}
		}
		return $zjcount;
	}
	/*
	** 二不同号标准
	*/
	protected function k3ebthbz($opencode,$tzcode){
		$opencodes = explode(',',$opencode);
		$tzcodes   = explode('#',$tzcode);
		//$combinations = self::combination($tzcodes,2);
		$zjcount   = 0;
		foreach($tzcodes as $k=>$v){
			if(count(array_diff(explode(',',$v),$opencodes))==0 && count(array_unique(explode(',',$v)))==2){
				$zjcount++;
			}
			/*if(in_array($v[0],$opencodes) && in_array($v[1],$opencodes) && $v[0]!=$v[1]){
				$tzcodes++;
			}*/
		}
		return $zjcount;
	}
	/*
	** 三同号单选
	*/
	protected function k3sthdx($opencode,$tzcode){
		$opencodes = explode(',',$opencode);
		$tzcodes   = explode('#',$tzcode);
		sort($opencodes);
		$zjcount   = 0;
		foreach($tzcodes as $k=>$v){
			if(strlen($v)==3 && $v==implode('',$opencodes) && count(array_unique($opencodes))==1){
				$zjcount++;
			}
		}
		return $zjcount;
	}
	/*
	** 三同号通选
	*/
	protected function k3sthtx($opencode,$tzcode){
		$opencodes = explode(',',$opencode);
		//$tzcodes   = explode(',',$tzcode);
		$zjcount   = 0;
		if(count(array_unique($opencodes))==1 && $tzcode=='三同号通选'){
			$zjcount = 1;
		}
		return $zjcount;
	}
	/*
	** 三不同号标准
	*/
	protected function k3sbthbz($opencode,$tzcode){
		$opencodes = explode(',',$opencode);
		$tzcodes   = explode('#',$tzcode);
		//$combinations = self::combination($tzcodes,3);
		$zjcount   = 0;
		foreach($tzcodes as $k=>$v){
			if(count(array_diff(explode(',',$v),$opencodes))==0){
				$zjcount++;
			}
			/*if(in_array($v[0],$opencodes) && in_array($v[1],$opencodes) && $v[0]!=$v[1]){
				$tzcodes++;
			}*/
		}
		return $zjcount;
	}
	
	/*
	** 三连号通选
	*/
	protected function k3slhtx($opencode,$tzcode){
		$opencodes = explode(',',$opencode);
		//$tzcodes   = explode('|',$tzcode);
		sort($opencodes);
		$zjcount   = 0;
		if(abs($opencodes[1]-$opencodes[0])==1 && abs($opencodes[1]-$opencodes[2])==1 && count(array_unique($opencodes))==3 && $tzcode=='三连号通选'){
			$zjcount   = 1;
		}
		return $zjcount;
	}
	/*
	** 三连号单选
	*/
	protected function k3slhdx($opencode,$tzcode){
		$opencodes = explode(',',$opencode);
		$tzcodes   = explode('#',$tzcode);
		sort($opencodes);
		$opcodestr = implode('',$opencodes);
		$zjcount   = 0;
		if(in_array($opcodestr,$tzcodes) && count(array_unique($opencodes))==3 && abs($opencodes[1]-$opencodes[0])==1 && abs($opencodes[1]-$opencodes[2])==1){
			$zjcount   = 1;
		}
		return $zjcount;
	}
	/*
	** 和值
	*/
	protected function k3hz3($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==3 && $tzcode==3){$zjcount=1;};return $zjcount;
	}
	protected function k3hz4($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==4 && $tzcode==4){$zjcount=1;};return $zjcount;
	}
	protected function k3hz5($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==5 && $tzcode==5){$zjcount=1;};return $zjcount;
	}
	protected function k3hz6($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==6 && $tzcode==6){$zjcount=1;};return $zjcount;
	}
	protected function k3hz7($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==7 && $tzcode==7){$zjcount=1;};return $zjcount;
	}
	protected function k3hz8($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==8 && $tzcode==8){$zjcount=1;};return $zjcount;
	}
	protected function k3hz9($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==9 && $tzcode==9){$zjcount=1;};return $zjcount;
	}
	protected function k3hz10($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==10 && $tzcode==10){$zjcount=1;};return $zjcount;
	}
	protected function k3hz11($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==11 && $tzcode==11){$zjcount=1;};return $zjcount;
	}
	protected function k3hz12($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==12 && $tzcode==12){$zjcount=1;};return $zjcount;
	}
	protected function k3hz13($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==13 && $tzcode==13){$zjcount=1;};return $zjcount;
	}
	protected function k3hz14($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==14 && $tzcode==14){$zjcount=1;};return $zjcount;
	}
	protected function k3hz15($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==15 && $tzcode==15){$zjcount=1;};return $zjcount;
	}
	protected function k3hz16($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==16 && $tzcode==16){$zjcount=1;};return $zjcount;
	}
	protected function k3hz17($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==17 && $tzcode==17){$zjcount=1;};return $zjcount;
	}
	protected function k3hz18($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum==18 && $tzcode==18){$zjcount=1;};return $zjcount;
	}
	protected function k3hzbig($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum>10 && $tzcode=='大'){$zjcount=1;};return $zjcount;
	}
	protected function k3hzsmall($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum<=10 && $tzcode=='小'){$zjcount=1;};return $zjcount;
	}
	protected function k3hzeven($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum%2==0 && $tzcode=='双'){$zjcount=1;};return $zjcount;
	}
	protected function k3hzodd($opencode,$tzcode){
		$opencodes = explode(',',$opencode);$sum = array_sum($opencodes);$zjcount   = 0;if($sum%2!=0 && $tzcode=='单'){$zjcount=1;};return $zjcount;
	}

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