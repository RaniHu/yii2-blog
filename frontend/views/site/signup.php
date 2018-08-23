<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::addCss($this, '@web/static/css/site/site.css');

?>
<div id="register-box">
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
        <form id="form-signup" method="post" role="form">

            <!--用户名-->
            <div class="form-block">
                <input type="text" id="signupform-username" name="SignupForm[username]" autofocus="" placeholder="用户名">
            </div>

            <!--邮箱-->
            <div class="form-block">
                <input type="text" id="signupform-email"  name="SignupForm[email]" placeholder="邮箱">
            </div>

            <!--密码-->
            <div class="form-block">
                <input type="password" id="signupform-password" name="SignupForm[password]" placeholder="密码">
            </div>

            <!--确定-->
            <button type="submit" class="confirm-btn" name="login-button">Enter ></button>

        </form>
    </div>
</div>
