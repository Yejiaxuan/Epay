<?php
if(!defined('IN_CRONLITE'))exit();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8"/>
<title><?php echo $conf['title']?></title>
<meta name="keywords" content="<?php echo $conf['keywords']?>">
<meta name="description" content="<?php echo $conf['description']?>" />
<meta name="viewport"content="user-scalable=no, width=device-width">
<meta name="viewport"content="width=device-width, initial-scale=1"/>
<meta name="renderer"content="webkit">
<link rel="stylesheet" href="<?php echo $cdnpublic?>font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo $cdnpublic?>twitter-bootstrap/3.4.1/css/bootstrap.min.css" type="text/css" />
<script src="<?php echo $cdnpublic?>jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo $cdnpublic?>twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
/* Modern Base Styles */
body {
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #333;
    background-color: #f8f9fa;
    -webkit-font-smoothing: antialiased;
}
/* Navbar */
.navbar-default {
    background-color: #ffffff;
    border-color: rgba(0,0,0,0.05);
    box-shadow: 0 1px 8px rgba(0,0,0,0.03);
    margin-bottom: 0;
    padding: 10px 0;
}
.navbar-brand {
    display: flex;
    align-items: center;
    font-weight: 700;
    font-size: 22px;
    color: #1a73e8 !important;
}
.navbar-brand img {
    height: 32px;
    margin-right: 12px;
}
.navbar-default .navbar-nav > li > a {
    color: #555;
    font-size: 15px;
    font-weight: 500;
    padding: 15px 20px;
    transition: all 0.2s;
}
.navbar-default .navbar-nav > li > a:hover {
    color: #1a73e8;
}
.navbar-default .navbar-toggle {
    border-color: transparent;
}
.navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
    background-color: transparent;
}
.navbar-default .navbar-collapse {
    border-color: rgba(0,0,0,0.05);
}
/* Scroll to Top */
#scroll_Top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: #1a73e8;
    color: #fff;
    width: 40px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    border-radius: 50%;
    cursor: pointer;
    display: none;
    box-shadow: 0 4px 12px rgba(26,115,232,0.3);
    z-index: 999;
}
#scroll_Top:hover {
    background: #1557b0;
}
#scroll_Top a {
    display: none;
}
</style>
</head>
<body>

<header>
<nav class="navbar navbar-default" role="navigation">
<div class="container">
<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-top-collapse">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a href="/" class="navbar-brand">
<img src="assets/img/logo.png" onerror="this.style.display='none'">
<?php echo $conf['sitename']?>
</a>
</div>
<div class="navbar-collapse navbar-top-collapse collapse">
<ul class="nav navbar-nav navbar-right">
<li><a href="/">首页</a></li>
<li><a href="doc.html">开发文档</a></li>
<?php if($conf['test_open']){?>
<li><a href="/user/test.php">支付测试</a></li>
<?php }?>
<li><a href="/user/" class="btn-login-nav" style="color:#1a73e8;">用户中心</a></li>
</ul>
</div>
</div>
</nav>
</header>
<div id="scroll_Top" onclick="window.scrollTo({top:0, behavior:'smooth'})">
<i class="fa fa-arrow-up"></i>
</div>