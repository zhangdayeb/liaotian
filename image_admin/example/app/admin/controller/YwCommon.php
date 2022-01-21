<?php
namespace app\admin\controller;

use app\BaseController;
use think\facade\Log;

class YwCommon extends BaseController
{

    //上传文件
    public function excelTemp() {
        $file = $_FILES['file'];
        $name = $file['name'];
        $nameList = explode('.',$name);
        if($nameList[1] != 'xlsx') {
            jsonFail('请上传正确格式的excel文件');
        }
        $str = "uploads/excel/" . generateStr(16).'.'.$nameList[1];
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

    public function uploadImage(){
        $file = $_FILES['file'];
        $name = $file['name'];
        $nameList = explode('.',$name);
        if(!in_array($nameList[1],['jpg','png','jpeg','gif','mp4'])) {
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
                'src' => env('oss_path').$filename
            ];
            jsonSuccess($data);
        }else{
            jsonFail('上传失败');
        }
    }

    /*
     * excel上传的数据处理
     */
    public function excelUpload(){
        $fildes = "filepath";
        $receiveData = getData($this->request->post(),$fildes);
        if(empty($receiveData['filepath'])) {
            jsonFail('请选择要上传文件');
        }
        $name = 'excel_'.generateStr(12);
        file_put_contents($name.'.xlsx',file_get_contents($receiveData['filepath']));
        require_once $_SERVER["DOCUMENT_ROOT"] . '/../extend/excel/PHPExcel/IOFactory.php';
        //解析excel文件
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objExcel = $objReader->load($name.'.xlsx');
        $sheet = $objExcel->getSheet();
        $highestRow = $sheet->getHighestDataRow();
        $columns = array('A','B','C','D','E','F','G');
        $arr_result = array();
        Log::write('Excel上传开始解析');
        $dealer_element = array();
        for($j = 0; $j <= $highestRow; $j ++) {
            for ($k = 0; $k < count($columns); $k ++) {
                $value = $objExcel->getActiveSheet()->getCell($columns[$k].$j)->getValue();
                $value = $value;
                if (empty($value)) {
                    $value = NULL;
                }
                $dealer_element[$k] = $value;
            }
            $arr_result[$j] = $dealer_element;
        }
        if(count($arr_result) > 2) {
            for ($i = 2; $i < count($arr_result); $i ++) {
                $result = $arr_result[$i];
                //这里处理具体的业务逻辑
                $name = $result[0];//题目
                $A = trim($result[1]);
                $B = trim($result[2]);
                $C = trim($result[3]);
                $D = trim($result[4]);
                $E = trim($result[5]);

            }
        }
        //处理完删除临时excel文件
        unlink($name.'.xlsx');
        jsonSuccess();
    }

}
