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
        '/^ProductList$/'=>'Product/index',
        '/^ProductList_(\d+)$/'=>'Product/index?sort_id=:1',
		'/^ProductList_(\d+)_(\d+)$/'=>'Product/index?sort_id=:1&CurrentPage=:2',
		'/^ProductShow$/'=>'Product/show',
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
		
		'/^MyCenter$/'=>'MyCenter/index',
		'/^AddressList$/'=>'Address/index',
		'/^add_show$/'=>'Address/add_show',
		'/^add_show_(\d+)$/'=>'Address/add_show?id=:1',

		'/^Alipay_(\d+)$/'=>'Alipay/index?order_id=:1',
		'/^WeixinPay_(\d+)$/'=>'WeixinPay/index?id=:1',

		'/^Package$/'=>'Package/index',
		'/^PackageShow_(\d+)$/'=>'Package/show?id=:1',

		'/^go_pay$/'=>'Register/go_pay?id=:1',

		'/^VideoList_(\d+)$/'=>'Video/index?navigation_id=:1',
		'/^VideoList_(\d+)_(\d+)$/'=>'Video/index?navigation_id=:1&CurrentPage=:2',
	    '/^VideoShow_(\d+)$/'=>'Video/show?contentid=:1',

	    '/^PictureList_(\d+)$/'=>'Picture/index?navigation_id=:1',
		'/^PictureList_(\d+)_(\d+)$/'=>'Picture/index?navigation_id=:1&CurrentPage=:2',
	    '/^PictureShow_(\d+)$/'=>'Picture/show?contentid=:1',

	    '/^Download$/'=>'Register/download',
	    '/^Alipay_Package_(\d+)$/'=>'Alipay/order_package?order_id=:1',
	    '/^Alipay_Integral_(\d+)$/'=>'Alipay/order_integral?order_id=:1',

	    '/^Weixin_Package_(\d+)$/'=>'WeixinPay/index_package?id=:1',
	    '/^Weixin_Integral_(\d+)$/'=>'WeixinPay/index_integral?id=:1',

	    '/^PwdEditPay$/'=>'Password/pwd_pay',
	    '/^Leaderboard$/'=>'MyCenter/Leaderboard',
	)
);
