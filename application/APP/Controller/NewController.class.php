<?php
namespace APP\Controller;
class NewController extends BaseController{
    /**
    * @api {GET} New/getData  获取新闻信息
    * @apiGroup 新闻公告
    * @apiDescription 获取新闻信息
    * @apiParam {int} CurrentPage 当前页
    * @apiParam {int} paginalNum 一页显示数量
    * @apiParam {int} id 标识。值：2
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccess (成功) {object} data 信息
    * @apiSuccess (成功) {int} data.id 标识
    * @apiSuccess (成功) {string} data.title 标题
    * @apiSuccess (成功) {string} data.time 发布时间
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *       "data": [{
    *           "id":"15",
    *           "title":"今天开张啦",
    *           "time":"2018-09-01"
    *       }]
    *   }
    */
    public function getData(){
        $id = $_GET['id'];
        if($id!=NULL){
            $CurrentPage = $_GET['CurrentPage'];
            $paginalNum = $_GET['paginalNum'];
            if($CurrentPage==null||$CurrentPage<=0)
            {
                $CurrentPage = 1;
            }
            if($paginalNum==null||$paginalNum<=0)
            {
                $paginalNum = 10;
            }
            $childrenID = "'".$id."',".getAllChildrenID($id);
            $childrenID = substr($childrenID,0,mb_strlen($childrenID)-1);
            $new = M('mall_new')
                ->field("id,title,time,picture")
                ->where("navigation_id in ($childrenID)")
                ->order('sequence_id desc')
                ->limit(($CurrentPage-1)*$paginalNum,$paginalNum)
                ->select();
            if(empty($new))
            {
                $new = array();
            }
            $result = array("code"=>"200","msg"=>"获取成功","data"=>$new);  
        }
        else
        {
            $result = array("code"=>"400","msg"=>"暂无数据");
        }
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
    /**
    * @api {GET} New/info  获取新闻详细信息
    * @apiGroup 新闻公告
    * @apiDescription 获取新闻详细信息
    * @apiParam {int} id 新闻标识 
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccess (成功) {object} data 信息
    * @apiSuccess (成功) {int} data.id 标识
    * @apiSuccess (成功) {string} data.title 标题
    * @apiSuccess (成功) {string} data.author 作者
    * @apiSuccess (成功) {string} data.source 来源
    * @apiSuccess (成功) {string} data.time 发布时间
    * @apiSuccess (成功) {string} data.content 内容
    * @apiSuccess (成功) {string} data.navigat 所属栏目
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *       "data": {
    *           "id":"15",
    *           "title":"今天开张啦",
    *           "author":"百晓生",
    *           "source":"神机谷",
    *           "time":"2018-09-01",
    *           "content":"骗你玩的",
    *           "navigat":"最新公告"
    *       }
    *   }
    */
    public function info(){
		$content_id = $_GET['id'];
        $new = M("mall_new")
            ->field("mall_new.id,mall_new.title,mall_new.author,mall_new.source,mall_new.time,mall_new.content,mall_navigation.title as navigation")
            ->join("mall_navigation on mall_new.navigation_id=mall_navigation.id")
            ->where("mall_new.id=$content_id")
            ->find();
        if(!empty($new))
        {
            $result = array("code"=>"200","msg"=>"获取成功","data"=>$new);  
        }
        else
        {
            $result = array("code"=>"400","msg"=>"数据不存在");  
        }   
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
}