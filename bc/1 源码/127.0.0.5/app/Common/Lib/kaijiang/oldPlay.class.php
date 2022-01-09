<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-08-22
 * Time: 17:42
 */

namespace Lib\kaijiang;


class oldPlay
{


    public function check($betData){
        $funcName=$betData['func'];
        if(!is_callable(array($this,$funcName))){
            return -1;
        }
        $actionNum=$this->$funcName($betData, $betData['opencode']);
        return intval($actionNum);
    }

    public function sscFirstDxds($bet, $kj){
        return $this->sscDxds($bet['tzcode'], $kj, 1);
    }
    public function sscSecondDxds($bet, $kj){
        return $this->sscDxds($bet['tzcode'], $kj, 2);
    }
    public function sscThirdDxds($bet, $kj){
        return $this->sscDxds($bet['tzcode'], $kj, 3);
    }
    public function sscFourDxds($bet, $kj){
        return $this->sscDxds($bet['tzcode'], $kj, 4);
    }
    public function sscFiveDxds($bet, $kj){
        return $this->sscDxds($bet['tzcode'], $kj, 5);
    }
    public function firstEqual($bet, $kj){
        return $this->equal($bet['tzcode'], $kj, 1);
    }
    public function secondEqual($bet, $kj){
        return $this->equal($bet['tzcode'], $kj, 2);
    }
    public function thirdEqual($bet, $kj){
        return $this->equal($bet['tzcode'], $kj, 3);
    }
    public function fourEqual($bet, $kj){
        return $this->equal($bet['tzcode'], $kj, 4);
    }
    public function fiveEqual($bet, $kj){
        return $this->equal($bet['tzcode'], $kj, 5);
    }

    public function sscDxds($bet,$kj,$n){
        $big = 5;
        $small  = 4;
        return $this->dxds($bet,$kj,$n,$big,$small);
    }

    public function sscZh($betData,$kj){
        $big = 23;
        $small = 22;
        return $this->zh($betData['tzcode'],$kj,$big,$small);
    }

    public function qsBsd($betData,$kj){
        $position = '前三';
        return $this->bsd($betData['tzcode'],$kj,$position);
    }


    public function zsBsd($betData,$kj){
        $position = '中三';
        return $this->bsd($betData['tzcode'],$kj,$position);
    }


    public function hsBsd($betData,$kj){
        $position = '后三';
        return $this->bsd($betData['tzcode'],$kj,$position);
    }

    //时时彩龙虎斗
    public function lhd($bet,$kj){
        $kj= explode(',',$kj);
        switch($bet['class2']){
            case '万千':
                $data = array($kj[0],$kj[1]);
                break;
            case '万百':
                $data = array($kj[0],$kj[2]);
                break;
            case '万十':
                $data = array($kj[0],$kj[3]);
                break;
            case '万个':
                $data = array($kj[0],$kj[4]);
                break;
            case '千百':
                $data = array($kj[1],$kj[2]);
                break;
            case '千十':
                $data = array($kj[1],$kj[3]);
                break;
            case '千个':
                $data = array($kj[1],$kj[4]);
                break;
            case '百十':
                $data = array($kj[2],$kj[3]);
                break;
            case '百个':
                $data = array($kj[2],$kj[4]);
                break;
            case '十个':
                $data = array($kj[3],$kj[4]);
                break;
            default:
                return 0;
        }
        $rs = $data[0] > $data[1] ? '龙': ($data[0] < $data[1] ? '虎' : '和');
        return $bet['tzcode'] == $rs ? 1 : 0;
    }

    public function ssc5z1($betData,$kj){
        $kj = explode(',',$kj);
        foreach($kj as $ball){
            if($ball == $betData['tzcode']){
                return 1;
            }
        }
        return 0;
    }

    public function k3Zh($betData, $kj){

        $kj=explode(',',$kj);
        if($kj[0] == $kj[1] && $kj[1] == $kj[2]){
            return 0;
        }
        $total = 0;
        foreach($kj as $v){
            $total+= $v;
        }
        switch($betData['tzcode']){
            case '大':
                return ($total >=11 && $total <=17) ? 1: 0;
            case '小':
                return ($total >=4 && $total <=10) ? 1 : 0;
            default:
                return 0;
        }
    }

