<?php

//AppAsset::register($this);
//AppAsset::addCss($this, '@web/static/css/blog/blog.css');
$this->title = '我的博客';
?>

<div id="main">


    <!--======头图======-->
<div class="main-image home-page">

</div>

    <!--中间内容-->
<div class="content-wrapper clearFix">
    <!--左侧文章列表-->
    <?= $this->render('list.php', ['articleList'=>$articleList]) ?>

    <!--右侧菜单栏-->
    <?= $this->render('../public/sidebar.php', ['cates' => $cates, 'tags' => $tags]) ?>

    <!--分页器-->
</div>
</div>


