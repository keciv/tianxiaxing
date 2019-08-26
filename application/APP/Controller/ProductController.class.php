<?php
namespace APP\Controller;
class ProductController extends BaseController {
    /**
    * @api {GET} Product/getData  获取产品
    * @apiGroup 产品
    * @apiDescription 获取产品
    * @apiParam {int} CurrentPage 当前页
    * @apiParam {int} paginalNum 一页显示数量
    * @apiParam {int} sort_id 分类
    * @apiParam {string} search 搜索
    * @apiParam {string} order 排序
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccess (成功) {object} data 信息
    * @apiSuccess (成功) {int} data.id 标识
    * @apiSuccess (成功) {string} data.title 标题
    * @apiSuccess (成功) {string} data.picture 缩略图
    * @apiSuccess (成功) {string} data.price 价格
    * @apiSuccess (成功) {string} data.unit 单位
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *       "data": {
    *           "id":"15",
    *           "title":"乌苏砖",
    *           "picture":"public/upload/Product/1cf37b11333822970ac6fbdd845d8176.jpg",
    *           "price":"250",
    *           "unit":"千克"
    *       }
    *   }
    */
    public function getData(){
        $sort_id = $_GET['sort_id'];
        $CurrentPage = $_GET['CurrentPage'];
        $search = check_input($_GET['search']);
        $order = check_input($_GET['order']);
        $paginalNum = $_GET['paginalNum'];
        $where = " and is_sale=1";
        
        if($sort_id==null)
        {
            $sort_id = "0";
        }
        $children_sort_id = getAllChildrenID($sort_id,"product_sort");
        $children_sort_id = "'".$sort_id."',".$children_sort_id;
        $children_sort_id = substr($children_sort_id,0,mb_strlen($children_sort_id)-1);
        
        if($paginalNum==null||$paginalNum<=0)
        {
            $paginalNum = 8;
        }
        if($CurrentPage==null||$CurrentPage<=0)
        {
            $CurrentPage = 1;
        }
        if($order==null)
        {
            $order = "sequence_id desc";
        }
        if($search!="")
        {
            $where .= " and title like '%{$search}%'";
        }
        $where .= " and sort_id in ($children_sort_id)";
        if(strpos($where,'and') !== false)
        {
            $where = substr($where,4);
        }
        // print_r($where);
        $product = M('product')
            ->Field('id,title,picture,youke_price,huiyuan_price,dianpu_price,youke_unit,huiyuan_unit,dianpu_unit')
            ->where($where)
            ->order($order)
            ->limit(($CurrentPage-1)*$paginalNum,$paginalNum)
            ->select();
        if(empty($product))
        {
            $product = array();
        }
        $result = array("code"=>"200","msg"=>"获取产品成功","data"=>$product);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
    /**
    * @api {GET} Product/get_children_sort  获取下级分类
    * @apiGroup 产品分类
    * @apiDescription 获取下级分类
    * @apiParam {int} sort_id 分类
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccess (成功) {object} data 信息
    * @apiSuccess (成功) {int} data.id 标识
    * @apiSuccess (成功) {string} data.sort_name 分类名称
    * @apiSuccess (成功) {object} data.children 下级分类
    * @apiSuccess (成功) {string} data.children.id 分类标识
    * @apiSuccess (成功) {string} data.children.sort_name 分类名称
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *       "data": {
    *           "id":"15",
    *           "sort_name":"土建工程",
    *           "id":"15",
    *           "children":{
    *               "id":"16",
    *               "sort_name":"水泥",
                    "picture":"1.png"
    *           }
    *       }
    *   }
    */
    public function get_children_sort(){
        $sort_id = $_GET['sort_id'];
        if(empty($sort_id))
        {
            $result = array("code"=>"404","msg"=>"请选择产品分类");
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
        $two_sort_id = getChildrenID($sort_id,"product_sort");
        if(empty($two_sort_id))
        {
            $result = array("code"=>"200","msg"=>"获取下级分类成功","data"=>array());
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            // $two_sort_id = $sort_id;
        }
        $two_sort = M("product_sort")->field("id,sort_name")->where("is_sale=1 and id in ($two_sort_id)")->order("sequence_id desc")->select();
        $two_array = array();
        if(!empty($two_sort))
        {
            $three_array = array();
            foreach($two_sort as $two_key => $two_value)
            {
                $two_id = $two_value["id"];
                $three_sort_id = getChildrenID($two_id,"product_sort");
                if(empty($three_sort_id))
                {
                    $result = array("code"=>"200","msg"=>"获取下级分类成功","data"=>$two_sort);
                    exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                    // $three_sort_id = $two_id;
                }
                // $three_sort = M("product_sort")->field("id,parent_id,sort_name,picture")->where("is_sale=1 and id in ($three_sort_id)")->order("sequence_id desc")->select();
                // if(empty($three_sort))
                // {
                //     $three_sort = array();
                // }
                // $two_sort[$two_key]["children"] = $three_sort;
                $three_sort = M("product")->field("id,title,picture")->where("is_sale=1 and sort_id=$two_id")->order("sequence_id desc")->select();
                if(empty($three_sort))
                {
                    $three_sort = array();
                }
                $two_sort[$two_key]["children"] = $three_sort;
            }
        }
        else
        {
            $two_sort = array();
        }

        $sort = $two_sort;
        $result = array("code"=>"200","msg"=>"获取下级分类成功","data"=>$sort);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
    /**
    * @api {GET} Product/get_root_sort  获取一级分类
    * @apiGroup 产品分类
    * @apiDescription 获取一级分类
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccess (成功) {object} data 信息
    * @apiSuccess (成功) {int} data.id 标识
    * @apiSuccess (成功) {string} data.sort_name 分类名称
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *       "data": {
    *           "id":"15",
    *           "sort_name":"土建工程"
    *       }
    *   }
    */
    public function get_root_sort(){
        $sort = M("product_sort")->field("id,sort_name")->where("is_sale=1 and parent_id=0")->order("sequence_id asc")->select();
        if(empty($sort))
        {
            $sort = array();
        }
        $result = array("code"=>"200","msg"=>"请求成功","data"=>$sort);
        $json_result = json_encode($result,JSON_UNESCAPED_UNICODE);
        exit($json_result);
    }
    /**
    * @api {GET} Product/recommend_sort  获取推荐分类
    * @apiGroup 产品分类
    * @apiDescription 获取推荐分类
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccess (成功) {object} data 信息
    * @apiSuccess (成功) {int} data.id 标识
    * @apiSuccess (成功) {string} data.sort_name 分类名称
    * @apiSuccess (成功) {string} data.picture 缩略图
    * @apiSuccess (成功) {string} data.advertisement 广告
    * @apiSuccess (成功) {object} data.children 
    * @apiSuccess (成功) {string} data.children.id 分类标识
    * @apiSuccess (成功) {string} data.children.sort_name 分类名称
    * @apiSuccess (成功) {string} data.children.picture 分类缩略图
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *       "data": {
    *           "id":"15",
    *           "sort_name":"土建工程",
    *           "picture":"1.png",
    *           "advertisement":"2.png",
    *           "children":{
                    "sort_name":"水泥",
                    "id":"23",
                    "picture":"3.png",
                }
    *       }
    *   }
    */
    public function recommend_sort(){
        $advertisement = M('advertisement')
            ->where("location=4")
            ->order("sequence_id desc")
            ->limit(7)
            ->select();
        $one_sort = M("product_sort")
            ->field("id,sort_name")
            ->where("is_sale=1 and parent_id=0")
            ->order("sequence_id asc")
            ->limit(7)
            ->select();
        $sort_array = array();
        if($one_sort!=null)
        {
            foreach($one_sort as $one_key => $one_value)
            {
                $one_id = $one_value["id"];
                $two_sort_id = getChildrenID($one_id,"product_sort");
                $two_sort = M("product_sort")
                    ->field("id,sort_name,picture")
                    ->where("is_sale=1 and id in ($two_sort_id)")
                    ->order("sequence_id desc")
                    ->limit(9)
                    ->select();
                if(empty($two_sort))
                {
                    $two_sort = array();
                }
                $one_sort[$one_key]['children'] = $two_sort;
                $one_sort[$one_key]['advertisement'] = $advertisement[$one_key];
            }
        }
        else
        {
            $one_sort = array();
        }

        //banner图
        $banner = M('mall_banner')->order("sequence_id desc")->select();
        if(empty($banner))
        {
            $banner = array();
        }

        $data = array("sort"=>$one_sort,"benner"=>$banner);
        $result = array("code"=>"200","msg"=>"获取推荐分类成功","data"=>$data);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        $this->display();
    }
    /**
    * @api {GET} Product/show  获取产品详情
    * @apiGroup 产品
    * @apiDescription 获取产品详情
    * @apiParam {int} id 商品标识
    * @apiSuccess (成功) {int} code 状态码
    * @apiSuccess (成功) {String} msg 说明
    * @apiSuccess (成功) {object} data 信息
    * @apiSuccess (成功) {int} data.id 标识
    * @apiSuccess (成功) {string} data.title 产品名称
    * @apiSuccess (成功) {string} data.description 描述
    * @apiSuccess (成功) {string} data.current_price 价格
    * @apiSuccess (成功) {object} data.attr 产品参数
    * @apiSuccess (成功) {object} data.spec 规格
    * @apiSuccess (成功) {object} data.spec_picture 规格图
    * @apiSuccess (成功) {string} data.reserve 库存
    * @apiSuccess (成功) {string} data.unit 单位
    * @apiSuccess (成功) {string} data.picture 缩略图
    * @apiSuccess (成功) {array} data.picturemore 多图展示
    * @apiSuccess (成功) {array} data.content 详情
    * @apiSuccess (成功) {string} data.is_collection 是否收藏。0(否)/1(是)
    * @apiSuccessExample {json} 成功返回
    *   {
    *       "code": 200,
    *       "msg": "xxx",
    *       "data": {
    *           "id":"15",
    *           "title":"商品混凝土",
    *           "description":"商品混凝土",
    *           "current_price":"380.00",
    *           "attr":{
                    "品牌":"阿玛尼",
                    "上市时间":"2018-10-5",
                    "功能":"走路"
                },
    *           "spec":[{
                    "颜色":"绿色",
                    "大小":"42",
                    "库存":"200",
                    "原价":"500",
                    "现价":"200"
                },
                {
                    "颜色":"红色",
                    "大小":"42",
                    "库存":"200",
                    "原价":"500",
                    "现价":"200"
                }],
    *           "spec_picture":[{
                    "大小：": [{
                        "37": "1.png"
                    }, {
                        "38": "2.png"
                    }]
                }, {
                    "颜色：": [{
                        "黑": "3.png"
                    }, {
                        "白": "4.png"
                    }, {
                        "红": "5.png"
                    }]
                }],
    *           "reserve":"200",
    *           "unit":"立方",
    *           "picture":"200",
    *           "picturemore":[1.jpg,2.jpg,3.jpg],
    *           "content":[1.jpg,2.jpg,3.jpg],
    *           "is_collection":"1"
    *       }
    *   }
    */
    public function show()
    {
        $id = $_GET['id'];
        $product = M("product")
            ->field("id,title,description,youke_price,huiyuan_price,dianpu_price,reserve,youke_unit,huiyuan_unit,dianpu_unit,picture,picturemore,content,spec,spec_picture,attr,store_id")
            ->where("id=$id")
            ->find();
        if($product!=null)
        {
            //多图展示
            $picturemore = $product['picturemore'];
            $pictureArray = explode(',',$picturemore);
            $product['picturemore'] = $pictureArray;

            $content = $product['content'];
            $contentArray = explode(',',$content);
            $product['content'] = $contentArray;
            
            //是否已经收藏 
            $member_id = $_COOKIE["member_id"];
            $collection_str = "";
            if($member_id!=null){
                $is_collection = M('collection')->where("product_id=$id and member_id=$member_id")->find();
                if($is_collection!=null)
                {
                    $collection_str = $is_collection['id'];
                }
            }
            else
            {
                $collection_str = "0";
            }
            $product['is_collection'] = $collection_str;
        }
        if(empty($product))
        {
            $result = array();
        }
        $result = array("code"=>"200","msg"=>"获取产品详情成功","data"=>$product);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
}