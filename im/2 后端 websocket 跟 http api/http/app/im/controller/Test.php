<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-06-06
 * Time: 15:43
 */

namespace app\im\controller;


use app\im\model\mongo\ChatGroup;
use app\im\model\mongo\ChatList;
use app\im\model\mongo\ChatMember;
use app\common\controller\SendData;
use app\im\model\mongo\HongBao;
use app\im\model\mongo\HongBaoDetails;
use app\im\model\mongo\UserState;
use app\im\model\mysql\UserContact;
use app\im\model\traits\MongoObj;
use app\super\model\BsysConfig;
use extend\service\AgentService;
use extend\service\ChatService;
use extend\service\ConfigService;
use extend\service\FriendService;
use extend\service\HongBaoService;
use extend\service\JsonDataService;
use extend\service\MsgService;
use extend\service\OrderService;
use extend\service\PayMentService;
use extend\service\PushService;
use extend\service\QueueService;
use extend\service\RedisService;
use extend\service\SmsService;
use extend\service\UserService;
use extend\service\UserStateService;
use extend\service\VendorService;
use extend\video\TLSSigAPI;
use MongoDB\BSON\Regex;
use MongoDB\Client;
use \Request;
use \app\im\model\mongo\Chat;
use think\Db;
use think\Image;
use think\Queue;

class Test
{
    // * [type:类型,num:数量,amount:金额,user_id:用户ID,list_id:会话ID,'msg':红包封面文字]
    //     * type生成红包 1 = 普通红包 ,2=拼手气
    public function createHB()
    {
        $res = HongBaoService::createHongbao([
            'type' => 2,
            'num' => 10,
            'user_id' => 27,
            'list_id' => '7086bfbd362563e1bc525869b69d51e5',
            'msg' => '星星快乐',
            'amount' => 100,
        ]);
        var_dump($res);
    }

    /**
     *领取红包
     */
    public function getHongBao()
    {
        $res = HongBaoService::getHongBao([
            'rid'=>'5f1e825036f2985aa92b9b90',
            'user_id' => 27
        ]);
        var_dump($res);
    }

    public function test(){
        $arr = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        var_dump(array_search("C",$arr));
    }

    public function testDb(){

//        $mongo = new MongoClient();
//        $db_name=$mongo->im;
//        $collection_name=$db_name->txzh_chat;
//        $find=$collection_name->find();
//        print_r($find);die;
//        $collection = (new Client('mongodb://127.0.0.1:27017'))->im->txzh_chat;
//        $param = Request::get();
//        $cursor = $collection->find([
//            'list_id'=>$param['list_id'],
//            'content.text'=>new Regex('^' . preg_quote('[哭'))
//        ])->toArray();

        //先找出聊天记录
        //根据聊天记录找到
        $param = Request::post();
        $res = ChatService::getSerchList([
            'user_id'=>50,
            'chat_msg'=>$param['chat_msg'],
        ]);
        var_dump($res);
    }

    public function searchF(){
        $param = Request::post();
        $res = FriendService::searchFriends([
            'user_id'=>50,
            'keyword'=>$param['keyword'],
        ]);
        var_dump($res);
    }

    public function a(){
        $member = ChatMember::field('user_id')
            ->where('list_id','6e5096fc6a37d4dcd139e4e644d1f246')
            ->select()
            ->toArray();
        print_r($member);
    }
    public function o(){
       SendData::sendToUid(26,'chatData',[
           'action'=>'ping',
       ]);
    }
    public function is(){
        $res = SendData::isOnline(26);
        print_r($res);die;
    }

    public function add(){
        $res_1 = (new HongBao())->where(['id'=>'5ef9bac81ba469797e2d9d84'])->setDec('sy_number',1);
        print_r($res_1);
    }

    public function testSadd(){
        $ret = RedisService::sadd('slist','123456');
        var_dump($ret);
        $ret = RedisService::sismember('slist','123456');
        var_dump($ret);
        $ret = RedisService::scard('slist');
        var_dump($ret);
        $ret = RedisService::srem('slist','123456');
        var_dump($ret);
        $ret = RedisService::scard('slist');
        var_dump($ret);
    }