    public function k3QsWs($betData, $kj){
        $kj=explode(',',$kj);
        switch($betData['tzcode']){
            case '全骰':
                if($kj[0] == $kj[1] && $kj[1] == $kj[2]){
                    return 1;
                }else{
                    return 0;
                }
                break;
            default:
                if($betData['tzcode'] == $kj[0] && $kj[0] == $kj[1] && $kj[1] == $kj[2]){
                    return 1;
                }else{
                    return 0;
                }
                break;
        }
    }


    public function k3Dp($betData, $kj){
        $kj = explode(',', $kj);
        $number = substr($betData['tzcode'],0,1);
        $count = 0;
        foreach($kj as $ball){
            if($ball == $number){
                $count++;
            }
        }
        return $count >=2 ? 1 : 0;
    }


    public function k3Cp($betData, $kj){
        $kj = explode(',', $kj);
        $number1 = substr($betData['tzcode'],0,1);
        $number2 = substr($betData['tzcode'],1);
        if($number1 == $number2){
            return 0;
        }
        $count = 0;
        foreach($kj as $ball){
            if($ball == $number1){
                $count++;
                break;
            }
        }

        foreach($kj as $ball){
            if($ball == $number2){
                $count++;
                break;;
            }
        }
        return $count >=2 ? 1 : 0;
    }

    public function k3Ds($betData,$kj){
        $kj=explode(',',$kj);
        $total = 0;
        foreach($kj as $v){
            $total+= $v;
        }
        return $total.'点' == $betData['tzcode'] ? 1 : 0;
    }


    public function gyh($betData, $kj){
        $kj=explode(',',$kj);
        $gyh = $kj[0]+$kj[1];
        switch($betData['tzcode']){
            case '冠亚单':
            case '单':
                return $gyh % 2 == 1 ? 1 :0;
            case '冠亚双':
            case '双':
                return $gyh % 2 == 0 ? 1 :0;
            case '冠亚大':
            case '大':
                return $gyh >=12 ? 1: 0;
            case '冠亚小':
            case '小':
                return $gyh <=11 ? 1 : 0;
            default:
                return $gyh == $betData['tzcode'] ? 1 : 0;
        }
    }

    public function gyzh($betData, $kj){
        $kj=explode(',',$kj);
        $gyh = array($kj[0],$kj[1]);
        $balls = explode('-',$betData['tzcode']);
        sort($gyh);
        sort($balls);
        return $gyh == $balls ? 1:0;
    }

    public function pk10Zh($betData, $kj){
        $position = $this->getPk10Position($betData['class2']);
        if($position>10 || $position < 1){
            return 0;
        }
        switch($betData['tzcode']){
            case '大':
            case '小':
            case '单':
            case '双':
                return $this->dxds($betData['tzcode'],$kj,$position,6,5);
                break;
            default:
                $kj = explode(',',$kj);
                $position2 = 11-$position;
                $pk1 = $kj[$position-1];
                $pk2 = $kj[$position2-1];
                if($betData['tzcode'] == $position.'V'.$position2.'龙'){
                    return $pk1 > $pk2 ? 1 : 0;
                }
                if($betData['tzcode'] == $position.'V'.$position2.'虎'){
                    return $pk1 < $pk2 ? 1 : 0;
                }
                break;
        }
        return 0;
    }

    public function pk10Equal($betData, $kj){
        $position = $this->getPk10Position($betData['class2']);
        if($position>10 || $position < 1){
            return 0;
        }
        return $this->equal($betData['tzcode'],$kj,$position);
    }

    public function getPk10Position($class2){
        switch($class2){
            case '冠军':
                $position = 1;
                break;
            case '亚军':
                $position = 2;
                break;
            case '第三名':
                $position = 3;
                break;
            case '第四名':
                $position = 4;
                break;
            case '第五名':
                $position = 5;
                break;
            case '第六名':
                $position = 6;
                break;
            case '第七名':
                $position = 7;
                break;
            case '第八名':
                $position = 8;
                break;
            case '第九名':
                $position = 9;
                break;
            case '第十名':
                $position = 10;
                break;
            default:
                $position = 0;
                break;
        }
        return $position;
    }

