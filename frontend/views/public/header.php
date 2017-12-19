<?php
use yii\helpers\Url;

?>


<div id="header">
    <p class="user-name"><span>Ra</span><span>nihu</span><span> Blog</span></p>

    <!--主题列表-->
    <ul class="theme-list">
        <li class="theme-default"><a></a></li>
        <li class="theme-darken-green"><a></a></li>
        <li class="theme-gray"><a></a></li>
        <li class="theme-darken-blue"><a></a></li>
        <li class="theme-blue"><a></a></li>
        <li class="theme-purple"><a></a></li>
    </ul>

    <!--导航-->
    <ul class="header-nav">
        <li><a href="<?= Url::to(['blog/index']) ?>"  class="index">首页</a></li>
        <li><a href="<?= Url::to(['blog/cate']) ?>" class="cate">分类</a></li>
        <li><a href="<?= Url::to(['blog/tag']) ?>" class="tag">标签</a></li>
        <li><a href="<?= Url::to(['blog/create']) ?>" class="create">写文章</a></li>
        <li><a href="<?= Url::to(['site/login']) ?>" class="login">登录</a></li>
    </ul>
</div>