    public function getClients(){
        $clients = SendData::getClientsByUid(26);
        print_r($clients);
    }

    public function passwordTest(){
        $salt = password_hash(123456,PASSWORD_DEFAULT);
        var_dump(password_verify('123456',$salt));
    }

    /**
     *
     * 用户资金流水
     */
    public function getUserCapitalList()
    {
        $res = UserService::getUserCapitalList(['user_id' => 26]);
        return json($res);
    }

    public function testLike(){
        $ret = (new UserContact())->where("phoneNumbers like '%15605669477%'")->find();
        var_dump((new UserContact())->getLastSql());
    }

    public function testSub(){
        echo  substr("+8613035433255",-11);
    }

    /**
     * 获取商家网址列表
     */
    public function getOnlineList(){
       $res = (new AgentService())->getOnlineList([
            'agent_id'=>'1'
        ]);
       print_r($res);die;
    }

    /**
     * 发送卡片消息
     */
    public function sendCard(){

        $res = (new MsgService())->sendCard([
            'user_ids'=>[26],
            'user_id'=>27,
            'list_id'=>'809b93d13ac51203a045914f7e60019a'

        ]);
        print_r($res);die;
    }

    /**
     * 红包领取详情
     */
    public function detail(){
        $res = HongBaoService::getHongBaoDetail([
            'user_id'=>27,
            'list_id'=>'809b93d13ac51203a045914f7e60019a',
            'rid'=>'809b93d13ac51203a045914f7e60019a'

        ]);
        print_r($res);die;
    }

    public function push(){
        $ret = (new PushService('6wQkqXpH458PjfTGiMJRd9','e3EdxvuavpAd9IxaeAmcA4','A6MlLPhE7t6J9MJWCZaOL5'));
        $res = $ret->PushMsgToApp("测试aa",'测试',[]);

        QueueService::AfterSendMsg([
            'user_ids'=>[26],
            'content_type'=>0,
            'username'=>'哈哈',
            'content'=>'你好',
        ]);
        print_r($res);
    }

    public function upload(){
//        UserStateService::setRandPhoto(['user_id'=>296]);
        $res = UserStateService::setGroupPhoto(['list_id'=>'1354403d886332259b6d3dd3fd323d28','user_ids'=>["299","298","297"]]);
        print_r($res);
    }

    public function hb(){
        $user_get = HongBaoDetails::where(['hongbao_id'=>'5f0db83ff63fa02b051afdfb','user_id'=>300])->find();
        var_dump($user_get);
    }

    public function job(){
       $ret =  Queue::push('app\job\PushJob' , [2]);
       var_dump($ret);die;
    }

    public function guid(){
        print_r(create_guid());
    }

    public function chat(){
        $db_data = ChatList::field('list_id,user_ids,no_reader_num,type,top,top_time')->where([
            'status' => 0,
        ])
            ->limit(10)
            ->order('id','desc')
            ->select()
            ->toArray();
        print_r($db_data);
    }

    public function ff(){
//        https://api.wananapp.com/static/circle/5f2173ad0b95df5fdd6cb242/20200729/856f2b0ecd484f54c9768762c7af26a2.mp4
        $path = '/www/wwwroot/imRoom/http/public/save2.gif';
        $file = '/www/wwwroot/imRoom/http/public/static/circle/5f2173ad0b95df5fdd6cb242/20200729/856f2b0ecd484f54c9768762c7af26a2.mp4';
        $ret = getVideoGif($file,3,$path);
        var_dump($ret);
    }

    public function getVedio(){

    }
    public function pay(){
       $ret =  PayMentService::aliAppPay(0.01,create_guid(),'测试商品');
       print_r($ret);
    }

    public function testTable(){
        $table = "\\app\im\\model\\mongo\\Circle";
        $all = $table::select();
        print_r($all);
    }

    public function m(){
        return json(OrderService::getOrderList(['user_id'=>27,'status'=>1]));
    }

