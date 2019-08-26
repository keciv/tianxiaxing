<?php

class OrderTraces {
	//即时查询
	function Jishi(){
		$EBusinessID = "1314193";
		$AppKey = "b937dc3d-3ed3-4ef7-9879-730e772f5580";
		$ReqURL = "http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx";
		$requestData= "{'LogisticCode':'266568932183','ShipperCode':'SF'}";
		$datas = array(
	        'EBusinessID' => $EBusinessID,
	        'RequestType' => '1002',
	        'RequestData' => urlencode($requestData),
	        'DataType' => '2',
	    );
	    $datas['DataSign'] = $this -> encrypt($requestData, $AppKey);
		$result = $this -> sendPost($ReqURL, $datas);	
		return $result;
	}
	 
	/**
	 *  post提交数据 
	 * @param  string $url 请求Url
	 * @param  array $datas 提交的数据 
	 * @return url响应返回的html
	 */
	function sendPost($url, $datas) {
	    $temps = array();	
	    foreach ($datas as $key => $value) {
	        $temps[] = sprintf('%s=%s', $key, $value);		
	    }	
	    $post_data = implode('&', $temps);
	    $url_info = parse_url($url);
		if(empty($url_info['port']))
		{
			$url_info['port']=80;	
		}
	    $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
	    $httpheader.= "Host:" . $url_info['host'] . "\r\n";
	    $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
	    $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
	    $httpheader.= "Connection:close\r\n\r\n";
	    $httpheader.= $post_data;
	    $fd = fsockopen($url_info['host'], $url_info['port']);
	    fwrite($fd, $httpheader);
	    $gets = "";
		$headerFlag = true;
		while (!feof($fd)) {
			if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
				break;
			}
		}
	    while (!feof($fd)) {
			$gets.= fread($fd, 128);
	    }
	    fclose($fd);  
	    
	    return $gets;
	}

	/**
	 * 电商Sign签名生成
	 * @param data 内容   
	 * @param appkey Appkey
	 * @return DataSign签名
	 */
	function encrypt($data, $appkey) {
	    return urlencode(base64_encode(md5($data.$appkey)));
	}
	//单号识别
	function danhao(){
		$EBusinessID = "1314193";
		$AppKey = "b937dc3d-3ed3-4ef7-9879-730e772f5580";
		$ReqURL = "http://testapi.kdniao.cc:8081/Ebusiness/EbusinessOrderHandle.aspx";
		$requestData = "{'LogisticCode':'266568932183'}";
		$datas = array(
	        'EBusinessID' => "1314193",
	        'RequestType' => '2002',
	        'RequestData' => urlencode($requestData),
	        'DataType' => '2'
	    );
	    $datas['DataSign'] = $this -> encrypt($requestData, $AppKey);
		$result = $this -> sendPost($ReqURL, $datas);	
		return $result;
	}
}