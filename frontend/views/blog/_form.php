<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\Redactor\widgets\Redactor;

/* @var $this yii\web\View */
/* @var $model frontend\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $form->field($model, 'article_content')->widget(Redactor::className(), [ 
    'clientOptions' => [ 
        'imageManagerJson' => ['/redactor/upload/image-json'], 
        'imageUpload' => ['/redactor/upload/image'], 
        'fileUpload' => ['/redactor/upload/file'], 
        'lang' => 'zh_cn', 
        'plugins' => ['clips', 'fontcolor','imagemanager'] 
    ] 
]) ?>