    public function gif(){
        $path = __DIR__ . '/../../../public/static/circle/';
        rename($path . 27,$path .'5f1f06d3c943c01d980f78af');
        return json([
            'err' => 0,
            'msg' => 'success',
        ]);
    }

    /**
     * @return \think\response\Json
     */
    public function testJob(){
        RedisService::set(ConfigService::VIDEO_CALL_ROOM.$post_data['list_id'],json_encode(['roomid'=>$user_id,'to_user_id'=>$friend_id,'type'=>$callType]));
        $ret = PayMentService::afterCallVideo([
            'list_id'=>''
        ],'video',1);
        return json($ret);
    }

    public function t(){
        $db_chat_list = chat::where([
//                'user_id' => 5880,
                'list_id' => '356BFCF6C50422C5D600B1E70485E219'
            ])
            ->find();
    }

    /** 获得对话列表数据 */
    public function chatList()
    {
        //首先查出置顶的聊天

        $db_data = ChatList::field('list_id,user_ids,no_reader_num,type,top,top_time')->where([
            'user_id' => 5880,
            'status' => 0,
        ])
            ->select()
            ->toArray();
        $top_data = [];
        $chat_other_data = [];
        if (count($db_data)) {
            foreach ($db_data as $key => $value) {
                $chat_id = '';
                switch ($value['type']) {
                    case 0:
                        /** 对话 */
                        $chat_data = Chat::field('user_id,content_type,msg_type,content,time,id')
                            ->where('list_id', $value['list_id'])
                            ->order('time', 'DESC')
                            ->find();
                        $value['user_ids'] = json_decode($value['user_ids']);
                        $friend_id = $value['user_ids'][0] == 5880 ? $value['user_ids'][1] : $value['user_ids'][0];
                        $friend_data = Friend::field('remarks')
                            ->where([
                                'user_id' => 5880,
                                'friend_id' => ($friend_id * 1),
                            ])
                            ->find();
                        $db_user = User::get($friend_id);
                        /** 如果没有设置备注就显示用户昵称 */
                        if (!$friend_data) {
                            unset($db_data[$key]);
                            continue;
                        }

                        if ($friend_data->remarks) {
                            $show_name = $friend_data->remarks;
                        } else {
                            $show_name = $db_user->nickname ?? '';
                        }
                        $last_msg = '';
                        if ($chat_data) {
                            $chat_id = $chat_data->id;
                            $last_msg = $chat_data->content_type ? self::chatType($chat_data->content_type) : $chat_data['content']['text'] ?? '';
                            $time = $chat_data->time;
                        }

                        $user_state = UserState::field('photo')->where('user_id', intval($friend_id))->find();
                        $photo_path = getShowPhoto($user_state, $db_user->sex, $friend_id, 300);
                        break;
                    case 1:
                        /** 群聊 */
                        $chat_data = Chat::field('user_id,content_type,msg_type,content,time,id')->where('list_id', $value['list_id'])->order('time', 'DESC')->find();
                        $last_msg = $chat_data->content_type ? self::chatType($chat_data->content_type) : $chat_data['content']['text'] ?? '';
                        $time = $chat_data->time;
                        $chat_id = $chat_data->id;
                        $group_data = ChatGroup::field('name,is_photo')->where('list_id', $value['list_id'])->find()->toArray();
                        $show_name = $group_data['name'];
                        if (isset($group_data['is_photo']) && $group_data['is_photo']) {
                            $photo_path = '/group_photo/' . $value['list_id'] . '/90.jpg';
                        } else {
                            $photo_path = 'default_group_photo/90.jpg';
                        }
                        break;
                    case 2:
                        /** 系统消息 */
                        $last_msg = '';
                        $time = 0;
                        $show_name = '系统消息';
                        break;
                    case 3:
                        /** 公众号消息 */
                        $last_msg = '';
                        $time = '';
                        $show_name = 0;
                        break;
                    default:
                        /** 未知类消息 */
                        $last_msg = '';
                        $time = 0;
                        $show_name = '未知消息';
                        break;
                }
                if(empty($chat_id)){
                    unset($db_data[$key]);
                    continue;
                }
                $data = [
                    'list_id' => $value['list_id'],
                    'chat_id' => $chat_id,
                    'no_reader_num' => $value['no_reader_num'],
                    'show_name' => $show_name,
                    'last_msg' => $last_msg,
                    'photo_path' => $photo_path,
                    'time' => $time,
                    'top' => $value['top'],
                    'top_time' => (isset($value['top_time']) ? $value['top_time'] : 0),
                    'type' => $value['type'],
                ];
                if ($value['top']) {
                    $top_data[] = $data;
                } else {
                    $chat_other_data[] = $data;
                }
            }
            /** 消息置顶的根据置顶时间来排序 */
            if (count($top_data)) {
                $is_field = array_column($top_data, 'top_time');
                array_multisort($is_field, SORT_DESC, $top_data);
            }
            /** 根据消息最后时间排序 */
            if (count($chat_other_data)) {
                $is_field = array_column($chat_other_data, 'time');
                array_multisort($is_field, SORT_DESC, $chat_other_data);
            }
        }
        $return_data = [
            'err' => 0,
            'data' => array_merge($top_data, $chat_other_data),
            'msg' => 'success',
        ];
        return json($return_data);
    }

