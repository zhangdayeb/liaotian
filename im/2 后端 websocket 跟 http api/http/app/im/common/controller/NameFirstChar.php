<?php
namespace app\im\common\controller;

class NameFirstChar
{
  /** 根据用户名，返回用户名第一个拼音的首字母 */
  public static function get($s)
  {
    $s0 = mb_substr($s,0,3); //获取名字的姓
    $s = mb_convert_encoding($s0,'gb2312','UTF-8'); //将UTF-8转换成GB2312编码
    $ord_s = ord($s);
    //dump($s0);
    if (ord($s0) > 128) { //汉字开头，汉字没有以U、V开头的
      $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
      if($asc >= -20319 and $asc <= -20284) return "A";
      if($asc >= -20283 and $asc <= -19776) return "B";
      if($asc >= -19775 and $asc <= -19219) return "C";
      if($asc >= -19218 and $asc <= -18711) return "D";
      if($asc >= -18710 and $asc <= -18527) return "E";
      if($asc >= -18526 and $asc <= -18240) return "F";
      if($asc >= -18239 and $asc <= -17760) return "G";
      if($asc >= -17759 and $asc <= -17248) return "H";
      if($asc >= -17247 and $asc <= -17418) return "I";
      if($asc >= -17417 and $asc <= -16475) return "J";
      if($asc >= -16474 and $asc <= -16213) return "K";
      if($asc >= -16212 and $asc <= -15641) return "L";
      if($asc >= -15640 and $asc <= -15166) return "M";
      if($asc >= -15165 and $asc <= -14923) return "N";
      if($asc >= -14922 and $asc <= -14915) return "O";
      if($asc >= -14914 and $asc <= -14631) return "P";
      if($asc >= -14630 and $asc <= -14150) return "Q";
      if($asc >= -14149 and $asc <= -14091) return "R";
      if($asc >= -14090 and $asc <= -13319) return "S";
      if($asc >= -13318 and $asc <= -12839) return "T";
      if($asc >= -12838 and $asc <= -12557) return "W";
      if($asc >= -12556 and $asc <= -11848) return "X";
      if($asc >= -11847 and $asc <= -11056) return "Y";
      if($asc >= -11055 and $asc <= -10247) return "Z";
    }
    else if($ord_s >= 48 and $ord_s <= 57){ //数字开头
      switch(iconv_substr($s,0,1,'utf-8')){
        case 1: return "Y";
        case 2: return "E";
        case 3: return "S";
        case 4: return "S";
        case 5: return "W";
        case 6: return "L";
        case 7: return "Q";
        case 8: return "B";
        case 9: return "J";
        case 0: return "L";
      }
    }
    else if($ord_s >= 65 and $ord_s <= 90){ //大写英文开头
      return substr($s,0,1);
    }
    else if($ord_s >= 97 and $ord_s <= 122){ //小写英文开头
      return strtoupper(substr($s,0,1));
    }
    else
    {
      return iconv_substr($s0,0,1,'utf-8');
      //中英混合的词语，不适合上面的各种情况，因此直接提取首个字符即可
    }
  }

  public static function findIndex($char = 'A'){
        $arr = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $index = array_search(strtoupper($char),$arr) ;
        return $index === false ? 0 : $index;

  }
}
