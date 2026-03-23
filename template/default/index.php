<?php
if(!defined('IN_CRONLITE'))exit();
require INDEX_ROOT.'head.php';
?>
<style>
/* Hero Section */
.hero-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    text-align: center;
}
.hero-title {
    font-size: 3rem;
    font-weight: 700;
    color: #202124;
    margin-bottom: 20px;
}
.hero-subtitle {
    font-size: 1.25rem;
    color: #5f6368;
    margin-bottom: 40px;
}
.hero-actions .btn {
    padding: 12px 30px;
    font-size: 1.1rem;
    font-weight: 500;
    border-radius: 8px;
    margin: 0 10px;
    transition: all 0.2s;
}
.btn-primary-custom {
    background-color: #1a73e8;
    color: white;
    border: none;
    box-shadow: 0 4px 6px rgba(26,115,232,0.2);
}
.btn-primary-custom:hover {
    background-color: #1557b0;
    color: white;
    box-shadow: 0 6px 10px rgba(26,115,232,0.3);
}
.btn-outline-custom {
    background-color: transparent;
    color: #1a73e8;
    border: 2px solid #1a73e8;
}
.btn-outline-custom:hover {
    background-color: rgba(26,115,232,0.05);
    color: #1557b0;
}

/* Features Section */
.features-section {
    padding: 80px 0;
    background: white;
}
.section-title {
    text-align: center;
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 50px;
    color: #202124;
}
.feature-card {
    text-align: center;
    padding: 40px 20px;
    border-radius: 12px;
    background: #f8f9fa;
    transition: transform 0.3s ease;
    height: 100%;
    margin-bottom: 30px;
}
.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
}
.feature-icon {
    font-size: 40px;
    color: #1a73e8;
    margin-bottom: 20px;
}
.feature-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 15px;
    color: #202124;
}
.feature-desc {
    color: #5f6368;
    line-height: 1.6;
}

/* Partners Section */
.partners-section {
    padding: 60px 0;
    background: #f8f9fa;
    text-align: center;
}
.partner-logo {
    max-width: 120px;
    height: auto;
    margin: 20px auto;
    filter: grayscale(100%);
    opacity: 0.7;
    transition: all 0.3s;
}
.partner-logo:hover {
    filter: grayscale(0%);
    opacity: 1;
}
</style>

<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h1 class="hero-title">欢迎使用<?php echo $conf['sitename']?></h1>
                <p class="hero-subtitle">提供安全、稳定、快捷的支付接口服务，支持多种支付方式，费率超低，极速接入。</p>
                <div class="hero-actions">
                    <a href="/user/" class="btn btn-primary-custom">登录商户</a>
                    <a href="/user/reg.php" class="btn btn-outline-custom">注册商户</a>
                </div>
            </div>
        </div>
    </div>
</section>
   
<section class="features-section">
    <div class="container">
        <h2 class="section-title"><?php echo $conf['sitename']?> 核心优势</h2>
        <div class="row">
            <div class="col-sm-4">
                <div class="feature-card">
                    <i class="fa fa-credit-card feature-icon"></i>
                    <h3 class="feature-title">多种支付方式</h3>
                    <p class="feature-desc">支持支付宝、微信、QQ钱包、云闪付等主流支付方式，满足您的所有收款需求。</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="feature-card">
                    <i class="fa fa-percent feature-icon"></i>
                    <h3 class="feature-title">对接费率超低</h3>
                    <p class="feature-desc">极具竞争力的费率体系，每笔交易手续费更低，为您最大程度节省成本。</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="feature-card">
                    <i class="fa fa-bank feature-icon"></i>
                    <h3 class="feature-title">资金安全保障</h3>
                    <p class="feature-desc">无需自主提现，满一定金额即可自动结算到您的收款账户，资金安全无忧。</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="partners-section">
    <div class="container">
        <h2 class="section-title" style="margin-bottom: 30px; font-size: 1.75rem;">合作伙伴</h2>
        <div class="row">
            <div class="col-xs-6 col-sm-3">
                <img src="<?php echo STATIC_ROOT?>images/alipay.png" class="partner-logo img-responsive" alt="支付宝">
            </div>
            <div class="col-xs-6 col-sm-3">
                <img src="<?php echo STATIC_ROOT?>images/wxpay.png" class="partner-logo img-responsive" alt="微信支付">
            </div>
            <div class="col-xs-6 col-sm-3">
                <img src="<?php echo STATIC_ROOT?>images/qqpay.png" class="partner-logo img-responsive" alt="QQ钱包">
            </div>
            <div class="col-xs-6 col-sm-3">
                <img src="<?php echo STATIC_ROOT?>images/tenpay.png" class="partner-logo img-responsive" alt="财付通">
            </div>
        </div>
    </div>
</section>

<?php require INDEX_ROOT.'foot.php';?>