    /** 对话消息类型 */
    private static function chatType($type)
    {
        switch ($type) {
            case 1:
                /** 语音 */
                $last_msg = '[语音]';
                break;
            case 2:
                /** 图片 */
                $last_msg = '[图片]';
                break;
            case 3:
                /** 视频 */
                $last_msg = '[视频]';
                break;
            case 4:
                /** 文件 */
                $last_msg = '[文件]';
                break;
            case 5:
                /** 红包 */
                $last_msg = '[红包]';
                break;
            case 6:
                /** 在线视频 */
                $last_msg = '[在线视频]';
                break;
            case 7:
                /** 在线视频 */
                $last_msg = '[在线语音]';
                break;
            case 8:
                /** 在线视频 */
                $last_msg = '[名片]';
                break;
            default:
                /** 未知消息类型 */
                $last_msg = '[未知]';
                break;
        }
        return $last_msg;
    }

    public function li(){
        /**
         * $gt:大于
        $lt:小于
        $gte:大于或等于
        $lte:小于或等于
         */
        $limit = 15;
        $mongo_chat_list= MongoObj::init('chat_list');
        $db_data = $mongo_chat_list->find([
            'status' => 0,
            'user_id' => 5990,
        ], [
            'projection' => [  //指定字段
                'user_id' => 1,
                'status' => 1,
                'list_id' => 1,
                'no_reader_num' => 1,
                'user_ids' => 1,
                'type' => 1,
                'top_time' => 1,
                'top' => 1,
                'last_chat_time'=>1
            ],
            'sort' => ['top'=>-1,'last_chat_time' => -1],
            'limit'=>$limit
        ]);
        $db_data = $db_data->toArray();
        $list = [];
        foreach ($db_data as $key => $value) {
            $chat_id = '';
            switch ($value['type']) {
                case 0:
                    /** 对话 */
                    $chat_data = Chat::field('user_id,content_type,msg_type,content,time,id')
                        ->where('list_id', $value['list_id'])
                        ->order('time', 'DESC')
                        ->find();
                    $value['user_ids'] = is_array($value['user_ids']) ? $value['user_ids'] : json_decode($value['user_ids']);
                    $friend_id = $value['user_ids'][0] == $user_id ? $value['user_ids'][1] : $value['user_ids'][0];
                    $friend_data = Friend::field('remarks')
                        ->where([
                            'user_id' => $user_id,
                            'friend_id' => ($friend_id * 1),
                        ])
                        ->find();
                    $db_user = User::get($friend_id);
                    /** 如果没有设置备注就显示用户昵称 */
                    if (!$friend_data) {
                        unset($db_data[$key]);
                        continue;
                    }
                    if ($friend_data->remarks) {
                        $show_name = $friend_data->remarks;
                    } else {
                        $show_name = $db_user->nickname ?? '';
                    }
                    $last_msg = '';
                    if ($chat_data) {
                        $chat_id = $chat_data->id;
                        $last_msg = $chat_data->content_type ? self::chatType($chat_data->content_type) : $chat_data['content']['text'] ?? '';
                        $time = $chat_data->time;
                    }

                    $user_state = UserState::field('photo')->where('user_id', intval($friend_id))->find();
//                    $photo_path = getShowPhoto($user_state, $db_user->sex, $friend_id, 300);
                    $photo_path = '';
                    break;
                case 1:
                    /** 群聊 */
                    $chat_data = Chat::field('user_id,content_type,msg_type,content,time,id')->where('list_id', $value['list_id'])->order('time', 'DESC')->find();
                    $last_msg = $chat_data->content_type ? self::chatType($chat_data->content_type) : $chat_data['content']['text'] ?? '';
                    $time = $chat_data->time;
                    $chat_id = $chat_data->id;
                    $group_data = ChatGroup::field('name,is_photo')->where('list_id', $value['list_id'])->find()->toArray();
                    $show_name = $group_data['name'];
                    if (isset($group_data['is_photo']) && $group_data['is_photo']) {
                        $photo_path = '/group_photo/' . $value['list_id'] . '/90.jpg';
                    } else {
                        $photo_path = 'default_group_photo/90.jpg';
                    }
                    break;
                case 2:
                    /** 系统消息 */
                    $last_msg = '';
                    $time = 0;
                    $show_name = '系统消息';
                    break;
                case 3:
                    /** 公众号消息 */
                    $last_msg = '';
                    $time = '';
                    $show_name = 0;
                    break;
                default:
                    /** 未知类消息 */
                    $last_msg = '';
                    $time = 0;
                    $show_name = '未知消息';
                    break;
            }
            if(empty($chat_id)){
                unset($db_data[$key]);
                continue;
            }
            $data = [
                'list_id' => $value['list_id'],
                'chat_id' => $chat_id,
                'no_reader_num' => $value['no_reader_num'],
                'show_name' => $show_name,
                'last_msg' => $last_msg,
                'photo_path' => $photo_path,
                'time' => $time,
                'top' => $value['top'],
                'top_time' => (isset($value['top_time']) ? $value['top_time'] : 0),
                'type' => $value['type'],
            ];
            $list[] = $data;
        }
      var_dump($list);
    }

