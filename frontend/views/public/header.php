<?php
use yii\helpers\Url;
?>


<div id="header">
    <p class="user-name"><span>Ra</span><span>nihu</span><span> Blog</span></p>
    <ul class="header-nav">
        <li><a href="<?= Url::to(['blog/index']) ?>"  class="index">首页</a></li>
        <li><a href="<?= Url::to(['blog/cate']) ?>" class="cate">分类</a></li>
        <li><a href="<?= Url::to(['blog/tag']) ?>" class="tag">标签</a></li>
        <li><a href="<?= Url::to(['blog/create']) ?>" class="create">写文章</a></li>
    </ul>
</div>
