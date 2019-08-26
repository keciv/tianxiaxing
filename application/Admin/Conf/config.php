<?php
return array(

	'DEFAULT_CONTROLLER'    =>  'Index', 
	'DEFAULT_ACTION'        =>  'index', 

	'TMPL_ACTION_ERROR'     =>  'Public:success', 
	'TMPL_ACTION_SUCCESS'   =>  'Public:success', 
	'URL_MODEL'             =>  1,
	'URL_ROUTE_RULES'       =>  array(		
		'/^Welcome$/'=>'Welcome/index',
		'/^MemberInfo$/'=>'MemberInfo/index',
		'/^ShopPath$/'=>'ShopPath/index',
		'/^AdminInfo$/'=>'AdminInfo/index',
		'/^Products$/'=>'Products/index',
		'/^Product_Order$/'=>'Order/index',
		'/^Package_Order$/'=>'Order/package',
		'/^Login$/'=>'Login/index',
		'/^Package$/'=>'Package/index',
		'/^DistributionRule$/'=>'DistributionRule/index',
		'/^CompanyContent$/'=>'CompanyContent/index',
		'/^CompanyContentDanye$/'=>'CompanyContentDanye/index',
		'/^CompanyContentNew$/'=>'CompanyContentNew/index',
		'/^CompanyContentPicture$/'=>'CompanyContentPicture/index',
		'/^CompanyWebInfo$/'=>'CompanyWebInfo/index',
		'/^CompanyBanner$/'=>'CompanyBanner/index',
		'/^CompanyLeaveMessage$/'=>'CompanyLeaveMessage/index',
		'/^CompanyRecruitment$/'=>'CompanyRecruitment/index',
		'/^CompanyFriendlink$/'=>'CompanyFriendlink/index',
		'/^CompanyContentManagement$/'=>'CompanyContentManagement/index',

		'/^MallContent$/'=>'MallContent/index',
		'/^MallContentDanye$/'=>'MallContentDanye/index',
		'/^MallContentNew$/'=>'MallContentNew/index',
		'/^MallWebInfo$/'=>'MallWebInfo/index',
		'/^MallBanner$/'=>'MallBanner/index',
		'/^MallContentManagement$/'=>'MallContentManagement/index',
		
		'/^MallProduct$/'=>'MallProduct/index',
		'/^MallProductType$/'=>'MallProductType/index',
		'/^MallProductSort$/'=>'MallProductSort/index',

		'/^Integral_Record$/'=>'Record/integral',
		'/^Commission_Record$/'=>'Record/commission',
		'/^Withdrawal_Record$/'=>'Record/withdrawal',
	), 
);