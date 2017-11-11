<?php

use yii\helpers\Html;
use yii\helpers\Url;


?>

<div class="left-content">
    <!--当前文章列表-->
    <?php if (!$articleList): ?>
        <div class="article-notfound">
            <div class="article-notSearch-icon"></div>
            <p class="no-article-text">暂无相关文章哦，搜索其他内容试试吧!</p>
        </div>
    <?php else: ?>
        <?php foreach ($articleList as $articleInfo): ?>
            <a href="<?= Url::to(['blog/detail', 'id' => $articleInfo['id']]) ?>">
            <div class="cur-article-list">

                <h3><?= Html::encode("{$articleInfo['article_title']}") ?></h3>
                <div class="article-intro">
                    <?= $articleInfo['article_intro'] ?>
                </div>
                <div class="other-info">
                    <span class="article-time"><i class="article-time-icon"></i> <?= $articleInfo['pub_date'] ?></span>
                    <span class="article-sort"><i class="article-sort-icon"></i><?= $articleInfo['cates']['cate'] ?></span>
                </div>

            </div>
        </a>
        <?php endforeach; ?>
    <?php endif; ?>

</div>