<?php
namespace Lib\lotterytimes;
class cqssc {
	function drawtimes(){
		$name = 'cqssc';
		$cjnowtime = 0;
		$nowtime = time() + $cjnowtime;
		$total  = 120;
		$openstart  = '00:04:00';
		$jgtime = 300;
		$yctime = 0;
		$_yct = ceil($yctime/$total);
/*		$array = array();
		for($i=1;$i<=$total;$i++){
			$start = strtotime($openstart)-$jgtime + ($i-1)*$jgtime + ($i-1)*$_yct;
			$end = strtotime($openstart)+($i-1)*$jgtime + ($_yct*$i);
			$draws[$i] = array('start'=>date('H:i:s',$start),'end'=>date('H:i:s',$end));
		}
		$draws[1]['start'] = date('Y-m-d H:i:s',strtotime($draws[$total]['end'])-86400);*/
		$draws = array(
			'1'=>array('start'=>'00:00:00','end'=>'00:05:00'),
			'2'=>array('start'=>'00:05:00','end'=>'00:10:00'),
			'3'=>array('start'=>'00:10:00','end'=>'00:15:00'),
			'4'=>array('start'=>'00:15:00','end'=>'00:20:00'),
			'5'=>array('start'=>'00:20:00','end'=>'00:25:00'),
			'6'=>array('start'=>'00:25:00','end'=>'00:30:00'),
			'7'=>array('start'=>'00:30:00','end'=>'00:35:00'),
			'8'=>array('start'=>'00:35:00','end'=>'00:40:00'),
			'9'=>array('start'=>'00:40:00','end'=>'00:45:00'),
			'10'=>array('start'=>'00:45:00','end'=>'00:50:00'),
			'11'=>array('start'=>'00:50:00','end'=>'00:55:00'),
			'12'=>array('start'=>'00:55:00','end'=>'01:00:00'),
			'13'=>array('start'=>'01:00:00','end'=>'01:05:00'),
			'14'=>array('start'=>'01:05:00','end'=>'01:10:00'),
			'15'=>array('start'=>'01:10:00','end'=>'01:15:00'),
			'16'=>array('start'=>'01:15:00','end'=>'01:20:00'),
			'17'=>array('start'=>'01:20:00','end'=>'01:25:00'),
			'18'=>array('start'=>'01:25:00','end'=>'01:30:00'),
			'19'=>array('start'=>'01:30:00','end'=>'01:35:00'),
			'20'=>array('start'=>'01:35:00','end'=>'01:40:00'),
			'21'=>array('start'=>'01:40:00','end'=>'01:45:00'),
			'22'=>array('start'=>'01:45:00','end'=>'01:50:00'),
			'23'=>array('start'=>'01:50:00','end'=>'01:55:00'),
			'24'=>array('start'=>'01:55:00','end'=>'10:00:00'),
			'25'=>array('start'=>'10:00:00','end'=>'10:10:00'),
			'26'=>array('start'=>'10:10:00','end'=>'10:20:00'),
			'27'=>array('start'=>'10:20:00','end'=>'10:30:00'),
			'28'=>array('start'=>'10:30:00','end'=>'10:40:00'),
			'29'=>array('start'=>'10:40:00','end'=>'10:50:00'),
			'30'=>array('start'=>'10:50:00','end'=>'11:00:00'),
			'31'=>array('start'=>'11:00:00','end'=>'11:10:00'),
			'32'=>array('start'=>'11:10:00','end'=>'11:20:00'),
			'33'=>array('start'=>'11:20:00','end'=>'11:30:00'),
			'34'=>array('start'=>'11:30:00','end'=>'11:40:00'),
			'35'=>array('start'=>'11:40:00','end'=>'11:50:00'),
			'36'=>array('start'=>'11:50:00','end'=>'12:00:00'),
			'37'=>array('start'=>'12:00:00','end'=>'12:10:00'),
			'38'=>array('start'=>'12:10:00','end'=>'12:20:00'),
			'39'=>array('start'=>'12:20:00','end'=>'12:30:00'),
			'40'=>array('start'=>'12:30:00','end'=>'12:40:00'),
			'41'=>array('start'=>'12:40:00','end'=>'12:50:00'),
			'42'=>array('start'=>'12:50:00','end'=>'13:00:00'),
			'43'=>array('start'=>'13:00:00','end'=>'13:10:00'),
			'44'=>array('start'=>'13:10:00','end'=>'13:20:00'),
			'45'=>array('start'=>'13:20:00','end'=>'13:30:00'),
			'46'=>array('start'=>'13:30:00','end'=>'13:40:00'),
			'47'=>array('start'=>'13:40:00','end'=>'13:50:00'),
			'48'=>array('start'=>'13:50:00','end'=>'14:00:00'),
			'49'=>array('start'=>'14:00:00','end'=>'14:10:00'),
			'50'=>array('start'=>'14:10:00','end'=>'14:20:00'),
			'51'=>array('start'=>'14:20:00','end'=>'14:30:00'),
			'52'=>array('start'=>'14:30:00','end'=>'14:40:00'),
			'53'=>array('start'=>'14:40:00','end'=>'14:50:00'),
			'54'=>array('start'=>'14:50:00','end'=>'15:00:00'),
			'55'=>array('start'=>'15:00:00','end'=>'15:10:00'),
			'56'=>array('start'=>'15:10:00','end'=>'15:20:00'),
			'57'=>array('start'=>'15:20:00','end'=>'15:30:00'),
			'58'=>array('start'=>'15:30:00','end'=>'15:40:00'),
			'59'=>array('start'=>'15:40:00','end'=>'15:50:00'),
			'60'=>array('start'=>'15:50:00','end'=>'16:00:00'),
			'61'=>array('start'=>'16:00:00','end'=>'16:10:00'),
			'62'=>array('start'=>'16:10:00','end'=>'16:20:00'),
			'63'=>array('start'=>'16:20:00','end'=>'16:30:00'),
			'64'=>array('start'=>'16:30:00','end'=>'16:40:00'),
			'65'=>array('start'=>'16:40:00','end'=>'16:50:00'),
			'66'=>array('start'=>'16:50:00','end'=>'17:00:00'),
			'67'=>array('start'=>'17:00:00','end'=>'17:10:00'),
			'68'=>array('start'=>'17:10:00','end'=>'17:20:00'),
			'69'=>array('start'=>'17:20:00','end'=>'17:30:00'),
			'70'=>array('start'=>'17:30:00','end'=>'17:40:00'),
			'71'=>array('start'=>'17:40:00','end'=>'17:50:00'),
			'72'=>array('start'=>'17:50:00','end'=>'18:00:00'),
			'73'=>array('start'=>'18:00:00','end'=>'18:10:00'),
			'74'=>array('start'=>'18:10:00','end'=>'18:20:00'),
			'75'=>array('start'=>'18:20:00','end'=>'18:30:00'),
			'76'=>array('start'=>'18:30:00','end'=>'18:40:00'),
			'77'=>array('start'=>'18:40:00','end'=>'18:50:00'),
			'78'=>array('start'=>'18:50:00','end'=>'19:00:00'),
			'79'=>array('start'=>'19:00:00','end'=>'19:10:00'),
			'80'=>array('start'=>'19:10:00','end'=>'19:20:00'),
			'81'=>array('start'=>'19:20:00','end'=>'19:30:00'),
			'82'=>array('start'=>'19:30:00','end'=>'19:40:00'),
			'83'=>array('start'=>'19:40:00','end'=>'19:50:00'),
			'84'=>array('start'=>'19:50:00','end'=>'20:00:00'),
			'85'=>array('start'=>'20:00:00','end'=>'20:10:00'),
			'86'=>array('start'=>'20:10:00','end'=>'20:20:00'),
			'87'=>array('start'=>'20:20:00','end'=>'20:30:00'),
			'88'=>array('start'=>'20:30:00','end'=>'20:40:00'),
			'89'=>array('start'=>'20:40:00','end'=>'20:50:00'),
			'90'=>array('start'=>'20:50:00','end'=>'21:00:00'),
			'91'=>array('start'=>'21:00:00','end'=>'21:10:00'),
			'92'=>array('start'=>'21:10:00','end'=>'21:20:00'),
			'93'=>array('start'=>'21:20:00','end'=>'21:30:00'),
			'94'=>array('start'=>'21:30:00','end'=>'21:40:00'),
			'95'=>array('start'=>'21:40:00','end'=>'21:50:00'),
			'96'=>array('start'=>'21:50:00','end'=>'22:00:00'),
			'97'=>array('start'=>'22:00:00','end'=>'22:05:00'),
			'98'=>array('start'=>'22:05:00','end'=>'22:10:00'),
			'99'=>array('start'=>'22:10:00','end'=>'22:15:00'),
			'100'=>array('start'=>'22:15:00','end'=>'22:20:00'),
			'101'=>array('start'=>'22:20:00','end'=>'22:25:00'),
			'102'=>array('start'=>'22:25:00','end'=>'22:30:00'),
			'103'=>array('start'=>'22:30:00','end'=>'22:35:00'),
			'104'=>array('start'=>'22:35:00','end'=>'22:40:00'),
			'105'=>array('start'=>'22:40:00','end'=>'22:45:00'),
			'106'=>array('start'=>'22:45:00','end'=>'22:50:00'),
			'107'=>array('start'=>'22:50:00','end'=>'22:55:00'),
			'108'=>array('start'=>'22:55:00','end'=>'23:00:00'),
			'109'=>array('start'=>'23:00:00','end'=>'23:05:00'),
			'110'=>array('start'=>'23:05:00','end'=>'23:10:00'),
			'111'=>array('start'=>'23:10:00','end'=>'23:15:00'),
			'112'=>array('start'=>'23:15:00','end'=>'23:20:00'),
			'113'=>array('start'=>'23:20:00','end'=>'23:25:00'),
			'114'=>array('start'=>'23:25:00','end'=>'23:30:00'),
			'115'=>array('start'=>'23:30:00','end'=>'23:35:00'),
			'116'=>array('start'=>'23:35:00','end'=>'23:40:00'),
			'117'=>array('start'=>'23:40:00','end'=>'23:45:00'),
			'118'=>array('start'=>'23:45:00','end'=>'23:50:00'),
			'119'=>array('start'=>'23:50:00','end'=>'23:55:00'),
			'120'=>array('start'=>'23:55:00','end'=>'00:00:00'),
		);
		ksort($draws);
		foreach($draws as $k=>$v){
			if($nowtime>strtotime($v['start']) && $nowtime<=strtotime($v['end'])){
				$nowqihao = str_pad($k,3,0,STR_PAD_LEFT);
			}
		}
		if(!$nowqihao){
			$nowqihao = str_pad(1,3,0,STR_PAD_LEFT);
			$draws[1]['start']   = date('Y-m-d H:i:s',strtotime($draws[$total]['end']));
			$draws[1]['end']   = date('Y-m-d H:i:s',strtotime($draws[1]['end'])+86400);
			$nowdraws = [
				'expect'  => date('Ymd',strtotime($draws[1]['end'])).$nowqihao,
				'start'   => $draws[1]['start'],
				'end'     => $draws[1]['end']
			];
			$preqihao = str_pad($total,3,0,STR_PAD_LEFT);
			$predraws = [
				'expect' => date('Ymd',strtotime($draws[1]['start'])).$preqihao,
				'start'  => date('Y-m-d H:i:s',strtotime($draws[$total]['start'])),
				'end'    => date('Y-m-d H:i:s',strtotime($draws[$total]['end'])),
			];
		}else{
			$nowqihao = str_pad($nowqihao,3,0,STR_PAD_LEFT);
			$nowdraws = [
				'expect'  => date('Ymd',$nowtime).$nowqihao,
				'start'   => date('Y-m-d',$nowtime).' '.$draws[intval($nowqihao)]['start'],
				'end'     => date('Y-m-d',$nowtime).' '.$draws[intval($nowqihao)]['end']
			];
			if(intval($nowqihao)==1){
				$preqihao = str_pad($total,3,0,STR_PAD_LEFT);
				$nowexpecttime = strtotime($draws[$total]['end'])-86400;
				$predraws = [
					'expect' => date('Ymd',$nowexpecttime).$preqihao,
					'start'  => date('Y-m-d',$nowexpecttime).' '.$draws[intval($preqihao)]['start'],
					'end'    => date('Y-m-d',$nowexpecttime).' '.$draws[intval($preqihao)]['end'],
				];
			}else{
				$preqihao = str_pad($nowqihao-1,3,0,STR_PAD_LEFT);;
				$predraws = [
					'expect' => date('Ymd',$nowtime).$preqihao,
					'start'  => date('Y-m-d',$nowtime).' '.$draws[intval($preqihao)]['start'],
					'end'    => date('Y-m-d',$nowtime).' '.$draws[intval($preqihao)]['end'],
				];
			}
		}
		$return = [
			'lastFullExpect'  => $predraws['expect'],
			'lastExpect'      => substr($predraws['expect'],-3),
			'currFullExpect'  => $nowdraws['expect'],
			'currExpect'      => substr($nowdraws['expect'],-3),
			'remainTime'      => strtotime($nowdraws['end'])-time()-$cjnowtime,
			'openRemainTime'  => $cjnowtime,
		];
		return $return;
	}
}
?>