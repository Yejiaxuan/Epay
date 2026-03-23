<?php

include("../includes/common.php");

//if($conf['reg_open']==0)sysmsg('未开放商户申请');

$csrf_token = generate_csrf_token();
$_SESSION['csrf_token'] = $csrf_token;
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>找回密码 | <?php echo $conf['sitename']?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" href="<?php echo $cdnpublic?>twitter-bootstrap/3.4.1/css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $cdnpublic?>animate.css/3.7.2/animate.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $cdnpublic?>font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="./assets/css/font.css" type="text/css" />
<link rel="stylesheet" href="./assets/css/app.css" type="text/css" />
<style>
/* Modern Auth UI Overrides */
body {
    background: linear-gradient(135deg, #f0f2f5 0%, #e9ecef 100%);
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}
.app-header-fixed {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 20px 0;
}
.w-xxl {
    width: 420px;
    max-width: 100%;
    margin: 0 auto;
    background: #ffffff;
    padding: 40px 35px;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
}
.navbar-brand {
    font-size: 26px;
    font-weight: 700;
    color: #1a73e8 !important;
    text-align: center;
    margin-bottom: 10px;
    display: block;
}
.wrapper.text-center strong {
    font-size: 15px;
    color: #5f6368;
    font-weight: 500;
}
.list-group-sm {
    border-radius: 12px;
    box-shadow: none;
    border: 1px solid #e8eaed;
    overflow: hidden;
    margin-top: 15px;
}
.list-group-item {
    border: none;
    border-bottom: 1px solid #e8eaed;
    padding: 16px 20px;
}
.list-group-item:last-child {
    border-bottom: none;
}
.form-control.no-border {
    font-size: 15px;
    color: #202124;
    padding: 0;
}
.form-control.no-border::placeholder {
    color: #9aa0a6;
}
.form-control {
    border: none;
    box-shadow: none;
    padding-left: 0;
    font-size: 15px;
}
.input-group-addon {
    background: transparent;
    border: none;
    color: #1a73e8;
    font-weight: 600;
    cursor: pointer;
    padding: 0 0 0 15px;
}
.input-group-addon:hover {
    color: #1557b0;
    text-decoration: none;
}
.btn-primary {
    background-color: #1a73e8 !important;
    border-color: #1a73e8 !important;
    border-radius: 10px;
    font-weight: 600;
    font-size: 16px;
    padding: 12px;
    margin-top: 25px;
    transition: all 0.2s;
}
.btn-primary:hover {
    background-color: #1557b0 !important;
    border-color: #1557b0 !important;
    box-shadow: 0 4px 12px rgba(26,115,232,0.3);
}
.btn-default {
    border-radius: 10px;
    font-weight: 600;
    font-size: 16px;
    padding: 12px;
    background-color: #f8f9fa !important;
    color: #5f6368 !important;
    border: 1px solid #e8eaed !important;
    transition: all 0.2s;
    margin-top: 15px;
}
.btn-default:hover {
    background-color: #f1f3f4 !important;
    color: #202124 !important;
}
.text-muted {
    color: #9aa0a6 !important;
}
img.logo{width:14px;height:14px;margin:0 5px 0 3px;}
</style>
</head>
<body>
<div class="app app-header-fixed  ">
<div class="container w-xxl w-auto-xs" ng-controller="SigninFormController" ng-init="app.settings.container = false;">
<span class="navbar-brand block m-t" id="sitename"><?php echo $conf['sitename']?></span>
<div class="m-b-lg">
<div class="wrapper text-center">
<strong>找回密码</strong>
</div>
<form name="form" class="form-validation">
<input type="hidden" name="csrf_token" value="<?php echo $csrf_token?>">
<div class="text-danger wrapper text-center" ng-show="authError">
</div>
<div class="list-group list-group-sm swaplogin">
<div class="list-group-item">
<select class="form-control" name="type">
<option value="email">使用邮箱找回</option><option value="phone">使用手机找回</option></select>
</div>
<div class="list-group-item">
<input type="text" name="account" placeholder="邮箱/手机号" class="form-control no-border" required>
</div>
<div class="list-group-item">
<div class="input-group">
<input type="text" name="code" placeholder="输入验证码" class="form-control no-border" required>
<a class="input-group-addon" id="sendcode">获取验证码</a>
</div>
</div>
<div class="list-group-item">
<input type="password" name="pwd" placeholder="请输入新密码" class="form-control no-border" required>
</div>
<div class="list-group-item">
<input type="password" name="pwd2" placeholder="请重新输入密码" class="form-control no-border" required>
</div>
</div>
<button type="button" id="submit" class="btn btn-lg btn-primary btn-block" ng-click="login()" ng-disabled='form.$invalid'>确认提交</button>
<a href="login.php" ui-sref="access.signup" class="btn btn-lg btn-default btn-block">返回登录</a>
</form>
</div>
<div class="text-center">
<p>
<small class="text-muted"><a href="/"><?php echo $conf['sitename']?></a><br>&copy; 2016~<?php echo date("Y")?></small>
</p>
</div>
</div>
</div>
<script src="<?php echo $cdnpublic?>jquery/3.4.1/jquery.min.js"></script>
<script src="<?php echo $cdnpublic?>twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="<?php echo $cdnpublic?>layer/3.1.1/layer.js"></script>
<script src="<?php echo $cdnpublic?>jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<script src="<?php echo $cdnpublic?>jsencrypt/3.5.4/jsencrypt.min.js"></script>
<script src="//static.geetest.com/static/tools/gt.js"></script>
<script>
window.appendChildOrg = Element.prototype.appendChild;
Element.prototype.appendChild = function() {
    if(arguments[0].tagName == 'SCRIPT'){
        arguments[0].setAttribute('referrerpolicy', 'no-referrer');
    }
    return window.appendChildOrg.apply(this, arguments);
};
</script>
<script src="//static.geetest.com/v4/gt4.js"></script>
<script>
const PUBLIC_KEY_PEM = `<?php echo base64ToPem($conf['public_key'], 'PUBLIC KEY')?>`;
function invokeSettime(obj){
    var countdown=60;
    settime(obj);
    function settime(obj) {
        if (countdown == 0) {
            $(obj).attr("data-lock", "false");
            $(obj).text("获取验证码");
            countdown = 60;
            return;
        } else {
			$(obj).attr("data-lock", "true");
            $(obj).attr("disabled",true);
            $(obj).text("(" + countdown + ") s 重新发送");
            countdown--;
        }
        setTimeout(function() {
                    settime(obj) }
                ,1000)
    }
}
var handlerEmbed = function (captchaObj) {
	var sendto,type;
	captchaObj.onReady(function () {
		$("#wait").hide();
	}).onSuccess(function () {
		var result = captchaObj.getValidate();
		if (!result) {
			return alert('请完成验证');
		}
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax.php?act=sendcode2",
			data : {type:type,sendto:sendto,...result},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 0){
					new invokeSettime("#sendcode");
					layer.msg('发送成功，请注意查收！');
				}else{
					layer.alert(data.msg);
					captchaObj.reset();
				}
			} 
		});
	}).onError(function(){
		layer.msg('验证码加载失败，请刷新页面重试', {icon: 5});
	});
	$('#sendcode').click(function () {
		if ($(this).attr("data-lock") === "true") return;
		type = $("select[name='type']").val();
		sendto=$("input[name='account']").val();
		if(type=='phone'){
			if(sendto==''){layer.alert('手机号码不能为空！');return false;}
			if(sendto.length!=11){layer.alert('手机号码不正确！');return false;}
		}else{
			if(sendto==''){layer.alert('邮箱不能为空！');return false;}
			var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
			if(!reg.test(sendto)){layer.alert('邮箱格式不正确！');return false;}
		}
		if(typeof captchaObj.showCaptcha === 'function'){
			captchaObj.showCaptcha();
		}else{
			captchaObj.verify();
		}
	});
};
$(document).ready(function(){
	$("select[name='type']").change(function(){
		if($(this).val() == 'email'){
			$("input[name='account']").attr('placeholder','邮箱');
		}else{
			$("input[name='account']").attr('placeholder','手机号码');
		}
	});
	$("select[name='type']").change();
	$("#submit").click(function(){
		if ($(this).attr("data-lock") === "true") return;
		var type=$("select[name='type']").val();
		var account=$("input[name='account']").val();
		var code=$("input[name='code']").val();
		var pwd=$("input[name='pwd']").val();
		var pwd2=$("input[name='pwd2']").val();
		if(account=='' || code=='' || pwd=='' || pwd2==''){layer.alert('请确保各项不能为空！');return false;}
		if(pwd!=pwd2){layer.alert('两次输入密码不一致！');return false;}
		if(type=='phone'){
			if(account.length!=11){layer.alert('手机号码不正确！');return false;}
		}else{
			var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
			if(!reg.test(account)){layer.alert('邮箱格式不正确！');return false;}
		}
		var enc_type = '0';
		if(PUBLIC_KEY_PEM != ''){
			const enc = new JSEncrypt();
			enc.setPublicKey(PUBLIC_KEY_PEM);
			pwd = enc.encrypt(pwd);
			if(pwd) enc_type = '1';
		}
		var csrf_token=$("input[name='csrf_token']").val();
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$(this).attr("data-lock", "true");
		$.ajax({
			type : "POST",
			url : "ajax.php?act=findpwd",
			data : {type:type,account:account,code:code,pwd:pwd,enc:enc_type,csrf_token:csrf_token},
			dataType : 'json',
			success : function(data) {
				$("#submit").attr("data-lock", "false");
				layer.close(ii);
				if(data.code == 1){
					layer.alert(data.msg, {icon: 1}, function(){window.location.href="login.php"});
				}else{
					layer.alert(data.msg);
				}
			}
		});
	});
	$.ajax({
		url: "ajax.php?act=captcha",
		type: "get",
		cache: false,
		dataType: "json",
		success: function (data) {
			if(data.version == 1){
				initGeetest4({
					captchaId: data.gt,
					product: 'bind',
					protocol: 'https://',
					riskType: 'slide',
					hideSuccess: true,
				}, handlerEmbed);
			}else{
				initGeetest({
					width: '100%',
					gt: data.gt,
					challenge: data.challenge,
					new_captcha: data.new_captcha,
					product: "bind",
					offline: !data.success
				}, handlerEmbed);
			}
		}
	});
});
</script>
</body>
</html>