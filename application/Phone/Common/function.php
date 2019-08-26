<?php
use Think\Page;
    //ÃÃ¸Ã•Â¾ÃÃ…ÃÂ¢
    function webInfo(){
        $webInfo=M("mall_webinfo")->order("id desc")->find();
        return $webInfo;
    }

    function get_title(){
        $webInfo=M("mall_webinfo")->order("id desc")->find();
        $title = $webInfo["title"];
        $TitleArray = explode("_", $title);
        $title = array_pop($TitleArray);
        return $title;
    }
    
    //Ã—Ã³Â²Ã Ã€Â¸Ã„Â¿
    function left_menu($id){
        $result=M("mall_navigation")->where("id={$id}")->find();
        //ÂµÂ±Ã‡Â°Ã€Â¸Ã„Â¿ÃŠÃ‡Ã—Ã“Ã€Â¸Ã„Â¿
        if ($result['parent_id']>0) {            
            //Ã‰ÃÃ’Â»Â¼Â¶       
            $lanmu1=M("mall_navigation")->where("id={$result['parent_id']}")->find();
			  
            //Â¶Ã¾Â¼Â¶Ã€Â¸Ã„Â¿  
            $lanmu2=M("mall_navigation")->where("parent_id={$result['parent_id']}")->select();
        }else{
            //Â¸ÃºÃ€Â¸Ã„Â¿Â£Â¬Â²Ã©Â¿Â´ÃŠÃ‡Â·Ã±Ã“ÃÃ—Ã“Ã€Â¸Ã„Â¿
            $result=M("mall_navigation")->where("parent_id={$id}")->order("id asc")->select();
            if ($result>0) {
                $lanmu1=M("mall_navigation")->where("id={$id}")->find();
                $lanmu2=M("mall_navigation")->where("parent_id={$id}")->select();
            }else {
                $lanmu1=M("mall_navigation")->where("id={$id}")->find();
                $lanmu2=M("mall_navigation")->where("parent_id=0")->order("id asc")->select();
            }
        }
        return array(ParentLanmu=>$lanmu1,ChildrenLanmu=>$lanmu2);
    }
    function phone_menu($id){
        $result=M("mall_navigation")->where("id={$id}")->find();
        if ($result>0) {            
            $lanmu=M("mall_navigation")->where("parent_id={$id}")->order("id desc")->select();
            if($lanmu<=0)
            {
                $lanmu=$result;
            }
        }
        return array($lanmu);
    }
    //ÂµÂ±Ã‡Â°ÃŽÂ»Ã–Ãƒ
    function location($id){
        //print_r($id);
        $locationNow=M("mall_navigation")->where("id={$id}")->find();
        $array = array();
        $locationAll=array_reverse(get_location($id));
        return array(LocationNow=>$locationNow,LocationAll=>$locationAll);
    }
    //ÂµÂ±Ã‡Â°ÃŽÂ»Ã–ÃƒÂ±Ã©Ã€Ãº
    function get_location($id){

        static $array=array();
        $location=M("mall_navigation")->where("id={$id}")->find();
        if($location>0)
        {           
            array_push($array,$location);
            $parent_id =$location['parent_id'];
            if($parent_id=="0")
            {
                return $array;
            }
            $location=get_location($parent_id);
        }
        return $array;
    }
 

    //Ã‰ÃÃ’Â»Ã†ÂªÃÃ‚Ã’Â»Ã†Âª
    function LastNext($id, $navigation_id, $table, $LanguageNull){
                
        $lastType="Show";        
        $nextType="Show";
        $lastData = M("{$table}")->where("navigation_id={$navigation_id} and id>{$id}")->order("sequence_id desc")->limit("0,1")->find();       
        if($lastData<=0)
        {
            $lastData=array();
            $lastData['id']=$id;
            $lastData['title']=$LanguageNull;
            $lastType="List";
        }

        $nextData = M("$table")->where("navigation_id={$navigation_id} and id<{$id}")->order("sequence_id asc")->limit("0,1")->find();       
        if($nextData<=0)
        {
            $nextData=array();
            $nextData['navigation_id']=$navigation_id;
            $nextData['title']=$LanguageNull;
            $nextType="List";
        }

        return array(last=>$lastData,next=>$nextData,lastType=>$lastType,nextType=>$nextType);
    }
    //Â½Ã˜ÃˆÂ¡Ã—Ã–Â·Ã»
    function msubstr($str, $start=0, $length,$charset="utf-8")
    {
        $str=preg_replace('!<.+?>|&nbsp;|(\\r\\n)|\\s!', ' ', $str);
        if(function_exists("mb_substr")){
            if(mb_strlen($str,"UTF8")>$length)
            {
                $result = mb_substr($str, $start, $length, $charset)."...";
            }
            else
            {
                $result = mb_substr($str, $start, $length, $charset);
            }
        }
        elseif(function_exists('iconv_substr')) {
            if(mb_strlen($str,"UTF8")>$length)
            {
                $result = iconv_substr($str, $start, $length, $charset)."...";
            }
            else
            {
                $result = iconv_substr($str, $start, $length, $charset);
            }
        }
        return $result;
        
    }

    function jump($content,$url){
        echo "<script>alert('{$content}');location.href='{$url}';</script>";
    }

   //·ÖÒ³   µ±Ç°Ò³Âë  Ã¿Ò³¼¸Ìõ À¸Ä¿id  ±íÃû ÅÅÐò
    function PageData($id,$CurrentPage,$paginalNum,$table,$Order="sequence_id desc"){
        //»ñÈ¡À¸Ä¿
        $lanmu = M("mall_navigation")->where("id={$id}")->find();

        $StripeNumber=M($table)->where($Where)->count();
        //Ã’Â»Â¹Â²Â¶Ã Ã‰Ã™Ã’Â³
        $PageTotal=ceil($StripeNumber/$paginalNum);
        if($PageTotal==0)
        {
            $PageTotal=1;
        }
        $pageStr="";
        for ($i=1; $i <= $PageTotal; $i++) { 
            if($i==$CurrentPage)
            {
                $pageStr.="<a href='{$lanmu['controller']}_{$id}_{$i}.html' class='xz' ><span>".$i."</span></a>";
            }
            else
            {
                $pageStr.="<a href='{$lanmu['controller']}_{$id}_{$i}.html'><span>".$i."</span></a>";
            }
        }
        $lastPage=$CurrentPage-1>0?$CurrentPage-1:1;
        $nextPage=$CurrentPage+1>$PageTotal?$PageTotal:$CurrentPage+1;
        //Ã’Â³ÃƒÃ¦ÃÃ”ÃŠÂ¾ÃŠÃ½Â¾Ã
        if($id=="10")
        {
            $news=M($table)->order($Order)->limit(($CurrentPage-1)*$paginalNum,$paginalNum)->select();
        }
        else
        {
            $news=M($table)->where($Where)->order($Order)->limit(($CurrentPage-1)*$paginalNum,$paginalNum)->select();
        }
        $pageData = array(CurrentPage=>$CurrentPage,lastPage=>$lastPage,nextPage=>$nextPage,StripeNumber=>$StripeNumber,PageTotal=>$PageTotal,news=>$news,pageStr=>$pageStr);

        return $pageData;

    }
    
    //ÊÕ²Ø
    //²ÎÊý  ÉÌÆ·id
    function collection($id){
      $data['member_id']=$_COOKIE['memberID'];
      $data['product_id']=$id;
      $data['time']=date("Y-m-d H:i:s",time());
      if(isset($_COOKIE['memberID'])){
        $collection=M("collection")->add($data);
          if($collection){
            echo "ok";
          }else{
             echo "no";
          }
      }else{
        $this->redirect("Login/index");
      }
      return $collection;
    }
    //È¡ÏûÊÕ²Ø 
    function collection_del($id){
      $collection_del=M("collection")->where("product_id=$id")->delete();
      if($collection_del){
        echo "ok";
      }else{
         echo "no";
      }
      return $collection_del;
    }
    function getOrder($status,$memberID)
    {
        $CurrentPage = $_GET['CurrentPage'];
        $table = "order_form";
        $where = "member_id=$memberID and is_recycle=0";
        $order = "id desc";
        $paginalNum = 5;
        if($status==null)
        {
            $status = 0;
        }
        if($CurrentPage==null)
        {
            $CurrentPage = 1;
        }
        if($status!=0)
        {
            $where .= " and order_status=$status";
        }
        $data = array();
        $order_form = M($table)->where($where)->order($order)->limit(($CurrentPage-1)*$paginalNum,$paginalNum)->select();
        //print_r($order_form);
        if($order_form!=null)
        {
            foreach ($order_form as $order_every) {
                $count = 0;
                $good_array = array();
                $order_id = $order_every['id'];
                $product = M('order_product')
                    ->where("order_id=$order_id")
                    ->order('id desc')
                    ->select();
                
                if($product!=null)
                {
                    foreach ($product as $product_value) {
                        $count = $count + $product_value['product_num'];
                    }
                    $order_every['shop'] = "佳源泰恒建材";
                    $order_every['count'] = $count;
                    $product_array = array("order"=>$order_every,"product"=>$product);
                    array_push($data, $product_array);

                }
            }
        }
        return $data;
    }

    