<?php

use frontend\assets\AppAsset;
use ijackua\lepture\Markdowneditor;
use ijackua\lepture\MarkdowneditorAssets;

AppAsset::addCss($this, '@web/static/css/blog/articleCreate.css');
AppAsset::addScript($this, '@web/static/js/blog/blogHandle.js');
MarkdowneditorAssets::register($this);

?>


<!--中间内容-->
<div id="main">

    <div class="content-wrapper clearFix  write-article">

        <!--=======左侧创建文章=======-->
        <div class="left-content">
            <div id="write-article-form">
                <form method="post" name="create-article-form">
                    <!--=====基本信息填写======-->
                    <div class="article-info-form">
                        <!--===信息表单列表===-->
                        <div class="info-form-list basic-info-box">
                            <h4>文章基本信息</h4>
                            <!--文章标题-->
                            <div class="article-title-input">
                                <input type="text" placeHolder="文章标题" name='article_title' value=<?= $model['article_title']?>>
                            </div>
                            <!--文章简介-->
                            <div class="article-intro-input">
                                <textarea placeHolder="请填写文章简介" class="intro-inputArea" name='article_intro'><?= $model['article_intro']?></textarea>

                            </div>
                        </div>
                        <!--===信息表单列表===-->
                        <div class="info-form-list">
                            <h4>文章分类</h4>
                            <!--文章分类-->
                            <div class="article-cate-input">
                                <?php foreach ($cates as $key => $cate) : ?>
                                    <label>
                                        <span class="icon-box radio-icon-box"></span>
                                        <input type="radio" name="article_cate" value=<?php echo $cate->id?>  id=<?php echo "cate-radio".$key?> class="custom-check">
                                        <span class="radio-val"><?= $cate->cate ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!--===信息表单列表===-->
                        <div class="info-form-list">
                            <h4>文章标签</h4>
                            <!--文章标签-->
                            <div class="article-tag-input">
                                <?php foreach ($tags as $key=> $tag) : ?>
                                    <label for=<?php echo "tag-checkbox".$key?>>
                                        <span class="icon-box radio-icon-box"></span>
                                        <input type="checkbox" name="article_tag[]" value=<?php echo $tag->id?> id=<?php echo "tag-checkbox".$key?> class="custom-check">
                                        <span class="checkbox-val"><?= $tag->tag ?></span>
                                    </label>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>

                    <!--文章正文-->
                    <div class="article-content-area">
                        <?php echo Markdowneditor::widget(['model' => $model, 'attribute' => 'article_content','name'=>'article_content']); ?>
                    </div>
                    <div class="submit-btn">
                        <input type="submit" value="确定">
                    </div>

                </form>
            </div>
        </
        <div>

        </div>

        <!--=======右侧菜单栏======-->
        <?= $this->render('../public/sidebar.php', ['cates' => $cates, 'tags' => $tags]) ?>


    </div>

</div>


