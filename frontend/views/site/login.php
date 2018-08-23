<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::addCss($this, '@web/static/css/site/site.css');

?>
<div id="login-box">
    <!--头部-->
    <div class="box-header">
        <ul class="action-btn">
            <li><a href="<?= Url::to(['/site/signup']) ?>" class="register-btn">注册</a></li>
            <li><a href="<?= Url::to(['/site/login']) ?>" class="login-btn">登录</a></li>
        </ul>
    </div>
    <!--中间-->
    <div class="box-main">
        <h2><span>Welcome</span><span>back!</span></h2>
        <form id="login-form" method="post" role="form">

            <!--用户名-->
            <div class="form-block">
                <input type="text" id="loginform-username" class="" name="LoginForm[username]" autofocus=""
                       placeholder="用户名">
            </div>

            <!--密码-->
            <div class="form-block">
                <input type="password" id="loginform-password" class="" name="LoginForm[password]" placeholder="密码">
            </div>

            <div class="form-block pwd-action clearFix">
                <!--记住密码-->
                <span class="remember-pwd">
                    <input type="hidden" name="LoginForm[rememberMe]" value="0">
                    <input type="checkbox" id="loginform-rememberme" name="LoginForm[rememberMe]" value="1" checked="">
                    记住密码
                </span>
                <!--忘记密码-->
                <a href="<?= Url::to(['site/request-password-reset']) ?>" class="forget-pwd">忘记密码?</a>
            </div>
            <!--确定-->
            <button type="submit" class="confirm-btn" name="login-button">Enter ></button>

        </form>

    </div>
</div>