    public function trs(){
        $rand = getGailv(['user' =>0, 'sys' => round(1-0, 2)]);
        echo $rand;
    }

    public function kong(){
        HongBaoService::getUserDayWinByGroupId(['user_id'=>5880,'order_id'=>'AAAAAAAAA']);
//        $ret = createCanRedPacket(['red_lei'=>[1,2,3],'red_nums'=>9,'red_amount'=>100],0,1);
    }

    public function i(){
        RedisService::sadd('menbers',1);
        RedisService::sadd('menbers',2);
        RedisService::sadd('menbers',3);
        RedisService::srem('menbers',1);
       $members = RedisService::sMembers('menbers');
       var_dump($members);die;
    }

    public function msg(){
        $template = <<<EOF
<p>@尽在期中<p>
 <p>(1161436451)中个</p>
  <p>琻额：50 苞：9</p>
  <p>识：中5个-8.9倍</p>
 <p>开：9-8-7-6-5-4-3-2-1【王7】</p>
 <p>压:【2-3-5-6】</p>
<p> 供饭：445元</p>
 <p>时间：2020-08-23 22:52:36</p>
 <br>
  <p>环艺@@定制：时尚余毒</p>
  <p>逍遥且呵呵：人生几何</p><br>
EOF;
        $content = ['text'=>$template];
        $chat_obj = Chat::createChatMsg([
            'list_id' => 'A42000A0770C515F4F8FAE828B32697F',
            'user_id' => 1,
            'content_type' => 0,
            'msg_type' => 0,
            'content' => $content,
            'time' => time(),
            'is_niming' =>0
        ]);
        MsgService::sendChatDataMsgToAll('A42000A0770C515F4F8FAE828B32697F',1,$chat_obj->id,0,$content);
    }

