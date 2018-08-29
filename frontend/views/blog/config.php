<?php

use frontend\assets\AppAsset;

AppAsset::addCss($this, '@web/static/css/lib/cropper.css');
AppAsset::addCss($this, '@web/static/fonts/fonts-style.css');
AppAsset::addScript($this, '@web/static/js/blog/blogHandle.js');
AppAsset::addScript($this, '@web/static/js/lib/cropper.js');
AppAsset::addScript($this, '@web/static/js/blog/uploadIcon.js');
AppAsset::addScript($this, '@web/static/js/public/msgBox.js');

?>
<div id="main">

    <!--内容-->
    <div class="content-wrapper clearFix">
        <h1>用户设置</h1>
        <div id="user-config-box">
            <ul>
                <li>
                    <span>用户名</span>
                    <span class="username"><?= $userInfo['username'] ?></span>
                </li>
                <li>
                    <span>邮箱</span>
                    <input type="text" name="email" id="email" value=<?= $userInfo['email'] ?>>
                    <b>*</b>
                </li>
                <li>
                    <span>签名</span>
                    <input type="text" name="sign" id="sign" value=<?= $userInfo['sign'] ?>>
                </li>
                <li>
                    <span>头像</span>
                        <?php if ($userInfo['icon']) : ?>
                            <img class="user-cur-icon" id="final-img" src=<?= '../../' . $userInfo['icon'] ?>>
                        <?php else: ?>
                            <img class="user-cur-icon" id="final-img" src="../../static/image/default-user-icon.png">
                        <?php endif ?>
                        <input name="icon" id="icon" type="text" hidden>
                </li>
            </ul>
            <div class="submit-btn">
                <button type="button"  class="l-btn" id="sub-btn">确定</button>
            </div>
            <!--头像设置弹出框-->
            <div id="icon-config-box">
                <div class="config-title">
                    <span>头像设置</span>
                    <i class="close-btn-icon"></i>
                </div>
                <div class="upload-main clearfix">
                    <div class="icon-show-area">
                        <p>只支持JPG、PNG格式，大小不超过2M</p>
                        <img id="tailoringImg">
                    </div>
                    <div class="preview-icon-area">
                        <p>预览</p>
                        <div class="preview-icon-large previewImg"></div>
                        <div class="preview-icon-small previewImg"></div>
                    </div>
                </div>

                <!--剪裁弹出框-->
                <div class="icon-tailoring-content">
                    <div class="sort-item">
                        <button type="button" class="l-btn cropper-rotate-left-btn" title="向左旋转">
                            <span class="icon-rotate-left"></span>
                        </button>
                        <button type="button" class="l-btn cropper-rotate-right-btn" title="向右旋转">
                            <span class="icon-rotate-right"></span>
                        </button>
                    </div>
                    <div class="sort-item">
                        <button type="button" class="l-btn cropper-arrow-left-btn" title="左移">
                            <span class="icon-arrow-left"></span>
                        </button>
                        <button type="button" class="l-btn cropper-arrow-right-btn" title="右移">
                            <span class="icon-arrow-right"></span>
                        </button>
                        <button type="button" class="l-btn cropper-arrow-up-btn" title="上移">
                            <span class="icon-arrow-up"></span>
                        </button>
                        <button type="button" class="l-btn cropper-arrow-down-btn" title="下移">
                            <span class="icon-arrow-down"></span>
                        </button>

                    </div>
                    <div class="sort-item">
                        <button type="button" class="l-btn cropper-large-btn" title="放大">
                            <span class="icon-zoom-in"></span>
                        </button>
                        <button type="button" class="l-btn cropper-small-btn" title="缩小">
                            <span class="icon-zoom-out"></span>
                        </button>
                    </div>
                    <div class="sort-item">
                        <button type="button" class="l-btn cropper-scaleX-btn" title="换向">
                            <span class="icon-scaleX"></span>
                        </button>
                        <button type="button" class="l-btn cropper-reset-btn" title="重置">
                            <span class="icon-reset"></span>
                        </button>
                        <button type="button" class="l-btn cropper-upload-btn" title="上传图片">
                            <label for="chooseImg">
                                <span class="icon-upload"></span>
                                <input type="file" accept="image/jpg,image/png,image/jpeg" id="chooseImg" style="display: none"/>
                            </label>

                        </button>
                    </div>
                    <button type="button" class="l-btn sureCut" id="sureCut">确定修改</button>
                </div>
            </div>
        </div>
        <div id="mask"></div>
    </div>
</div>


