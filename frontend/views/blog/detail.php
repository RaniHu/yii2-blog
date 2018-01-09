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
            <input  id="article-id" type="hidden" value=<?= $curArticle['id'] ?>>
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

            <!--文章评论区域-->
            <div id="article-comment-area">
                <p class="comment-num"><?=$commentCount?>条评论</p>
                <!--写评论-->
                <div class="write-comment">
                    <form method="get">
                        <textarea class="comment-texts" placeholder="写下你的评论" name="comment-contents"></textarea>
                        <div class="comment-btn">
                            <a type="button" class="cancle-btn" value="取消">
                                <a type="submit" class="send-btn form-submit-btn">取消</a>
                                <a class="form-submit-btn comment-send-btn">评论</a>
                        </div>
                    </form>
                </div>
                <!--他人评论-->
                <div class="other-comments">
                    <?php foreach ($articleComments as $comments) : ?>
                    <div class="comment-list">
                        <h4><?= $comments['user']['username']?></h4>
                        <p class="comment-contents"><?= $comments['content']?></p>
                        <p class="comment-date"><?= $comments['date']?></p>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>


        </div>
    </div>

    <!--======右侧菜单栏======-->
    <?= $this->render('../public/sidebar.php', ['cates' => $cates, 'tags' => $tags]) ?>

</div>
</div>

