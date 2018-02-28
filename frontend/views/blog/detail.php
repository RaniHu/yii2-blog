<?php

use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::addScript($this, '@web/static/js/blog/blogHandle.js');

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
                <p class="comment-num">共<?= $commentCount ?>条评论</p>
                <!--写评论-->
                <div class="write-comment-box  write-box">
                    <form method="get" method="post">
                        <textarea class="comment-texts" placeholder="写下你的评论" name="comment-contents"></textarea>
                        <div class="comment-btn">
                            <a class="cancle-btn">取消</a>
                            <?php if (Yii::$app->user->isGuest) : ?>
                                <a class="form-submit-btn send-btn" href="<?= Url::to(['/site/login']) ?>">评论</a>
                            <?php else: ?>
                                <a class="form-submit-btn send-btn has-login">评论</a>
                            <?php endif; ?>

                        </div>
                    </form>
                </div>
                <!--他人评论-->
                <div class="other-comments">
                    <?php foreach ($curCommentReply as $comments) : ?>
                        <!--评论列表-->
                        <div class="comment-list" data-id="<?= $comments['id'] ?>">
                        <h4><?= $comments['user']['username']?></h4>
                        <p class="comment-contents"><?= $comments['content']?></p>
                            <div class="other-info clearFix">
                                <p class="comment-date"><?= $comments['date'] ?></p>
                                <ul class="reply-comment-nav">
                                    <li class="reply-btn"><span>回复</span></li>
                                    <li class="reply-like"><i class="article-like-icon"></i><span>赞</span></li>
                                </ul>
                            </div>
                            <!--某评论下的回复列表-->
                            <div class="reply-list-box">
                                <?php if ($comments['reply']) : ?>
                                    <?php foreach ($comments['reply'] as $reply) : ?>
                                        <div class="reply-list">
                                            <p>
                                                <a class="reply-user-name"><?= $reply['user']['username'] ?>：</a>
                                                <span class="reply-content"><?= $reply['content'] ?></span>
                                            </p>
                                            <p>
                                                <span class="reply-date"><?= $reply['date'] ?></span>
                                                <span class="reply-btn">回复</span>
                                            </p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <!--回复框-->
                            <div class="write-reply-box write-box">
                                <textarea class="comment-texts" placeholder="写下你的回复" name="comment-contents"></textarea>
                                <div class="comment-btn">
                                    <a class="cancle-btn">取消</a>
                                    <?php if (Yii::$app->user->isGuest) : ?>
                                        <a class="form-submit-btn send-btn"
                                           href="<?= Url::to(['/site/login']) ?>">回复</a>
                                    <?php else: ?>
                                        <a class="form-submit-btn send-btn has-login">回复</a>
                                    <?php endif; ?>
                                </div>
                            </div>
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