    public function loseAndWin(){
        $redis_key ='HONGBAO:LEI:WIN:5f51d41062801e138b11581f';
        var_dump(RedisService::lrange($redis_key,0,9));
    }

    public function createPacket(){
        $packets = createCanRedPacket([
            'red_lei' => [1,2,3,4],
            'red_nums' => 9,
            'full_account_rate' =>1,  //系统用户赢钱概率
            'win_amount_rate' =>0.1,      //正常用户赢钱概率
            'red_amount' => 100,
            'loss' => false
        ], 0, 1);
        HongBaoService::setLossWin(['red_lei'=>[1,2,3,4],'rid'=>'abcd'],$packets);
        $redis_key ='HONGBAO:LEI:WIN:abcd';
        $redis_key2 ='HONGBAO:LEI:LOSS:abcd';
        var_dump(RedisService::lrange($redis_key,0,9));
        var_dump(RedisService::lrange($redis_key2,0,9));
    }

    /**
     * 发送阿里短信
     */
    public function sendAliMsg(){
       $ret = SmsService::sendAliMsg('17612111673');
       print_r($ret);
    }


    public function adress(){
        echo $_SERVER['HTTP_HOST'];
        echo "<br>";
        $http = get_http_type();
        echo $http;
    }

    public function num(){
//        $str = "1234";
//       $arr = str_split($str);
//       var_dump(is_numeric('0123'));
//       print_r($arr);
       var_dump(strHasRepeat("1012"));
    }

    public function send(){
        VendorService::robotAutoReply(['user_id'=>5880,'list_id'=>'BA041A142DF23CE9C134E2EAC25CBB9F','keywords'=>'查我']);
    }

    public function t2(){
        $member = ChatMember::field('user_id,is_admin,is_disturb')
            ->where([
                ['list_id', '=', '358F9D44298FE0280BA3BC0234E46911'],
                ['user_id','<>',1]
            ])
            ->order('time', 'ASC')
            ->select()
            ->toArray();
        print_r($member);
    }

    public function autoPackAge(){
        HongBaoService::robotAutoRedPackage(['list_id'=>'BA041A142DF23CE9C134E2EAC25CBB9F','rid'=>'5f5c4c7d765b416b4957b54c']);
    }

    public function path(){




        $user_info = UserService::getUserInfo(5880);
        $path = PHOTO_PATH . $user_info['face'];
        $image = Image::open($path);
        print_r($path);
        echo PHP_EOL;;
        print_r(PHOTO_PATH);
    }

    public function n(){
        $num = no_repe_number(0,9,3);
        echo implode('',$num);
    }

    public function time(){
        echo time().PHP_EOL;
        echo strtotime('now');
//        $hongbao_end_time = date('Y-m-d H:i:s',strtotime("+24 hours",strtotime(date('Y-m-d H:i:s'))));
//        echo  $hongbao_end_time;
    }

    public function trade(){
       echo create_password(123456);
    }

    public function t3(){
        $begin_0 = date('Y-m-01 00:00'); //本月
        $end_0 = date("Y-m-d 23:59:59");
        //上个月
        $begin_1 = date('Y-m-01 00:00:00', strtotime('-1 month'));
        $end_1 =date("Y-m-d 23:59:59", strtotime(-date('d') . 'day'));
        //上上个月
        $begin_2 =date("Y-m-d H:i:s", mktime(0, 0, 0, date("m") - 2, 1, date("Y")));
        $end_2 = date("Y-m-d H:i:s", mktime(23, 59, 59, date("m") - 1, 0, date("Y")));

        echo $begin_0."<br>";
        echo $end_0."<br>";
        echo $begin_1."<br>";
        echo $end_1."<br>";
        echo $begin_2."<br>";
        echo $end_2."<br>";
    }

    public function format(){
        echo  format_file_size(1024*1024);
    }
    public function sign(){
        $api = (new TLSSigAPI());
        $api->SetAppid(config('vedio_appid'));
        $private = config('vedio_privatekey');
        $api->SetPrivateKey($private);
        var_dump($api);die;
    }

    public function inc(){
       var_dump(array_search(2,[2]));
    }
}