    //快乐彩两面
    public function klcLm($betData, $kj){
        $kj= explode(',',$kj);
        $position = $this->getKlcPosition($betData['class2']);
        if($position > 8 || $position <1){
            return 0;
        }
        $ball = intval($kj[$position-1]);
        switch($betData['tzcode']){
            case '特单':
            case '单':
                return $ball % 2 == 1 ? 1: 0;
                break;
            case '特双':
            case '双':
                return $ball % 2 == 0 ? 1 : 0;
            case '特大':
            case '大':
                return $ball >= 11 ? 1 :0;
            case '特小':
            case '小':
                return $ball <= 10 ? 1 :0;
            case '特尾大':
            case '尾大':
                return $ball % 10 >= 5 ? 1 : 0;
            case '特尾小':
            case '尾小':
                return $ball % 10 <= 4 ? 1 : 0;
            case '合单':
                return ($ball %10 + $ball /10) % 2 == 1 ? 1 : 0;
            case '合双':
                return ($ball %10 + $ball /10) % 2 == 0 ? 1 : 0;
            default:
                return 0;
        }
    }

    public function klcZh($betData, $kj){
        $kj=explode(',',$kj);
        $total = 0;
        foreach($kj as $v){
            $total+= $v;
        }
        switch($betData['tzcode']){
            case '总单':
                return $total % 2 == 1 ? 1 :0;
            case '总双':
                return $total % 2 == 0 ? 1 :0;
            case '总大':
                return $total >=85 ? 1: 0;
            case '总小':
                return $total <=83 ? 1 : 0;
            case '总尾大':
                return $total % 10 >=5 ? 1 : 0;
            case '总尾小':
                return $total % 10 <=4 ? 1 : 0;
            default:
                return 0;
        }
    }

    public function klcEqual($betData, $kj){
        $position = $this->getKlcPosition($betData['class1']);
        if($position > 8 || $position <1){
            return 0;
        }
        return $this->equal($betData['tzcode'],$kj, $position);
    }

    public function klcDxds($betData, $kj){
        $kj= explode(',',$kj);
        $position = $this->getKlcPosition($betData['class1']);
        if($position > 8 || $position <1){
            return 0;
        }
        $shang = $xia = $ji = $ou = 0;
        foreach($kj as $ball){
            if($ball>=11){
                $xia++;
            }else{
                $shang++;
            }
            if($ball % 2 == 0){
                $ou++;
            }else{
                $ji++;
            }
        }

        $ball = intval($kj[$position-1]);
        switch($betData['tzcode']){
            case '特单':
            case '单':
                return $ball % 2 == 1 ? 1: 0;
                break;
            case '特双':
            case '双':
                return $ball % 2 == 0 ? 1 : 0;
            case '特大':
            case '大':
                return $ball >= 11 ? 1 :0;
            case '特小':
            case '小':
                return $ball <= 10 ? 1 :0;
            case '特尾大':
            case '尾大':
                return $ball % 10 >= 5 ? 1 : 0;
            case '特尾小':
            case '尾小':
                return $ball % 10 <= 4 ? 1 : 0;
            case '合单':
                return ($ball %10 + $ball /10) % 2 == 1 ? 1 : 0;
            case '合双':
                return ($ball %10 + $ball /10) % 2 == 0 ? 1 : 0;
            case '上':
                return $shang > $xia ? 1: 0;
            case '下':
                return $xia > $shang ? 1 : 0;
            case '上下和':
                return $shang == $xia ? 1 : 0;
            case '奇':
                return $ji > $ou ? 1 : 0;
            case '偶':
                return $ou > $ji ? 1 :0;
            case '奇偶和':
                return $ou == $ji ? 1 : 0;
            default:
                return 0;
        }
    }

