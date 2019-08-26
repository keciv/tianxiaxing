<?php
return array(
/* 默认设定 */
	'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
	'DEFAULT_ACTION'        =>  'index', // 默认操作名称
/* 模板引擎设置 */
	'TMPL_ACTION_ERROR'     =>  'Public:success', // 默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'   =>  'Public:success', // 默认成功跳转对应的模板文件
	'URL_MODEL'             =>  2,
	'URL_ROUTE_RULES'       =>  array(	
		'/^NewList_(\d+)$/'=>'New/index?navigation_id=:1',
		'/^NewList_(\d+)_(\d+)$/'=>'New/index?navigation_id=:1&CurrentPage=:2',
	    '/^NewShow_(\d+)$/'=>'New/show?contentid=:1',
	    '/^PhoneVerify$/'=>'Password/phone_verify',
	    '/^ResetPwd$/'=>'Password/reset_show',
	    '/^PwdEditMode$/'=>'Password/edit_mode',
	    '/^PwdEditPhone$/'=>'Password/phone_pwd',
	    '/^PwdEditPwd$/'=>'Password/pwd_pwd',
        '/^Pay_(\d+)$/'=>'Pay/doalipay?id=:1',
        '/^ProductList$/'=>'Product/index',
        '/^ProductList_(\d+)$/'=>'Product/index?sort_id=:1',
		'/^ProductList_(\d+)_(\d+)$/'=>'Product/index?sort_id=:1&CurrentPage=:2',
		'/^ProductShow_(\d+)$/'=>'Product/show?id=:1',
		'/^ProductSort$/'=>'Product/sort',
		'/^ProductSort_(\d+)$/'=>'Product/sort?id=:1',
		'/^RecommendSort$/'=>'Product/recommend_sort',
		'/^OrderList_(\d+)$/'=>'Order/index?status=:1',
		'/^OrderList_(\d+)_(\d+)$/'=>'Order/index?status=:1&CurrentPage=:2',
		'/^OrderShow_(\d+)$/'=>'Order/OrderInfo?order_id=:1',
		'/^CircleList$/'=>'WorkerCircle/index',
		'/^CircleList_(\d+)$/'=>'WorkerCircle/index?CurrentPage=:1',
		'/^CircleShow_(\d+)$/'=>'WorkerCircle/show?id=:1',
		'/^CircleIssue$/'=>'WorkerCircle/release',
		'/^CircleRelease_(\d+)$/'=>'WorkerCircle/release?id=:1',
		'/^CircleManage$/'=>'WorkerCircle/manage',
		'/^RealTime$/'=>'RealTime/index',
        '/^RealTime_(\d+)$/'=>'RealTime/index?sort_id=:1',
		'/^RealTime_(\d+)_(\d+)$/'=>'RealTime/index?sort_id=:1&CurrentPage=:2',
		'/^MyCenter$/'=>'MyCenter/index',
		'/^add_show$/'=>'Address/add_show',
		'/^add_show_(\d+)$/'=>'Address/add_show?id=:1',

		'/^Alipay_(\d+)$/'=>'Alipay/index?orderID=:1',
		'/^WeixinPay_(\d+)$/'=>'WeixinPay/index?id=:1',
	)
);
