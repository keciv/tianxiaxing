<?php

use Think\Page;
function check_code($code, $id = ""){  
        $verify = new \Think\Verify();  
        return $verify->check($code, $id);  
    }
function getChildrenID($id,$table){
    $childrenID="";
    $lanmus=M($table)->where("parent_id=$id")->select();
    if($lanmus>0)
    {
        foreach($lanmus as $lanmu){
            //echo $lanmu['id'];
            $childrenID.="'".$lanmu['id']."'";
            $childrenID.=",";
        }
        $childrenID=substr($childrenID,0,mb_strlen($childrenID)-1);
    }
    return $childrenID;
}
function getAllChildrenID($id,$table=mall_navigation){
    $childrenID="";
    $lanmus=M($table)->where("parent_id=$id")->select();
    if($lanmus>0)
    {
        foreach($lanmus as $lanmu){
            //echo $lanmu['id'];
            $childrenID.="'".$lanmu['id']."'";
            $childrenID.=",";
            $childrenID.=getAllChildrenID($lanmu['id'],$table);
        }
    }
    return $childrenID;
}
function get_parent($id,$grade){
    //当前会员
    $mubiao = M('member')->where("id=$id")->find();
    if(!empty($mubiao))
    {
        if($mubiao['grade']==$grade)
        {
            return $mubiao['id'];
        }
        else
        {
            $mubiao_id = get_parent($mubiao['inviter_id'],$grade);
            return $mubiao_id;
        }
    }
    else
    {
        return "";
    }
}
// function get_team($id){
//     $parent = M('member')->where("id=$id")->find();
//     if(!empty($mubiao))
//     {
        
//     }
// }
/*
 * 改变图片的宽高
 *
 * @author flynetcn (2009-12-16)
 *
 * @param string $img_src 原图片的存放地址或url
 * @param string $new_img_path 新图片的存放地址
 * @param int $new_width 新图片的宽度
 * @param int $new_height 新图片的高度
 * @return bool 成功true, 失败false
 */
function resize_image($img_src, $new_img_path, $new_width, $new_height)
{
    //原始图像的信息
    $img_info = getimagesize($img_src);
    //print_r($img_info);
    if (!$img_info || $new_width < 1 || $new_height < 1 || empty($new_img_path)) {
        return false;
    }
    // 创建画布并载入图像
    if (strpos($img_info['mime'], 'jpeg') !== false) {
        $pic_obj = imagecreatefromjpeg($img_src);
    }else if (strpos($img_info['mime'], 'jpg') !== false) {
        $pic_obj = imagecreatefromjpeg($img_src);
    } else if (strpos($img_info['mime'], 'gif') !== false) {
        $pic_obj = imagecreatefromgif($img_src);
    } else if (strpos($img_info['mime'], 'png') !== false) {
        $pic_obj = imagecreatefrompng($img_src);
    } else {
        return false;
    }
    //获取图像宽、高
    $pic_width = imagesx($pic_obj);
    $pic_height = imagesy($pic_obj);
    // 是否定义imagecopyresampled方法
    if (function_exists("imagecopyresampled")) {
        $new_img = imagecreatetruecolor($new_width,$new_height);
        imagecopyresampled($new_img, $pic_obj, 0, 0, 0, 0, $new_width, $new_height, $pic_width, $pic_height);
    } else {
        $new_img = imagecreate($new_width, $new_height);
        imagecopyresized($new_img, $pic_obj, 0, 0, 0, 0, $new_width, $new_height, $pic_width, $pic_height);
    }
    if (preg_match('~.([^.]+)$~', $new_img_path, $match)) {
        $new_type = strtolower($match[1]);
        switch ($new_type) {
            case 'jpg':
                imagejpeg($new_img, $new_img_path);
                break;
            case 'gif':
                imagegif($new_img, $new_img_path);
                break;
            case 'png':
                imagepng($new_img, $new_img_path);
                break;
            default:
                imagejpeg($new_img, $new_img_path);
        }
    } else {
        imagejpeg($new_img, $new_img_path);
    }
    imagedestroy($pic_obj);
    imagedestroy($new_img);
    return true;
}
/**
 * 图片添加文字和头像
 **/
function hebingImg($BackgroundImage,$QrCode,$headportrait,$name){//加文字
    $Image = imagecreatefromjpeg($BackgroundImage);

    $textcolor = imagecolorallocate($Image, 0, 0,0); //设置水印字体颜色
    $font = './public/font/MSYH.TTF'; //定义字体

    imagettftext($Image, 28, 0, 300, 380, $textcolor, $font, "我是".$name);//将文字写到图片中

    $qrcode_info = @getimagesize($QrCode);
    if (!$qrcode_info) {
        return false;
    }

    if (strpos($qrcode_info['mime'], 'jpeg') !== false) {
        $qrcode_img = imagecreatefromjpeg($QrCode);
    }else if (strpos($qrcode_info['mime'], 'jpg') !== false) {
        $qrcode_img = imagecreatefromjpeg($QrCode);
    } else if (strpos($qrcode_info['mime'], 'gif') !== false) {
        $qrcode_img = imagecreatefromgif($QrCode);
    } else if (strpos($qrcode_info['mime'], 'png') !== false) {
        $qrcode_img = imagecreatefrompng($QrCode);
    } else {
        return false;
    }

    $headportrait_info = @getimagesize($headportrait);
    if (!$headportrait_info) {
        return false;
    }

    if (strpos($headportrait_info['mime'], 'jpeg') !== false) {
        $headportrait_img = imagecreatefromjpeg($headportrait);
    }else if (strpos($headportrait_info['mime'], 'jpg') !== false) {
        $headportrait_img = imagecreatefromjpeg($headportrait);
    } else if (strpos($headportrait_info['mime'], 'gif') !== false) {
        $headportrait_img = imagecreatefromgif($headportrait);
    } else if (strpos($headportrait_info['mime'], 'png') !== false) {
        $headportrait_img = imagecreatefrompng($headportrait);
    } else {
        return false;
    }

    $Exclusive = imageCreatetruecolor(imagesx($Image),imagesy($Image));
    imagecopymerge($Exclusive,$Image,0,0,0,0,imagesx($Image),imagesy($Image),100);
    list($width,$height)=getimagesize($QrCode);
    if(imagecopyresampled($Exclusive,$qrcode_img,430,640,0,0,260,260,$width,$height))
    {
        list($width,$height)=getimagesize($headportrait);
        imagecopyresampled($Exclusive,$headportrait_img,60,180,0,0,180,180,$width,$height);
    }
    $image_name = "Exclusive_".time()."_".rand(1000,9999).".jpg";
    imagejpeg($Exclusive,"./public/qrcode/".$image_name,50);
    imagedestroy($Exclusive);

    return "public/qrcode/".$image_name;
}
/**
 * 处理成圆图片,如果图片不是正方形就取最小边的圆半径,从左边开始剪切成圆形
 * @param  string $imgpath [description]
 * @return [type]          [description]
 */
