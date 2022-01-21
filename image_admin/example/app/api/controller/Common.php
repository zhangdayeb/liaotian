<?php
namespace app\api\controller;

use app\BaseController;
use think\facade\Log;
use app\common\model\mysql\YwSmsSendRecord as smsSendRecordModel;

class Common extends BaseController
{

    protected $smsSendRecordModel;

    public function initialize()
    {
        $this->smsSendRecordModel = new smsSendRecordModel();
    }

    public function uploadImage(){
        $file = $_FILES['file'];
        $name = $file['name'];
        $nameList = explode('.',$name);
        if(!in_array($nameList[1],['jpg','png','jpeg','gif'])) {
            jsonFail('请上传正确格式的图片');
        }
        $filename = generateStr(16).'.'.$nameList[1];
        $str = "uploads/file/" . $filename;
        if (file_exists($str)) {
            jsonFail('文件已存在');
        }else{
            move_uploaded_file($_FILES["file"]["tmp_name"],$str);
        }
        $data = [
            'src' => fullurl($str)
        ];
        jsonSuccess($data);
    }

    public function uploadImageOss(){
        $file = $_FILES['file'];
        $name = $file['name'];
        $nameList = explode('.',$name);
        if(!in_array($nameList[1],['jpg','png','jpeg','gif'])) {
            jsonFail('请上传正确格式的图片');
        }
        $filename = generateStr(16).'.'.$nameList[1];
        $str = "uploads/file/" . $filename;
        if (file_exists($str)) {
            jsonFail('文件已存在');
        }else{
            move_uploaded_file($_FILES["file"]["tmp_name"],$str);
        }
        $wwwRoot = $_SERVER['DOCUMENT_ROOT'];
        require_once $_SERVER["DOCUMENT_ROOT"] . '/../extend/Oss.php';
        $oss = new \Oss();
        $res = $oss->uploadToOss($wwwRoot.'/'.$str,$filename);
        //删除上传到服务器的临时文件
        unlink($wwwRoot.'/'.$str);
        if($res == 'ok'){
            $data = [
                'src' => env('oos_path').$filename
            ];
            jsonSuccess($data);
        }else{
            jsonFail('上传失败');
        }
    }

    /*
     * 发送验证码
     */
    public function sendCode(){
        $fildes = "mobile";
        $receiveData = getData($this->request->post(),$fildes);
        if(empty($receiveData['mobile'])){
            jsonFail('手机号不能为空');
        }
        if(!isCellphone($receiveData['mobile'])){
            jsonFail('手机号不正确');
        }
        require_once $_SERVER["DOCUMENT_ROOT"] . '/../extend/alisms.php';
        $alisms = new \alisms();
        $code = generateCode(6);
        $result = $alisms->sendSms($receiveData['mobile'],$code);
        Log::write($receiveData['mobile'].'发送短信结果:'.json_encode($result));
        //写入数据库
        $this->smsSendRecordModel->insertSmsSendRecord($receiveData['mobile'],$code);
        jsonSuccess();
    }

}
