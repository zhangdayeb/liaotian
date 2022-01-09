<?php
namespace app\im\controller;

use \Request;
use \think\Image;

class Upload
{
    /** 对话发送文件、图片、语音、视频处理 */
    public function chat()
    {
        $return_data = [
            'err' => 1,
            'msg' => 'fail'
        ];
        $post_data = Request::post();
        $file = request()->file('file');
        if(!$file || !$post_data){
            $return_data['msg'] = 'error';
            return json($return_data);
        }

        $save_path = '../public/static/chat/' . $post_data['list_id'] . '/';

        if(!$info = $file->move($save_path,true,false)){
            $return_data['msg'] = $file->getError();
            return json($return_data);
        }

        $save_name = str_replace("\\","/",$info->getSaveName());

        /** 如果是图片上传，产生一个缩略图 */
        if(strpos($file->getInfo()['type'],'image') !== false){
          $image = Image::open($save_path . $save_name);
          $max_width = '175';
          $max_height = '175';
          $width = $image->width();
          $height = $image->height();
  				if($width > $max_width || $height > $max_height){
  					$scale = $width / $height;
  					$width = $scale > 1 ? $max_width : ($max_height * $scale);
  					$height = $scale > 1 ? ($max_width / $scale) : $height;
            $array_save_name = explode('.',$save_name);
            $image->thumb($width, $height)->save($save_path . $array_save_name[0] . '_thumb.' . $array_save_name[1]);
  				}
        }
        //如果是视频则获取视频的git动图
        $save_gif_name = '';
        if(strtolower($info->getExtension()) == 'mp4' || strtolower($info->getExtension()) == 'mov'){
             $file_path = $save_path.$save_name;
             $save_gif_name = create_guid().'.jpg';
             $save = CHAT_PATH . $post_data['list_id'] . '/'.$save_gif_name;
             getVideoGif($file_path,1,$save,'image2');
             if(!file_exists($save)){
                 //生成失败则copy默认图片
                 $image = Image::open(PHOTO_PATH.'default_vedio_img.jpg');
                 $image->thumb(190, 190)->save($save);
             }
        }
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        $return_data['data'] = ['save_name' => $save_name,'save_gif_path'=>$save_gif_name];

        return json($return_data);
    }

    /** 朋友圈上传文件 */
    public function circle()
    {
      $return_data = [
          'err' => 1,
          'msg' => 'fail'
      ];

      $post_data = Request::post();
      $file = request()->file('file');

      if(!$file || !$post_data){
          $return_data['msg'] = 'error';
          return json($return_data);
      }
       $dir =  '../public/static/circle';
      $save_path =$dir.'/' . USER_ID . '/';
       if(!is_dir($dir))mkdir($dir);
      if(!$info = $file->move($save_path,true,false)){
          $return_data['msg'] = $file->getError();
          return json($return_data);
      }

      $save_name = str_replace("\\","/",$info->getSaveName());

      /** 如果是图片上传，产生一个缩略图 */
      if(strpos($file->getInfo()['type'],'image') !== false){

        $image = Image::open($save_path . $save_name);

        if($post_data['len'] < 2){
            $width = 135;
            $height = 210;
        } else {
            $width = 120;
            $height = 120;
        }
        $array_save_name = explode('.',$save_name);
        $save_name = $array_save_name[0] . '_thumb.' . $array_save_name[1];
        $image->thumb($width, $height)->save($save_path . $save_name);
      }
        $save_gif_name = '';
        if($info->getExtension() == 'mp4' || $info->getExtension() == 'MOV'){
            $save_gif_name = $save_name;
            $array_save_name = explode('.',$save_name);
            $file_path = $save_path . $save_name; //上传文件的地址
            $save_name = $array_save_name[0].'.gif'; //文件位置
            $save = $save_path.$save_name;
            getVideoGif($file_path,3,$save,'gif','120x120');
            if(!file_exists($save)){
                //生成失败则copy默认图片
                $thumb =$array_save_name[0].'_thumb.jpg';
                $save = $save_path.$thumb;
                $image = Image::open(PHOTO_PATH.'vedio_button.png');
                $image->thumb(120, 120)->save($save);
            }
        }

      $return_data['err'] = 0;
      $return_data['msg'] = 'success';
      $return_data['data'] = [
        'save_name' => $save_name,
        'video_path' => $save_gif_name,
      ];
      return json($return_data);
    }