function yuan_img($imgpath) {
    $ext     = pathinfo($imgpath);
    $src_img = null;
    switch ($ext['extension']) {
    case 'jpg':
        $src_img = imagecreatefromjpeg($imgpath);
        break;
    case 'png':
        $src_img = imagecreatefrompng($imgpath);
        break;
    }
    $wh  = getimagesize($imgpath);
    $w   = $wh[0];
    $h   = $wh[1];
    $w   = min($w, $h);
    $h   = $w;
    $img = imagecreatetruecolor($w, $h);
    //这一句一定要有
    imagesavealpha($img, true);
    //拾取一个完全透明的颜色,最后一个参数127为全透明
    $bg = imagecolorallocatealpha($img, 255, 255, 255, 127);
    imagefill($img, 0, 0, $bg);
    $r   = $w / 2; //圆半径
    $y_x = $r; //圆心X坐标
    $y_y = $r; //圆心Y坐标
    for ($x = 0; $x < $w; $x++) {
        for ($y = 0; $y < $h; $y++) {
            $rgbColor = imagecolorat($src_img, $x, $y);
            if (((($x - $r) * ($x - $r) + ($y - $r) * ($y - $r)) < ($r * $r))) {
                imagesetpixel($img, $x, $y, $rgbColor);
            }
        }
    }
    return $img;
}
function download($url, $path = 'images/')
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
  $file = curl_exec($ch);
  curl_close($ch);
  $filename = pathinfo($url, PATHINFO_BASENAME);
  $filename = $filename.".jpg";
  $resource = fopen($path . $filename, 'a');
  fwrite($resource, $file);
  fclose($resource);
  return $path.$filename;
}
function getPrice($id,$spec,$member_type){
    // print_r($id);
    $product = M("product")->where("id=$id")->find();
    // print_r($spec);
    if($product!=null){
        $status = "false";
        //价格
        $IsTrue = "false";
        //数据库产品属性字符串
        $spec_json = $product['spec'];
        $spec_array = json_decode($spec_json,true);
        // $spec = json_decode($spec,true);
        // print_r($spec);
        //有规格
        if(count($spec)>0)
        {
            $spec_key_user = array_keys($spec);  //用户选择的规格的键
            $spec_key_xitong = array_keys($spec_array[0]);  //用户选择的规格的键
            $spec_key_xitong = array_slice($spec_key_xitong,0,count($spec_key_xitong)-4);
            // print_r($spec_key_user);
            // print_r($spec_key_xitong);
            if(count($spec_key_user)==count($spec_key_xitong))
            {
                foreach ($spec_array as $key => $value) {
                    $array_IsTrue=array();
                    for($i=0; $i<count($spec_key_xitong); $i++)
                    {
                        $spec_key = $spec_key_xitong[$i];
                        if($value[$spec_key] == $spec[$spec_key])
                        {
                            array_push($array_IsTrue, "true");
                        }
                        else
                        {
                            array_push($array_IsTrue, "false");
                            continue;
                        }
                    }
                    
                    foreach ($array_IsTrue as $IsTrue_value) {
                        if($IsTrue_value=="true")
                        {
                            $IsTrue = "true";
                        }
                        else
                        {
                            $IsTrue = "false";
                            break;
                        }
                    }
                    if($IsTrue=="true")
                    {
                        if($member_type=="0")
                        {
                            $original_price = $value['游客价'];
                            $current_price = $value['游客价'];
                        }
                        else if($member_type=="1")
                        {
                            $original_price = $value['会员价'];
                            $current_price = $value['会员价'];
                        }
                        else if($member_type=="2")
                        {
                            $original_price = $value['店铺价'];
                            $current_price = $value['店铺价'];
                        }
                        $reserve = $value['库存'];
                        $status = "ok";
                        break;
                    }
                }
            }
        }
        else //没有规格
        {
            if($member_type=="0")
            {
                $original_price = $product['youke_price'];
                $current_price = $product['youke_price'];
            }
            else if($member_type=="1")
            {
                $original_price = $product['huiyuan_price'];
                $current_price = $product['huiyuan_price'];
            }
            else if($member_type=="2")
            {
                $original_price = $product['dianpu_price'];
                $current_price = $product['dianpu_price'];
            }
            $reserve = $product['reserve'];
            $status = "ok";
        }
        //图片
        // $spec_pic_json = $product['spec_picture'];
        // $spec_pic_array = json_decode($spec_pic_json,true);

        // $result = array("status"=>"ok","original_price"=>$original_price,"current_price"=>$current_price,"Picture"=>$Picture,"reserve"=>$reserve);
        // exit(json_encode($result));
        
        $result = array("status"=>$status,"original_price"=>$original_price,"current_price"=>$current_price,"reserve"=>$reserve,"picture"=>$spec_picture);
    }
    else
    {
        $result = array("status"=>"no_product");
    }
    return $result;
}
function sendSMS($userid,$account,$pwd,$phone,$msg)
{
    $url="http://sms.any163.cn:8888/sms.aspx";
    //$data = "action=send&userid=12039&account=13247086370&password=13247086370&mobile=18703406056&content=建材商城&sendTime=&extno="
    $data = "action=send&userid=%s&account=%s&password=%s&mobile=%s&content=%s&sendTime=&extno=";
    // $content = iconv("GB2312","UTF-8",$msg);
    $rdata = sprintf($data, $userid, $account, $pwd, $phone, $msg);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$rdata);
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    $result = curl_exec($ch);
    curl_close($ch);
    $result_json = json_encode(simplexml_load_string($result));
    $obj_json = json_decode($result_json,true);
    if($obj_json['returnstatus']=="Success")
    {
        $_SESSION["{$phone}"]=$code;
        return true;
    }
    else
    {
        return false;
    }
}
function check_input($value)
{
    //进行magic_quotes_gpc没有打开的情况对提交数据的过滤
    if (!get_magic_quotes_gpc())
    {    
        $value = addslashes($value);
    }    
    $value = str_replace("_", "\_", $value); // 把 '_'过滤掉    
    $value = str_replace("%", "\%", $value); // 把' % '过滤掉    
    $value = nl2br($value); // 回车转换    
    $value= htmlspecialchars($value); // html标记转换       
    return $value;       
}
function get_serial_number($number){
    $temp_num = 10000000;
    $new_num = $number + $temp_num;
    $real_num = "myh".substr($new_num,1,7); 
    return $real_num;
}
function notify($order_id){
    $filename = './logs/'.date('Y_m_d').'.log';
    $order = M('order_form')->where("id=$order_id")->find();
    
    $pay_order = M();
    $pay_order->startTrans();
    //修改订单状态
    $edit_order = M('order_form')->where("id=$order_id")->save(array("order_status"=>1));
    if($edit_order===false)
    {
        $pay_order->rollback();
        $result = array("code"=>"500","msg"=>"修改订单状态失败");
        $word = "msg：修改订单状态失败 \r\n";
        return false;
        // file_put_contents($filename, $word,FILE_APPEND);
        // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }

    $member = M('member')->where("id={$order['member_id']}")->find();

    //使用余额
    if($order['user_money']>0)
    {
        if($order['user_money']>$member['integral'])
        {
            $pay_order->rollback();
            $result = array("code"=>"500","msg"=>"您的积分不足，请确认");
            $word = "msg：您的积分不足，请确认 \r\n";
            return false;
        }
        //使用余额
        $jian_member_commission = M('member')->where("id={$member['id']}")->setDec('commission', $order['user_money']);
        if($jian_member_commission===false)
        {
            $pay_order->rollback();
            $result = array("code"=>"500","msg"=>"消耗会员余额错误");
            $word = "msg：消耗会员余额错误 \r\n";
            return false;
            // file_put_contents($filename, $word,FILE_APPEND);
            // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
        $jian_member_commission_record = M('commission_record')
            ->data(array(
                'commission'=>$order['user_money'],
                "member_id"=>$member['id'],
                "source"=>"购物",
                "description"=>"你购买了产品,使用{$order['user_money']}余额",
                "type"=>0
            ))
            ->add();
        if(!$jian_member_commission_record>0)
        {
            $pay_order->rollback();
            $result = array("code"=>"500","msg"=>"添加积分消费记录错误");
            $word = "msg：添加积分消费记录错误 \r\n";
            return false;
            // file_put_contents($filename, $word,FILE_APPEND);
            // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
    }
    
    //消费积分
    if($order['integral']>0)
    {
        if($member['integral']<$order['integral'])
        {
            $pay_order->rollback();
            $result = array("code"=>"500","msg"=>"您的积分不足，请确认");
            $word = "msg：您的积分不足，请确认 \r\n";
            return false;
            // file_put_contents($filename, $word,FILE_APPEND);
            // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
        //使用积分
        $jian_member_jifen = M('member')->where("id={$member['id']}")->setDec('integral', $order['integral']);
        if($jian_member_jifen===false)
        {
            $pay_order->rollback();
            $result = array("code"=>"500","msg"=>"消耗会员积分错误");
            $word = "msg：消耗会员积分错误 \r\n";
            return false;
            // file_put_contents($filename, $word,FILE_APPEND);
            // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
        $jian_member_jifen_record = M('integral_record')
            ->data(array(
                'integral'=>$order['integral'],
                "member_id"=>$member['id'],
                "source"=>"购物",
                "description"=>"你购买了{$count}个{$product['title']}，使用{$order['integral']}积分",
                "type"=>0
            ))
            ->add();
        if(!$jian_member_jifen_record>0)
        {
            $pay_order->rollback();
            $result = array("code"=>"500","msg"=>"添加积分消费记录错误");
            $word = "msg：添加积分消费记录错误 \r\n";
            return false;
            // file_put_contents($filename, $word,FILE_APPEND);
            // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
    }

    //订单产品
    $order_store = M('order_store')->where("order_id=$order_id")->select();
    array_walk($order_store, function($value, $key) use (&$store_array){
        $order_store[] = $value['id'];
    });
    $order_store = array_unique($order_store);

    $products = M('order_product')->where("order_store in ($order_store)")->select();

    foreach ($products as $key => $value) {
        //产品
        $product = M('product')->where("id={$value['product_id']}")->find();
        $manyou = $product['mianyou'];

        //订单产品数量
        $count = $value['product_num'];
        $product_current_price = $value['product_current_price'];
        $price_type = explode("+",$product_current_price);
        $price_yuan = $price_type[0];
        $price_jifen = $price_type[1];
        
        $one_commission = $product['fenxiao1']*$count;
        $two_commission = $product['fenxiao2']*$count;

        //分销
        //上级
        $one_inviter = M('member')->where("id={$member['inviter_id']}")->find();
        if(!empty($one_inviter))
        {
            //添加佣金
            $add_one_commission = M('member')->where("id={$one_inviter['id']}")->setInc('commission', $one_commission);
            if($add_one_commission===false)
            {
                $pay_order->rollback();
                $result = array("code"=>"500","msg"=>"一级推荐佣金出错");
                $word = "msg：一级推荐佣金出错 \r\n";
                return false;
                // file_put_contents($filename, $word,FILE_APPEND);
                // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
            
            //添加佣金记录
            $add_one_commission_record = M('commission_record')
                ->data(array(
                    'commission'=>$one_commission,
                    "member_id"=>$one_inviter['id'],
                    "create_time"=>time(),
                    "source"=>"分销",
                    "description"=>"你推荐的{$member['nickname']}购买产品，奖励{$one_commission}佣金",
                    "type"=>1
                ))
                ->add();
            if(!$add_one_commission_record>0)
            {
                $pay_order->rollback();
                $result = array("code"=>"500","msg"=>"一级推荐佣金记录出错");
                $word = "msg：一级推荐佣金记录出错 \r\n";
                return false;
                // file_put_contents($filename, $word,FILE_APPEND);
                // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }

            $two_inviter = M('member')->where("id={$one_inviter['inviter_id']}")->find();
            if(!empty($two_inviter))
            {
                //添加佣金
                $add_two_commission = M('member')->where("id={$two_inviter['id']}")->setInc('commission', $two_commission);
                if($add_two_commission===false)
                {
                    $pay_order->rollback();
                    $result = array("code"=>"500","msg"=>"二级推荐佣金出错");
                    $word = "msg：二级推荐佣金出错 \r\n";
                    return false;
                    // file_put_contents($filename, $word,FILE_APPEND);
                    // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                }
                
                //添加佣金记录
                $add_two_commission_record = M('commission_record')
                    ->data(array(
                        'commission'=>$two_commission,
                        "member_id"=>$two_inviter['id'],
                        "create_time"=>time(),
                        "source"=>"分销",
                        "description"=>"你推荐的{$member['nickname']}购买产品，奖励{$two_commission}佣金",
                        "type"=>1
                    ))
                    ->add();
                if(!$add_two_commission_record>0)
                {
                    $pay_order->rollback();
                    $result = array("code"=>"500","msg"=>"二级推荐佣金记录出错");
                    $word = "msg：二级推荐佣金记录出错 \r\n";
                    return false;
                    // file_put_contents($filename, $word,FILE_APPEND);
                    // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                }
            }
        }
    }
    $pay_order->commit();
    return true;
    // $result = array("code"=>"200","msg"=>"支付成功");
    // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
}

function package_notify($order_id){
    $filename = './logs/'.date('Y_m_d').'.log';
    $word = "msg：进入业务逻辑了 \r\n";
    file_put_contents($filename, $word,FILE_APPEND);
    $word = "order_id：{$order_id} \r\n";
    file_put_contents($filename, $word,FILE_APPEND);

    $order = M('order_package')->where("id=$order_id")->find();
    $word = "package_id：{$order['package_id']} , member_id：{$order['member_id']} \r\n";
    file_put_contents($filename, $word,FILE_APPEND);

    $member = M('member')->where("id={$order['member_id']}")->find();
    if(empty($member))
    {
        $word = "msg：会员不存在 \r\n";
        file_put_contents($filename, $word,FILE_APPEND);
        return false;
        // $result = array("code"=>"500","msg"=>"会员不存在");
        // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
    $member_id = $member['id'];
    //当前礼包
    $package = M('package')->where("id={$order['package_id']}")->find();
    $count = $package['count'];
    $word = "count：$count \r\n";
    file_put_contents($filename, $word,FILE_APPEND);
    
    $rule = M('distribution_rule')->select();
    if(empty($rule))
    {
        $word = "msg：分销配置出错 \r\n";
        file_put_contents($filename, $word,FILE_APPEND);
        return false;
        // $result = array("code"=>"500","msg"=>"分销配置出错");
        // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }

    $commission = M();
    $commission->startTrans();

    if($member['type']=="0")
    {
        if($count=="1")
        {
            $word = "msg：走一次 \r\n";
            file_put_contents($filename, $word,FILE_APPEND);
            //游客变成会员,
            $edit_member = M('member')
                ->where("id=$member_id")
                ->data(array(
                    "grade"=>1,
                    "type"=>1,
                    "integral"=>$member['integral']+$package['integral'],
                    "withdrawal_limit"=>$member['withdrawal_limit']+$package['withdrawal']
                ))
                ->save();

            if($edit_member===false)
            {
                $commission->rollback();
                $word = "msg：修改会员等级出错 \r\n";
                file_put_contents($filename, $word,FILE_APPEND);
                return false;
                // $result = array("code"=>"500","msg"=>"修改会员等级出错");
                // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
            //添加积分记录
            $add_integral_record = M('integral_record')
                ->data(array(
                    "integral"=>$package['integral'],
                    "member_id"=>$member_id,
                    "source"=>"大礼包",
                    "description"=>"你购买大礼包，特奖励{$package['integral']}积分",
                    "type"=>1
                ))
                ->add();
            if(!$add_integral_record>0)
            {
                $commission->rollback();
                $word = "msg：添加积分记录失败 \r\n";
                file_put_contents($filename, $word,FILE_APPEND);
                return false;
                // $result = array("code"=>"500","msg"=>"添加积分记录失败");
                // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
            //上级
            $inviter = M('member')->where("id={$member['inviter_id']}")->find();
            if(!empty($inviter))
            {
                if($inviter['grade']=="1")
                {
                    $inviter_commission = $rule[0]['ratio'];
                }
                else if($inviter['grade']=="2")
                {
                    $inviter_commission = $rule[0]['ratio']+$rule[1]['ratio'];
                }
                else if($inviter['grade']=="3")
                {
                    $inviter_commission = $rule[0]['ratio']+$rule[1]['ratio']+$rule[2]['ratio'];
                }

                //上级记录礼包+1
                $give_inviter_package = M('member')
                    ->where("id={$inviter['id']}")
                    ->setInc("package",1);

                //给上级奖励
                $give_inviter_commission = M('member')
                    ->where("id={$inviter['id']}")
                    ->setInc("commission",$inviter_commission);
                $add_inviter_record = M('commission_record')
                    ->data(array(
                        "commission"=>$inviter_commission,
                        "create_time"=>time(),
                        "member_id"=>$inviter['id'],
                        "source"=>"大礼包",
                        "description"=>"{$member['phone']}购买大礼包，特奖励{$inviter_commission}元",
                        "type"=>1
                    ))
                    ->add();

                if($give_inviter_commission===false||$give_inviter_package===false||!$add_inviter_record>0)
                {
                    $commission->rollback();
                    $word = "msg：给推荐人奖励佣金出错 \r\n";
                    file_put_contents($filename, $word,FILE_APPEND);
                    return false;
                    // $result = array("code"=>"500","msg"=>"给推荐人奖励佣金出错");
                    // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                }
                // print_r("推荐人");
                //经理
                $manager_id = get_parent($member['inviter_id'],2);
                if(!empty($manager_id))
                {
                    if($manager_id!=$inviter['id'])
                    {
                        $manager = M('member')->where("id=$manager_id")->find();
                        //给经理奖励
                        $give_manager_commission = M('member')
                            ->where("id=$manager_id")
                            ->setInc("commission",$rule[1]['ratio']);
                        $add_manager_record = M('commission_record')
                            ->data(array(
                                "commission"=>$rule[1]['ratio'],
                                "create_time"=>time(),
                                "member_id"=>$manager_id,
                                "source"=>"大礼包",
                                "description"=>"{$manager['phone']}购买大礼包，特奖励{$rule[1]['ratio']}元",
                                "type"=>1
                            ))
                            ->add();
                        if($give_manager_commission<=0||$add_manager_record<=0)
                        {
                            $commission->rollback();
                            $word = "msg：给经理奖励佣金出错 \r\n";
                            file_put_contents($filename, $word,FILE_APPEND);
                            return false;
                            // $result = array("code"=>"500","msg"=>"给经理奖励佣金出错");
                            // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                        }
                    }
                }


                //总监
                $director_id = get_parent($member['inviter_id'],3);
                if(!empty($director_id))
                {
                    if($director_id!=$inviter['id'])
                    {
                        if(!empty($manager_id))
                        {
                            $director_commission = $rule[2]['ratio'];
                        }
                        else
                        {
                            $director_commission = $rule[2]['ratio'] + $rule[1]['ratio'];
                        }
                        
                        $director = M('member')->where("id=$director_id")->find();
                        //给总监奖励
                        $give_director_commission = M('member')
                            ->where("id=$director_id")
                            ->setInc("commission",$director_commission);
                        $add_director_record = M('commission_record')
                            ->data(array(
                                "commission"=>$director_commission,
                                "create_time"=>time(),
                                "member_id"=>$director_id,
                                "source"=>"大礼包",
                                "description"=>"{$director['phone']}购买大礼包，特奖励{$director_commission}元",
                                "type"=>1
                            ))
                            ->add();
                        // print_r($give_director_commission);
                        // print_r("___");
                        // print_r($add_director_record);
                        if($give_director_commission<=0||$add_director_record<=0)
                        {
                            $commission->rollback();
                            $word = "msg：给总监奖励佣金出错 \r\n";
                            file_put_contents($filename, $word,FILE_APPEND);
                            return false;
                            // $result = array("code"=>"500","msg"=>"给总监奖励佣金出错");
                            // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                        }
                        // print_r("总监");
                    }
                }
            }
        }
        else
        {
            $word = "msg： 您不能购买该大礼包\r\n";
            file_put_contents($filename, $word,FILE_APPEND);
            return false;
            // $result = array("code"=>"500","msg"=>"您不能购买该大礼包");
            // exit(json_encode($result,JSON_UNESCAPED_UNICODE));  
        }
    }
    else
    {
        //只有合伙人能购买超级大礼包
        if($count=="1")
        {
            $word = "msg：走二次 \r\n";
            file_put_contents($filename, $word,FILE_APPEND);
            //增加积分和提现额度,
            $edit_member = M('member')
                ->where("id=$member_id")
                ->data(array(
                    "integral"=>$member['integral']+$package['integral'],
                    "withdrawal_limit"=>$member['withdrawal_limit']+$package['withdrawal'],
                ))
                ->save();

            if($edit_member===false)
            {
                $commission->rollback();
                $word = "msg：修改会员等级出错 \r\n";
                file_put_contents($filename, $word,FILE_APPEND);
                return false;
                // $result = array("code"=>"500","msg"=>"修改会员等级出错");
                // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
            //添加积分记录
            $add_integral_record = M('integral_record')
                ->data(array(
                    "integral"=>$package['integral'],
                    "member_id"=>$member_id,
                    "source"=>"大礼包",
                    "description"=>"你购买大礼包，特奖励{$package['integral']}积分",
                    "type"=>1
                ))
                ->add();
            if(!$add_integral_record>0)
            {
                $commission->rollback();
                $word = "msg：添加积分记录失败 \r\n";
                file_put_contents($filename, $word,FILE_APPEND);
                return false;
                // $result = array("code"=>"500","msg"=>"添加积分记录失败");
                // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
            //上级
            $inviter = M('member')->where("id={$member['inviter_id']}")->find();
            if(!empty($inviter))
            {
                if($inviter['grade']=="1")
                {
                    $inviter_commission = $rule[0]['ratio'];
                }
                else if($inviter['grade']=="2")
                {
                    $inviter_commission = $rule[0]['ratio']+$rule[1]['ratio'];
                }
                else if($inviter['grade']=="3")
                {
                    $inviter_commission = $rule[0]['ratio']+$rule[1]['ratio']+$rule[2]['ratio'];
                }

                //给上级奖励
                $give_inviter_commission = M('member')
                    ->where("id={$inviter['id']}")
                    ->setInc("commission",$inviter_commission);
                $add_inviter_record = M('commission_record')
                    ->data(array(
                        "commission"=>$inviter_commission,
                        "create_time"=>time(),
                        "member_id"=>$inviter['id'],
                        "source"=>"大礼包",
                        "description"=>"{$member['phone']}购买大礼包，特奖励{$inviter_commission}元",
                        "type"=>1
                    ))
                    ->add();

                if($give_inviter_commission===false||!$add_inviter_record>0)
                {
                    $commission->rollback();
                    $word = "msg：给推荐人奖励佣金出错 \r\n";
                    file_put_contents($filename, $word,FILE_APPEND);
                    return false;
                    // $result = array("code"=>"500","msg"=>"给推荐人奖励佣金出错");
                    // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                }
                // print_r("推荐人");

                //经理
                $manager_id = get_parent($member['inviter_id'],2);
                if(!empty($manager_id))
                {
                    if($manager_id!=$inviter['id'])
                    {
                        $manager = M('member')->where("id=$manager_id")->find();
                        //给经理奖励
                        $give_manager_commission = M('member')
                            ->where("id=$manager_id")
                            ->setInc("commission",$rule[1]['ratio']);
                        $add_manager_record = M('commission_record')
                            ->data(array(
                                "commission"=>$rule[1]['ratio'],
                                "create_time"=>time(),
                                "member_id"=>$manager_id,
                                "source"=>"大礼包",
                                "description"=>"{$manager['phone']}购买大礼包，特奖励{$rule[1]['ratio']}元",
                                "type"=>1
                            ))
                            ->add();
                        if($give_manager_commission<=0||$add_manager_record<=0)
                        {
                            $commission->rollback();
                            $word = "msg：给经理奖励佣金出错 \r\n";
                            file_put_contents($filename, $word,FILE_APPEND);
                            return false;
                            // $result = array("code"=>"500","msg"=>"给经理奖励佣金出错");
                            // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                        }
                    }
                }


                //总监
                $director_id = get_parent($member['inviter_id'],3);
                if(!empty($director_id))
                {
                    if($director_id!=$inviter['id'])
                    {
                        if(!empty($manager_id))
                        {
                            $director_commission = $rule[2]['ratio'];
                        }
                        else
                        {
                            $director_commission = $rule[2]['ratio'] + $rule[1]['ratio'];
                        }
                        
                        $director = M('member')->where("id=$director_id")->find();
                        //给总监奖励
                        $give_director_commission = M('member')
                            ->where("id=$director_id")
                            ->setInc("commission",$director_commission);
                        $add_director_record = M('commission_record')
                            ->data(array(
                                "commission"=>$director_commission,
                                "create_time"=>time(),
                                "member_id"=>$director_id,
                                "source"=>"大礼包",
                                "description"=>"{$director['phone']}购买大礼包，特奖励{$director_commission}元",
                                "type"=>1
                            ))
                            ->add();
                        // print_r($give_director_commission);
                        // print_r("___");
                        // print_r($add_director_record);
                        if($give_director_commission<=0||$add_director_record<=0)
                        {
                            $commission->rollback();
                            $word = "msg：给总监奖励佣金出错 \r\n";
                            file_put_contents($filename, $word,FILE_APPEND);
                            return false;
                            // $result = array("code"=>"500","msg"=>"给总监奖励佣金出错");
                            // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                        }
                        // print_r("总监");
                    }
                }
            }
        }
        else
        {
            if($member['grade']=="1")
            {
                $word = "msg： 开始超级大礼包\r\n";
                file_put_contents($filename, $word,FILE_APPEND);
                //是否购买过大礼包
                $is_buy = M('order_package')->where("member_id=$member_id and count=$count and order_status=1")->find();

                if(!empty($is_buy))
                {
                    $word = "msg： 您已经购买过该大礼包\r\n";
                    file_put_contents($filename, $word,FILE_APPEND);
                    return false;
                    // $result = array("code"=>"500","msg"=>"您已经购买过该大礼包");
                    // exit(json_encode($result,JSON_UNESCAPED_UNICODE));  
                }
                else
                {
                    //添加积分记录
                    $add_integral_record = M('integral_record')
                        ->data(array(
                            "integral"=>$package['integral'],
                            "member_id"=>$member_id,
                            "source"=>"超级大礼包",
                            "description"=>"你购买超级大礼包，获得{$package['integral']}积分",
                            "type"=>1
                        ))
                        ->add();
                    if(!$add_integral_record>0)
                    {
                        $commission->rollback();
                        $word = "msg：添加积分记录失败 \r\n";
                        file_put_contents($filename, $word,FILE_APPEND);
                        return false;
                        // $result = array("code"=>"500","msg"=>"添加积分记录失败");
                        // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                    }

                    $inviter_commission = $rule[0]['ratio']*$count;
                    //给与佣金
                    $give_inviter_commission = M('member')
                        ->where("id=$member_id")
                        ->setInc("commission",$inviter_commission);
                    //给与佣金
                    $give_inviter_package = M('member')
                        ->where("id=$member_id")
                        ->setInc("package",$count);
                    $add_inviter_record = M('commission_record')
                        ->data(array(
                            "commission"=>$inviter_commission,
                            "create_time"=>time(),
                            "member_id"=>$member_id,
                            "source"=>"大礼包",
                            "description"=>"{$member['phone']}购买超级大礼包，特奖励{$inviter_commission}元",
                            "type"=>1
                        ))
                        ->add();

                    if($give_inviter_commission===false||$give_inviter_package===false||!$add_inviter_record>0)
                    {
                        $commission->rollback();
                        $word = "msg：给自己推荐奖励佣金出错 \r\n";
                        file_put_contents($filename, $word,FILE_APPEND);
                        return false;
                        // $result = array("code"=>"500","msg"=>"给自己推荐奖励佣金出错");
                        // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                    }

                    //经理
                    $manager_id = get_parent($member['inviter_id'],2);

                    if(!empty($manager_id))
                    {
                        $manager_commission = $rule[1]['ratio']*$count;
                        $manager = M('member')->where("id=$manager_id")->find();
                        //给经理奖励
                        $give_manager_commission = M('member')
                            ->where("id=$manager_id")
                            ->setInc("commission",$manager_commission);
                        $add_manager_record = M('commission_record')
                            ->data(array(
                                "commission"=>$manager_commission,
                                "create_time"=>time(),
                                "member_id"=>$manager_id,
                                "source"=>"大礼包",
                                "description"=>"{$manager['phone']}购买大礼包，特奖励{$manager_commission}元",
                                "type"=>1
                            ))
                            ->add();
                        if($give_manager_commission<=0||$add_manager_record<=0)
                        {
                            $commission->rollback();
                            $word = "msg：给经理奖励佣金出错 \r\n";
                            file_put_contents($filename, $word,FILE_APPEND);
                            return false;
                            // $result = array("code"=>"500","msg"=>"给经理奖励佣金出错");
                            // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                        }
                    }

                    //总监
                    $director_id = get_parent($member['inviter_id'],3);
                    if(!empty($director_id))
                    {
                        if(!empty($manager_id))
                        {
                            $director_commission = $rule[2]['ratio']*$count;
                        }
                        else
                        {
                            $director_commission = ($rule[2]['ratio']+$rule[1]['ratio'])*$count;
                        }
                        
                        $director = M('member')->where("id=$director_id")->find();
                        //给总监奖励
                        $give_director_commission = M('member')
                            ->where("id=$director_id")
                            ->setInc("commission",$director_commission);
                        $add_director_record = M('commission_record')
                            ->data(array(
                                "commission"=>$director_commission,
                                "create_time"=>time(),
                                "member_id"=>$director_id,
                                "source"=>"大礼包",
                                "description"=>"{$director['phone']}购买大礼包，特奖励{$director_commission}元",
                                "type"=>1
                            ))
                            ->add();
                        // print_r($give_director_commission);
                        // print_r("___");
                        // print_r($add_director_record);
                        if($give_director_commission<=0||$add_director_record<=0)
                        {
                            $commission->rollback();
                            $word = "msg：给总监奖励佣金出错 \r\n";
                            file_put_contents($filename, $word,FILE_APPEND);
                            return false;
                            // $result = array("code"=>"500","msg"=>"给总监奖励佣金出错");
                            // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                        }
                        // print_r("总监");
                    }

                    $edit_member = M('member')
                        ->where("id=$member_id")
                        ->data(array(
                            "integral"=>$member['integral']+$package['integral'],
                            "withdrawal_limit"=>$member['withdrawal_limit']+$package['withdrawal'],
                            "grade"=>2
                        ))
                        ->save();

                    if($edit_member===false)
                    {
                        $commission->rollback();
                        $word = "msg：修改会员积分出错 \r\n";
                        file_put_contents($filename, $word,FILE_APPEND);
                        return false;
                        // $result = array("code"=>"500","msg"=>"修改会员积分出错");
                        // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                    }
                }
            }
            else
            {
                $word = "msg： 您不能购买该大礼包\r\n";
                file_put_contents($filename, $word,FILE_APPEND);
                return false;
                // $result = array("code"=>"500","msg"=>"您不能购买该大礼包");
                // exit(json_encode($result,JSON_UNESCAPED_UNICODE));  
            }
        }
        
    }

    // $fan_rule = array_reverse($rule);
    // print_r($fan_rule);
    //升级
    $one_inviter = M('member')->where("id={$member['inviter_id']}")->find();
    
    // print_r($one_inviter['id']);
    // print_r("___");
    if(!empty($one_inviter))
    {
        //获取他的团队人数
        $zhitui = M('member')->where("inviter_id={$one_inviter['id']} and grade<>0")->select();
        // $zhitui_count = count($zhitui);
        // print_r($zhitui_count);
        // print_r("___");
        $zhitui_count = M('member')->where("id={$one_inviter['id']}")->sum('package');
        // print_r($zhitui_count);
        // print_r("___");
        // print_r($zhitui_count);
        $one_zhitui_id = "";
        foreach ($zhitui as $key => $value) {
            $one_zhitui_id .= $value['id'];
            $one_zhitui_id .= ",";
        }
        $one_zhitui_id = substr($one_zhitui_id,0,mb_strlen($one_zhitui_id)-1);
        // print_r($one_zhitui_id);
        // print_r("___");

        // $team = M('member')->where("inviter_id in ($one_zhitui_id) and grade<>0")->select();
        // $team_count = count($team);
        $team_count = M('member')->where("id in ($one_zhitui_id)")->sum('package');
        if(empty($team_count))
        {
            $team_count = 0;
        }
        // $team_count = M('member')->where("inviter_id in ($one_zhitui_id)")->count();
        
        // print_r($team_count);
        // print_r("___");
        $one_grade = 0;

        foreach ($rule as $rule_key => $rule_value) {
            $direct = $rule_value['direct'];
            $indirect = $rule_value['indirect'];
            if($zhitui_count>=$direct&&$team_count>=$indirect)
            {
                // print_r($rule_key);
                // print_r($rule_value['id']);
                $one_grade = $rule_value['id'];
            }
        }
        // print_r($one_grade);
        if($one_inviter['grade']<$one_grade)
        {
            // print_r("hehe");
            $edit_one_inviter = M('member')->where("id={$one_inviter['id']}")->setField("grade",$one_grade);
            if($edit_one_inviter===false)
            {
                $commission->rollback();
                $word = "msg：上级升级失败，请重新购买 \r\n";
                file_put_contents($filename, $word,FILE_APPEND);
                return false;
                // $result = array("code"=>"500","msg"=>"上级升级失败，请重新购买");
                // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
        }
        // print_r($one_zhitui_id);
        // $one_zhitui_id = "";
        // $
        // print_r($one_inviter['inviter_id']);
        // print_r("___");
        //上上级
        $two_inviter = M('member')->where("id={$one_inviter['inviter_id']}")->find();
        if(!empty($two_inviter))
        {
            //获取他的团队人数
            $zhitui = M('member')->where("inviter_id={$two_inviter['id']} and grade<>0")->select();
            // $zhitui_count = count($zhitui);
            $zhitui_count = M('member')->where("id={$two_inviter['id']}")->sum('package');
            // print_r($zhitui_count);
            // print_r("___");
            $two_zhitui_id = "";
            foreach ($zhitui as $key => $value) {
                $two_zhitui_id .= $value['id'];
                $two_zhitui_id .= ",";
            }
            $two_zhitui_id = substr($two_zhitui_id,0,mb_strlen($two_zhitui_id)-1);
            // print_r($two_zhitui_id);
            // print_r("___");

            // $team = M('member')->where("inviter_id in ($two_zhitui_id) and grade<>0")->select();
            // $team_count = count($team);
            $team_count = M('member')->where("id in ($two_zhitui_id)")->sum('package');
            if(empty($team_count))
            {
                $team_count = 0;
            }

            // print_r($team_count);
            // print_r("___");

            $two_grade = 0;
            foreach ($rule as $rule_key => $rule_value) {
                $direct = $rule_value['direct'];
                $indirect = $rule_value['indirect'];
                if($zhitui_count>=$direct&&$team_count>=$indirect)
                {
                    $two_grade = $rule_value['id'];
                }
            }
            if($one_inviter['grade']<$two_grade)
            {
                $edit_two_inviter = M('member')->where("id={$two_inviter['id']}")->setField("grade",$two_grade);
                if($edit_two_inviter===false)
                {
                    $commission->rollback();
                    $word = "msg：上上级升级失败，请重新购买 \r\n";
                    file_put_contents($filename, $word,FILE_APPEND);
                    return false;
                    // $result = array("code"=>"500","msg"=>"上上级升级失败，请重新购买");
                    // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
                }
            }
        }
    }

    //修改订单状态
    $edit_order = M('order_package')
        ->where("id=$order_id")
        ->setInc("order_status",1);
    if($edit_order===false)
    {
        $word = "msg： 修改订单状态失败\r\n";
        file_put_contents($filename, $word,FILE_APPEND);
        return false;
        // $result = array("code"=>"500","msg"=>"修改订单状态失败");
        // exit(json_encode($result,JSON_UNESCAPED_UNICODE));  
    }

    $commission->commit();
    return true;
    // $result = array("code"=>"200","msg"=>"购买成功");
    // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    // header("http://www.xjinshangsc.com/MyCenter.html");
    // }
}

function integral_notify($order_id){
    $filename = './logs/'.date('Y_m_d').'.log';
    $word = "msg：进入业务逻辑了 \r\n";
    file_put_contents($filename, $word,FILE_APPEND);
    //当前礼包
    $order = M('order_integral')->where("id=$order_id")->find();

    $member = M('member')->where("id={$order['member_id']}")->find();
    if(empty($member))
    {
        $word = "msg：会员不存在\r\n";
        file_put_contents($filename, $word,FILE_APPEND);
        return false;
        // $result = array("code"=>"500","msg"=>"会员不存在");
        // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
    $member_id = $member['id'];

    $commission = M();
    $commission->startTrans();
    //游客变成会员
    $edit_member = M('member')->where("id={$member['id']}")->setInc('integral', $order['integral']);

    if($edit_member===false)
    {
        $commission->rollback();
        $word = "msg：添加会员积分失败\r\n";
        file_put_contents($filename, $word,FILE_APPEND);
        return false;
        // $result = array("code"=>"500","msg"=>"添加会员积分失败");
        // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
    //添加积分记录
    $add_integral_record = M('integral_record')
        ->data(array(
            "integral"=>$order['integral'],
            "member_id"=>$member_id,
            "source"=>"充值",
            "description"=>"您充值了{$order['integral']}积分",
            "type"=>1
        ))
        ->add();
    if(!$add_integral_record>0)
    {
        $commission->rollback();
        $word = "msg：添加积分记录失败\r\n";
        file_put_contents($filename, $word,FILE_APPEND);
        return false;
        // $result = array("code"=>"500","msg"=>"添加积分记录失败");
        // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }

    $commission->commit();
    return true;
    // $result = array("code"=>"200","msg"=>"购买成功");
    // exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    // header("http://www.xjinshangsc.com/MyCenter.html");
    // }
}

function get_ip(){
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
}


function i_array_column($input, $columnKey, $indexKey=null){
    if(!function_exists('array_column')){ 
        $columnKeyIsNumber  = (is_numeric($columnKey))?true:false; 
        $indexKeyIsNull            = (is_null($indexKey))?true :false; 
        $indexKeyIsNumber     = (is_numeric($indexKey))?true:false; 
        $result                         = array(); 
        foreach((array)$input as $key=>$row){ 
            if($columnKeyIsNumber){ 
                $tmp= array_slice($row, $columnKey, 1); 
                $tmp= (is_array($tmp) && !empty($tmp))?current($tmp):null; 
            }else{ 
                $tmp= isset($row[$columnKey])?$row[$columnKey]:null; 
            } 
            if(!$indexKeyIsNull){ 
                if($indexKeyIsNumber){ 
                  $key = array_slice($row, $indexKey, 1); 
                  $key = (is_array($key) && !empty($key))?current($key):null; 
                  $key = is_null($key)?0:$key; 
                }else{ 
                  $key = isset($row[$indexKey])?$row[$indexKey]:0; 
                } 
            } 
            $result[$key] = $tmp; 
        } 
        return $result; 
    }else{
        return array_column($input, $columnKey, $indexKey);
    }
}
