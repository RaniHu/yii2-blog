<?php

use yii\helpers\Url;

?>


<div id="header">
    <p class="user-logo"><span>Ra</span><span>nihu</span><span> Blog</span></p>

    <!--主题列表-->
    <ul class="theme-list">
        <li class="theme-default"><a></a></li>
        <li class="theme-darken-green"><a></a></li>
        <li class="theme-gray"><a></a></li>
        <li class="theme-darken-blue"><a></a></li>
        <li class="theme-blue"><a></a></li>
        <li class="theme-purple"><a></a></li>
    </ul>


    <!--用户登录导航-->
    <ul class="user-login-nav">
        <?php if (Yii::$app->user->isGuest) : ?>
            <li><a href="<?= Url::to(['/site/login']) ?>" class="login-btn">登录</a></li>
            <li><a>/</a></li>
            <li><a href="<?= Url::to(['/site/signup']) ?>" class="register-btn">注册</a></li>
        <?php else: ?>
            <li>
                <a class="user-name"><?=Yii::$app->user->identity->username?></a>
                <!--用户设置菜单-->
                <ul class="user-config-menu">
                    <li><a>我的文章</a></li>
                    <li ><a href="<?= Url::to(['blog/config']) ?>">设置</a></li>
                    <li><a class="user-logout" href="<?= Url::to(['site/logout']) ?>" data-method="post">退出</a></li>
                </ul>
            </li>
        <?php endif; ?>
    </ul>

    <!--导航-->
    <ul class="header-nav">
        <li><a href="<?= Url::to(['blog/index']) ?>"  class="index">首页</a></li>
        <li><a href="<?= Url::to(['blog/cate']) ?>" class="cate">分类</a></li>
        <li><a href="<?= Url::to(['blog/tag']) ?>" class="tag">标签</a></li>
        <li><a href="<?= Url::to(['blog/create']) ?>" class="create">写文章</a></li>
    </ul>

</div>