    //快乐彩龙虎斗
    public function klcLhd($betData, $kj){
        $kj = explode(',',$kj);
        $positions = array('正一','正二','正三','正四','正五','正六','正七','特码');
        $pk = explode('VS',$betData['class2']);
        if(count($pk) != 2){
            return 0;
        }
        $position1 = array_keys($positions,$pk[0]);
        $position2 = array_keys($positions,$pk[1]);
        if(empty($position1) || empty($position2)){
            return 0;
        }
        $position1 = $position1[0];
        $position2 = $position2[0];
        $pk1 = $kj[$position1];
        $pk2 = $kj[$position2];
        if($betData['tzcode'] == '龙'){
            return $pk1 > $pk2 ? 1 : 0;
        }
        if($betData['tzcode'] == '虎'){
            return $pk1 < $pk2 ? 1 : 0;
        }
    }

    public function getKlcPosition($name){
        switch($name){
            case '特码':
                return 8;
            case '正码一':
                return 1;
            case '正码二':
                return 2;
            case '正码三':
                return 3;
            case '正码四':
                return 4;
            case '正码五':
                return 5;
            case '正码六':
                return 6;
            case '正码七':
                return 7;
            default:
                return 0;
        }
    }


    public function syx5Lm($betData, $kj){
        $kj= explode(',',$kj);
        $position = $this->get11x5Position($betData['class2']);
        if($position > 5 || $position <1){
            return 0;
        }
        $ball = intval($kj[$position-1]);
        if($ball == 11){
            return 0;
        }
        switch($betData['tzcode']){
            case '特单':
            case '单':
                return $ball % 2 == 1 ? 1: 0;
                break;
            case '特双':
            case '双':
                return $ball % 2 == 0 ? 1 : 0;
            case '特大':
            case '大':
                return $ball >= 6 ? 1 :0;
            case '特小':
            case '小':
                return $ball <= 5 ? 1 :0;
            default:
                return 0;
        }
    }

    public function syx5Zh($betData, $kj){
        $kj=explode(',',$kj);
        $total = 0;
        foreach($kj as $v){
            $total+= $v;
        }
        switch($betData['tzcode']){
            case '总单':
                return $total % 2 == 1 ? 1 :0;
            case '总双':
                return $total % 2 == 0 ? 1 :0;
            case '总大':
                return $total >=31 ? 1: 0;
            case '总小':
                return $total <=29 ? 1 : 0;
            case '总尾大':
                return $total % 10 >=5 ? 1 : 0;
            case '总尾小':
                return $total % 10 <=4 ? 1 : 0;
            default:
                return 0;
        }
    }

    public function syx5Equal($betData, $kj){
        $position = $this->get11x5Position($betData['class1']);
        if($position > 5 || $position <1){
            return 0;
        }
        return $this->equal($betData['tzcode'],$kj, $position);
    }

    public function syx5Dxds($betData, $kj){
        $kj= explode(',',$kj);
        $position = $this->get11x5Position($betData['class1']);
        if($position > 5 || $position <1){
            return 0;
        }
        $shang = $xia = $ji = $ou = 0;
        foreach($kj as $key => $ball){
            if($key == 4){
                break;
            }
            if($ball == 11){
                $ball = $kj[4];
            }
            if($ball>=6){
                $xia++;
            }else{
                $shang++;
            }
            if($ball % 2 == 0){
                $ou++;
            }else{
                $ji++;
            }
        }

        $ball = intval($kj[$position-1]);
        switch($betData['tzcode']){
            case '特单':
            case '单':
                return $ball % 2 == 1 ? 1: 0;
                break;
            case '特双':
            case '双':
                return $ball % 2 == 0 ? 1 : 0;
            case '特大':
            case '大':
                return $ball >= 6 ? 1 :0;
            case '特小':
            case '小':
                return $ball <= 5 ? 1 :0;
            case '上':
                return $shang > $xia ? 1: 0;
            case '下':
                return $xia > $shang ? 1 : 0;
            case '上下和':
                return $shang == $xia ? 1 : 0;
            case '奇':
                return $ji > $ou ? 1 : 0;
            case '偶':
                return $ou > $ji ? 1 :0;
            case '奇偶和':
                return $ou == $ji ? 1 : 0;
            default:
                return 0;
        }
    }

