<?php
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/static/css/sidebar/sidebar.css');
AppAsset::addScript($this,'@web/static/js/sidebar/sidebar.js');

?>
<!--====右侧菜单栏====-->
<div class="right-sidebar">
    <!--搜索框-->

    <div class="search-input">
        <form method="get" action="<?= Url::to(['blog/index']) ?>">
            <input type="text" placeholder="search" name="searchText" class="search-input-area">
            <input type="submit" class="article-search-icon" value="">
        </form>
    </div>
    <!--文章标签-->
    <div class="tag-wrapper">
        <h3><i class="article-tag-icon"></i> <span>标签</span></h3>
        <ul class="tag-list" id="tag">
            <?php foreach ($tags as $tag): ?>
                <li><a data-params-id=<?=$tag['id']?> href="<?= Url::to(['blog/tag', 'id' => $tag['id']]) ?>"><i></i><?= $tag->tag ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <!--分类列表-->
    <div class="sort-wrapper">
        <h3><i class="article-cate-icon"></i> <span>分类</span></h3>
        <ul class="sort-list" id="cate">
            <?php foreach ($cates as $cate): ?>
                <li><a data-params-id=<?=$cate['id']?> href="<?= Url::to(['blog/cate', 'id' => $cate['id']]) ?>"><i></i><?= $cate->cate ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <!--时间轴-->
    <div class="timeline">
        <h3><i class="article-timeline-icon"></i> <span>时间轴</span></h3>
        <ul class="timeline-list">
            <li><a><span class="time-list-year">2017年</span><span class="time-list-total">(10)</span></a></li>
            <li><a><span class="time-list-year">2016年</span><span class="time-list-total">(3)</span></a></li>
            <li><a><span class="time-list-year">2015年</span><span class="time-list-total">(4)</span></a></li>
        </ul>
    </div>

</div>