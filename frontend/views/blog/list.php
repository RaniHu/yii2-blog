<?php

use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::addScript($this, '@web/static/js/blog/blogHandle.js');

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
            <div class="cur-article-list clearfix">
                <a href="<?= Url::to(['blog/detail', 'id' => $articleInfo['id']]) ?>">
                    <div class="list-left">
                        <img class="user-icon" src=<?= '../../' . $articleInfo['author']['icon'] ?>>
                    </div>
                    <div class="list-right">

                        <!--作者-->
                        <h4><?=$articleInfo['author']['username']?></h4>

                        <div class="other-info">
                            <span class="article-pub-time"><?= $articleInfo['pub_date'] ?></span>
<!--                            <span class="article-sort"><i class=""></i>--><?//= $articleInfo['cates']['cate'] ?><!--</span>-->
                        </div>

                        <!--文章标题-->
                        <h3><?= Html::encode("{$articleInfo['article_title']}") ?></h3>

                        <!--简介-->
                        <div class="article-intro">
                            <?= $articleInfo['article_intro'] ?>
                        </div>
                        <!--发布时间及分类-->

                    </div>
                </a>
                <!--相关操作-->
                <div class="article-operate">
                    <span class="open-icon-box"><i class="open-icon"></i></span>
                    <ul class="operate-menu">
                        <li>
                            <a href="<?= Url::to(['blog/update', 'id' => $articleInfo['id']]) ?>" data-method="post">编辑文章</a>
                        </li>
                        <li>
                            <a>删除文章</a>
                        </li>
                    </ul>
                    <!--确认弹框-->
                    <div class="confirm-box">
                        <p>确认要删除这篇文章吗？</p>
                        <div class="confirm-btn">
                            <a href="<?= Url::to(['blog/delete', 'id' => $articleInfo['id']]) ?>" data-method="post">确认</a>
                            <a class="cancle-btn">取消</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>