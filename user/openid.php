<?php
$nosession=true;
include("../includes/common.php");
session_start();
$relay_sid = null;
if(isset($_GET['sid'])){
	$relay_sid = trim(daddslashes($_GET['sid']));
	if(!preg_match('/^[a-f0-9]{64}$/', $relay_sid))exit("Access Denied");
}

@header('Content-Type: text/html; charset=UTF-8');

$is_alipay = false;

if(isset($_GET['wechatid'])){
	$wechatid = intval($_GET['wechatid']);
}elseif(isset($_GET['channel'])){
	$channelid = intval($_GET['channel']);
}else{
	if(!$conf['transfer_wxpay'])sysmsg("未开启微信转账接口");
	$channelid = $conf['transfer_wxpay'];
}
if($wechatid){
	$wxinfo = \lib\Channel::getWeixin($wechatid);
	if(!$wxinfo)sysmsg('该微信公众号不存在');
}else{
	$channel = \lib\Channel::get($channelid);
	if(!$channel)sysmsg('当前支付通道信息不存在');
	if($channel['plugin'] == 'alipay' || $channel['plugin'] == 'alipaysl' || $channel['plugin'] == 'alipayd' || $channel['plugin'] == 'alipayrp'){
		$is_alipay = true;
	}else{
		$wxinfo = \lib\Channel::getWeixin($channel['appwxmp']);
		if(!$wxinfo)sysmsg('支付通道绑定的微信公众号不存在');
	}
}

if($is_alipay){
	$alipay_config = require(PLUGIN_ROOT.$channel['plugin'].'/inc/config.php');
	$oauth = new \Alipay\AlipayOauthService($alipay_config);
	$redirect_uri = $siteurl.'user/openid.php?channel='.$channelid;
	if($relay_sid) $redirect_uri .= '&sid='.$relay_sid;
	if(isset($_GET['app_auth_code'])){
		try{
			$result = $oauth->getAppToken($_GET['app_auth_code']);
			if($relay_sid){
				$CACHE->save('scan_openid_'.$relay_sid, ['alipay_app_token'=>$result['app_auth_token'], 'alipay_app_id'=>$result['auth_app_id'], 'alipay_user_id'=>$result['user_id']], 600);
			}else{
				$_SESSION['alipay_app_token'] = $result['app_auth_token'];
				$_SESSION['alipay_app_id'] = $result['auth_app_id'];
				$_SESSION['alipay_user_id'] = $result['user_id'];
			}
			$openid_name = 'AppAuthToken';
			$openid_content = $result['app_auth_token'];
		}catch(Exception $e){
			sysmsg('支付宝获取授权Token失败！'.$e->getMessage());
		}
	}elseif(isset($_GET['auth_code'])){
		try{
			$result = $oauth->getToken($_GET['auth_code']);
			if(!empty($result['user_id'])){
				$user_id = $result['user_id'];
				$openid_name = '支付宝UID';
			}else{
				$user_id = $result['open_id'];
				$openid_name = '支付宝OpenId';
			}
			if($relay_sid){
				$CACHE->save('scan_openid_'.$relay_sid, ['alipay_user_id'=>$user_id], 600);
			}else{
				$_SESSION['alipay_user_id'] = $user_id;
			}
			$openid_content = $user_id;
		}catch(Exception $e){
			sysmsg('支付宝快捷登录失败！'.$e->getMessage());
		}
	}elseif(isset($_GET['act']) && $_GET['act']=='app_auth'){
		$oauth->appOauth($redirect_uri);
	}elseif(isset($_GET['act']) && $_GET['act']=='app_auth_assign'){
		[$pc_url, $app_url] = $oauth->appOauthAssign($redirect_uri, ['MOBILEAPP','WEBAPP','PUBLICAPP','TINYAPP','BASEAPP']);
		if(checkmobile()){
			header("Location: $app_url");
		}else{
			header("Location: $pc_url");
		}
		exit;
	}else{
		$oauth->oauth($redirect_uri);
	}
}else{
	try{
		$openId = wechat_oauth($wxinfo);
	}catch(Exception $e){
		sysmsg($e->getMessage());
	}
	
	if($relay_sid){
		$CACHE->save('scan_openid_'.$relay_sid, ['openid'=>$openId], 600);
	}else{
		$_SESSION['openid'] = $openId;
	}
	
	$openid_name = 'OpenId';
	$openid_content = $openId;
}
include PAYPAGE_ROOT.'openid.php';
