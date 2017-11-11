<?php

use frontend\assets\AppAsset;
use yii\helpers\Html;

?>

<?php

//获取控制器id
$controllerId = strtolower(Yii::$app->controller->id);

//变量为0，不显示头部
$is_show_header = 0;
if (!in_array(strtolower($controllerId), [

])) {
    $is_show_header = 1;
}

//变量为0，不显示底部
$is_show_footer = 0;
if (!in_array(strtolower($controllerId), [

])) {
    $is_show_footer = 1;
}

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php if ($is_show_footer) AppAsset::addCss($this, '@web/static/css/footer/footer.css'); ?>
    <?php if ($is_show_header)
        AppAsset::addCss($this, '@web/static/css/header/header.css');
        AppAsset::addScript($this,'@web/static/js/header/header.js')
    ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!--是否加载头部-->
<?php if ($is_show_header): ?>
    <?= $this->renderFile('../views/public/header.php') ?>
<?php endif; ?>


<!--======中间内容=====-->
<div id="main">
    <?= $content ?>
</div>


<!--是否加载底部-->
<?php if ($is_show_footer): ?>
    <?= $this->renderFile('../views/public/footer.php') ?>
<?php endif; ?>
<?php $this->endBody() ?>

</body>
</html>

<?php $this->endPage() ?>



