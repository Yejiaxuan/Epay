<?php
if(!defined('IN_CRONLITE'))exit();
?>
<style>
/* Modern Footer */
.site-footer {
    background-color: #202124;
    color: #9aa0a6;
    padding: 60px 0 20px;
    font-size: 14px;
}
.footer-heading {
    color: #ffffff;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.footer-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.footer-list li {
    margin-bottom: 12px;
}
.footer-list a {
    color: #9aa0a6;
    text-decoration: none;
    transition: color 0.2s;
}
.footer-list a:hover {
    color: #ffffff;
    text-decoration: none;
}
.footer-list strong {
    color: #e8eaed;
}
.footer-bottom {
    margin-top: 50px;
    padding-top: 20px;
    border-top: 1px solid rgba(255,255,255,0.1);
    text-align: center;
}
</style>

<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-xs-12 mb-4">
                <h4 class="footer-heading">关于我们</h4>
                <ul class="footer-list">
                    <li><?php echo $conf['sitename']?> 是 <?php echo $conf['orgname']?> 旗下的专业免签约支付产品，致力于为开发者提供稳定、安全的支付接入服务。</li>
                </ul>
            </div>
            <div class="col-sm-4 col-xs-6 mb-4">
                <h4 class="footer-heading">产品与服务</h4>
                <ul class="footer-list">
                    <li><a href="agreement.html" target="_blank">服务条款</a></li>
                    <li><a href="doc.html" target="_blank">开发文档</a></li>
                </ul>
            </div>
            <div class="col-sm-4 col-xs-6 mb-4">
                <h4 class="footer-heading">联系我们</h4>
                <ul class="footer-list">
                    <li><strong>QQ:</strong> <a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&Site=pay&Menu=yes" target="_blank"><?php echo $conf['kfqq']?></a></li>
                    <li><strong>Email:</strong> <a href="mailto:<?php echo $conf['email']?>"><?php echo $conf['email']?></a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="footer-bottom">
                    <p><?php echo $conf['sitename']?> &copy; <?php echo date("Y")?> All Rights Reserved. <?php echo $conf['footer']?></p>
                </div>
            </div>
        </div>
    </div>
</footer>

</body>
</html>