    /** 删除朋友圈临时文件 */
    public function deleteCircleFile()
    {
      $return_data = [
          'err' => 1,
          'msg' => 'fail'
      ];
      if(self::deleteDir(__DIR__ . '/../../../public/static/circle/' . USER_ID)){
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
      }
      return json($return_data);
    }

    /** 操作朋友圈临时文件夹更名 */
    public function circleFileAction(){
        $post_data = Request::post();
        $path = __DIR__ . '/../../../public/static/circle/';
        rename($path . USER_ID,$path . $post_data['circle_id']);
        return json([
          'err' => 0,
          'msg' => 'success',
        ]);
    }

    private static function deleteDir($dir)
    {
      if (!$handle = @opendir($dir)) {
          return false;
      }
      while (false !== ($file = readdir($handle))) {
          if ($file !== "." && $file !== "..") { //排除当前目录与父级目录
              $file = $dir . '/' . $file;
              if (is_dir($file)) {
                  self::deleteDir($file);
              } else {
                  @unlink($file);
              }
          }
      }
      @rmdir($dir);
      return true;
    }

    /** 头像上传处理 */
    public function photo()
    {
      $return_data = [
          'err' => 1,
          'msg' => 'fail'
      ];
      $post_data = Request::post();
      $file = request()->file('file');
      if(!$file || !$post_data){
          $return_data['msg'] = 'error';
          return json($return_data);
      }
      $save_path = '../public/static/photo/user/' . USER_ID . '/';
      if(!$info = $file->move($save_path,'300.jpg')){
          $return_data['msg'] = $file->getError();
          return json($return_data);
      }

      /** 生成不同尺寸的头像 */
      $image = Image::open($save_path . '300.jpg');
      $image->thumb(190, 190)->save($save_path . '190.jpg');
      $image->thumb(90, 90)->save($save_path . '90.jpg');
      $image->thumb(70, 70)->save($save_path . '70.jpg');
      $image->thumb(50, 50)->save($save_path . '50.jpg');

      $return_data['err'] = 0;
      $return_data['msg'] = 'success';
      return json($return_data);
    }

    /** 群头像上传处理 */
    public function groupPhoto()
    {
      $return_data = [
          'err' => 1,
          'msg' => 'fail'
      ];
      $post_data = Request::post();
      $file = request()->file('file');
      if(!$file || !isset($post_data['list_id'])){
          $return_data['msg'] = 'error';
          return json($return_data);
      }
      $save_path = '../public/static/photo/group_photo/' . $post_data['list_id'] . '/';
      if(!$info = $file->move($save_path,'300.jpg')){
          $return_data['msg'] = $file->getError();
          return json($return_data);
      }

      /** 生成不同尺寸的头像 */
      $image = Image::open($save_path . '300.jpg');
      $image->thumb(90, 90)->save($save_path . '90.jpg');

      $return_data['err'] = 0;
      $return_data['msg'] = 'success';
      return json($return_data);
    }

    /** 朋友圈背景图片上传处理 */
    public function circleImg()
    {
      $return_data = [
          'err' => 1,
          'msg' => 'fail'
      ];
      $post_data = Request::post();
      $file = request()->file('file');
      if(!$file || !$post_data){
          $return_data['msg'] = 'error';
          return json($return_data);
      }
      $save_path = '../public/static/photo/circle/';
      if(!$info = $file->move($save_path,USER_ID . '.jpg')){
          $return_data['msg'] = $file->getError();
          return json($return_data);
      }

      $return_data['err'] = 0;
      $return_data['msg'] = 'success';
      return json($return_data);
    }
}
