<?php

use yii\helpers\Url;


?>

<div id="main">


    <!--======头图======-->
<div class="main-image tag-page">

</div>

    <!--中间内容-->
<div class="content-wrapper clearFix">

    <!--左侧标签分类-->
    <div class="left-content">

        <!--所有标签-->
        <div class="tag-page-info">

            <!--按标签分类-->
            <?php if (!$curTagArticle): ?>
                <div class="article-notfound">
                    <div class="article-notfound-icon"></div>
                    <p class="no-article-text">此标签下还没有文章哦，快去添加吧!</p>
                </div>
            <?php else: ?>
                <?php foreach ($curTagArticle as $curTagArticles): ?>
                    <div class="tag-list list-block">
                        <h3><?= $curTagArticles[0]['tagsName'][0]['tag'] ?></h3>
                        <ul class="cur-tag-article-list">
                            <?php foreach ($curTagArticles as $curArticleInfo) : ?>
                                <li><a href="<?= Url::to(['blog/detail', 'id' => $curArticleInfo['article_id']]) ?>">
                                        <span class="pub-time"><?= $curArticleInfo['tagArticle'][0]['pub_date'] ?></span>
                                        <span><?= $curArticleInfo['tagArticle'][0]['article_title'] ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>

                        </ul>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!--右侧菜单栏-->
    <?= $this->render('../public/sidebar.php', ['cates' => $cates, 'tags' => $tags]) ?>
</div>

</div>
