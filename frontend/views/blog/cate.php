<?php

use yii\helpers\Url;

?>

<!--======头图======-->
<div class="main-image cate-page">

</div>

<!--中间内容-->
<div class="content-wrapper clearFix">
    <!--左侧文章分类-->
    <div class="left-content">

        <div class="cate-page-info">
            <?php if (!$cateArticles): ?>
            <div class="article-notfound">
                <div class="article-notfound-icon"></div>
                <p class="no-article-text">此分类还没有文章哦，快去添加吧!</p>
            </div>
            <?php else:?>
            <?php foreach ($cateArticles as $cateArticle): ?>
                <div class="cate-list list-block">
                    <h3><?= $cateArticle['cate'] ?></h3>
                    <ul class="cur-cate-article-list">
                        <?php if (!$cateArticle['cates']):?>
                            <li>该分类下暂无文章哦！</li>
                        <?php else:?>

                        <?php foreach ($cateArticle['cates'] as $articles):?>
                            <li>
                                <a  href="<?= Url::to(['blog/detail', 'id' => $articles['id']]) ?>">
                                    <span class="pub-time"><?= $articles['pub_date']?></span>
                                    <span><?= $articles['article_title']?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        <?php endif;?>
                    </ul>
                </div>
            <?php endforeach;?>
            <?php endif?>
        </div>



    </div>

    <!--右侧菜单栏-->
    <?= $this->render('../public/sidebar.php', ['cates' => $cates, 'tags' => $tags]) ?>
</div>