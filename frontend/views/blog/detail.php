<?php

use yii\helpers\Url;

?>
<div id="main">

    <!--======头图======-->
<div class="main-image detail-page">

</div>

    <!--中间内容-->
<div class="content-wrapper clearFix">

    <!-- ======左侧文章详情======-->
    <div class="left-content">
        <div class="article-detail-box">
            <!--标题-->
            <h1><?= $curArticle['article_title'] ?></h1>
            <div class="article-attach-info clearFix">
                <!--发布时间-->
                <p class="pubtime-cate">
                    <span class="cate-name"><?= $curArticle['cates']['cate'] ?></span>
                    <span class="article-pub-time"><?= $curArticle->pub_date ?></span>
                    <span class="article-author"><?= $curArticle['author']['username'] ?></span>
                </p>
                <!--tag标签-->
                <div class="cur-article-tag-all">
                    <i class="article-detail-tag-icon"></i>
                    <ul>
                        <?php foreach ($curTag as $curTags) : ?>
                            <li><a href="<?= Url::to(['blog/tag','id' => $curTags['id']]) ?>"><?= $curTags['tag'] ?> </a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!--文章内容-->
            <div class="cur-article-text">
                <?= $curArticle->article_content ?>
            </div>


        </div>
    </div>

    <!--======右侧菜单栏======-->
    <?= $this->render('../public/sidebar.php', ['cates' => $cates, 'tags' => $tags]) ?>

</div>
</div>