    //快乐彩龙虎斗
    public function syx5Lhd($betData, $kj){
        $kj = explode(',',$kj);
        $positions = array('正一','正二','正三','正四','特码');
        $pk = explode('VS',$betData['class2']);
        if(count($pk) != 2){
            return 0;
        }
        $position1 = array_keys($positions,$pk[0]);
        $position2 = array_keys($positions,$pk[1]);
        if(empty($position1) || empty($position2)){
            return 0;
        }
        $position1 = $position1[0];
        $position2 = $position2[0];
        $pk1 = $kj[$position1];
        $pk2 = $kj[$position2];
        if($betData['tzcode'] == '龙'){
            return $pk1 > $pk2 ? 1 : 0;
        }
        if($betData['tzcode'] == '虎'){
            return $pk1 < $pk2 ? 1 : 0;
        }
    }

    public function get11x5Position($name){
        switch($name){
            case '特码':
                return 5;
            case '正码一':
                return 1;
            case '正码二':
                return 2;
            case '正码三':
                return 3;
            case '正码四':
                return 4;
            default:
                return 0;
        }
    }

    public function bsd($bet,$kj,$position){
        $oldKj = $kj;
        $kj= explode(',',$kj);
        array_map(function($v){
            return intval($v);
        },$kj);
        switch($position){
            case '前三':
                $data[] = array_shift($kj);
                $data[] = array_shift($kj);
                $data[] = array_shift($kj);
                break;
            case '中三':
                $data = array($kj[1],$kj[2],$kj[3]);
                break;
            case '后三':
                $data[] = array_pop($kj);
                $data[] = array_pop($kj);
                $data[] = array_pop($kj);
                break;
            default:
                return 0;
        }
        sort($data,SORT_NUMERIC);
        switch($bet){
            case '豹子':
                if($data[0] == $data[1] && $data[1] == $data[2]){
                    return 1;
                }else{
                    return 0;
                }
                break;
            case '对子':
                $bets = array('豹子');
                foreach($bets as $v){
                    $count = $this->bsd($v,$oldKj,$position);
                    if($count){
                        return 0;
                    }
                }
                if($data[0] == $data[1] || $data[1] == $data[2]){
                    return 1;
                }else{
                    return 0;
                }
                break;
            case '顺子':
                if($data[0]==$data[1]-1 && $data[1]==$data[2]-1){
                    return 1;
                }elseif($data[0] == 0 && $data[1] == 8 && $data[2] == 9){
                    return 1;
                }elseif($data[0] == 0 && $data[1] ==1 && $data[2] == 9){
                    return 1;
                }else{
                    return 0;
                }
                break;
            case '杂六':
                $bets = array('豹子','对子','顺子','半顺');
                foreach($bets as $v){
                    $count = $this->bsd($v,$oldKj,$position);
                    if($count){
                        return 0;
                    }
                }
                return 1;
                break;
            case '半顺':
                $bets = array('对子','顺子');
                foreach($bets as $v){
                    $count = $this->bsd($v,$oldKj,$position);
                    if($count){
                        return 0;
                    }
                }
                if($data[0] == $data[1]-1 || $data[1] == $data[2]-1){
                    return 1;
                }elseif($data[0] ==0 && $data[2]==9){
                    return 1;
                }else{
                    return 0;
                }
                break;
            default:
                return 0;
        }
    }



    public function equal($bet, $kj, $n){
        $kj= explode(',',$kj);
        $ball = intval($kj[$n-1]);
        return intval($bet) == $ball ? 1 : 0;
    }

    public function dxds($bet, $kj, $n, $big, $small){
        $kj= explode(',',$kj);
        $ball = intval($kj[$n-1]);
        switch($bet){
            case '大':
                return $ball >= $big ? 1 :0;
            case '小':
                return $ball <= $small ? 1 :0;
            case '单':
                return $ball % 2 == 1 ? 1: 0;
            case '双':
                return $ball % 2 == 0 ? 1 : 0;
            default:
                return 0;
        }
    }

    public function zh($bet,$kj,$big,$small){
        $kj=explode(',',$kj);
        $total = 0;
        foreach($kj as $v){
            $total+= $v;
        }
        switch($bet){
            case '总单':
                return $total % 2 == 1 ? 1 :0;
            case '总双':
                return $total % 2 == 0 ? 1 :0;
            case '总大':
                return $total >=$big ? 1: 0;
            case '总小':
                return $total <=$small ? 1 : 0;
            default:
                return 0;
        }
    }




}