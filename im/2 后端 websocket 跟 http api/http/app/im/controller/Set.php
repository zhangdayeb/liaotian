<?php
namespace app\im\controller;

use \Request;
/** mysql表 */
use \app\im\model\mysql\User;

class Set
{
	/** 设置用户基础信息 */
	public function setInfo()
	{
		$post_data = Request::post();
		$return_data = [
			'err' => 1,
			'msg' => 'fail',
			'data' => '',
		];
		if(!isset($post_data['type']) || !isset($post_data['content'])){
			$return_data['msg'] = 'data error';
			return json($return_data);
		}

		switch ($post_data['type']) {
			case '0':
				$field = 'nickname';
				break;
			case '1':
				$field = 'doodling';
				break;
			case '2':
				$field = 'sex';
				break;
			default:
				$return_data['msg'] = 'type error';
				return json($return_data);
				break;
		}

		$user = User::update([
			'id' => USER_ID,
			$field => $post_data['content'],
		]);

		$return_data['err'] = 0;
		$return_data['msg'] = 'success';
		return json($return_data);
	}

	/** 修改密码 */
	public function password()
	{
		$post_data = Request::post();

		$return_data = [
			'err' => 1,
			'msg' => 'fail',
			'data' => '',
		];

		if(!isset($post_data['pass1']) || !isset($post_data['pass2']) || !isset($post_data['pass3'])){
			$return_data['msg'] = 'data error';
			return json($return_data);
		}

		if(!$post_data['pass1']){
			$return_data['msg'] = '请输入原密码';
			return json($return_data);
		}

		if(!$post_data['pass2']){
			$return_data['msg'] = '请输入新密码';
			return json($return_data);
		}

		if(!$post_data['pass3']){
			$return_data['msg'] = '请确认新密码';
			return json($return_data);
		}

		if($post_data['pass2'] !== $post_data['pass3']){
			$return_data['msg'] = '两次新密码不一致';
			return json($return_data);
		}

		$user_data = User::field('password')->get(USER_ID);

		if($user_data->password !== md5($post_data['pass1'])){
			$return_data['msg'] = '旧密码错误';
			return json($return_data);
		}

		$user_data->password = $post_data['pass3'];
		$user_data->save();

		$return_data['err'] = 0;
		$return_data['msg'] = 'success';
		return json($return_data);
	}

}
