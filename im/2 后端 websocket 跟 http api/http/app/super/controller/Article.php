<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020/9/25 0025
 * Time: 14:36
 */

namespace app\super\controller;


use extend\service\JsonDataService;
use extend\service\UtilService;
use think\Controller;
use think\facade\Request;

use \app\im\model\mysql\Article as MArticle;

class Article extends Controller
{
    public function articleList()
    {
        $params = UtilService::getMore([
            ['key', ''],
            ['status', '-1'],
            ['page', 1],
            ['limit', 10],
        ]);
        if (Request::isAjax()) {
            $model = (new MArticle());
            $count = $model->count(1);;
            if ($params['key']) {
                $map['article_name'] = ['like', '%' . $params['key']];
                $model = $model->where($map);
            }
            if ($params['status'] > -1) {
                $model = $model->where(['status' => $params['status']]);
            }
            $list = $model->page($params['page'], $params['limit'])->order(['id'=>'desc','status'=>'desc'])->select();
            return json(['code' => 0, 'data' => $list->toArray(), 'count' => $count, 'msg' => 'success']);
        }

        return $this->fetch();
    }

    public function addArticle()
    {
        $params = UtilService::getMore([
            ['article_name', ''],
            ['article_desc', ''],
            ['status', 1],
            ['sort', 0],
            ['small_pic', ''],
            ['id', 0],
        ]);
        $params['content'] = $_POST['content'] ?? '';
        if (Request::isAjax()) {
            if(empty($params['small_pic']))  return json(JsonDataService::fail('请上传图片'));
            if (!$params['id']) {
                $ret = MArticle::create($params);
            } else {
                $artice = MArticle::find($params['id']);
                if (!$artice) return json(JsonDataService::fail());
                $ret = $artice->save($params);
            }
            if ($ret !== false) return json(JsonDataService::success('操作成功'));
            return json(JsonDataService::fail('操作失败'));
        }
        if($params['id']){
            $params = MArticle::find($params['id']);
        }
        $content = $params['content'];
        $this->assign(compact('params'));
        $this->assign(compact('content'));
        return $this->fetch();
    }

}