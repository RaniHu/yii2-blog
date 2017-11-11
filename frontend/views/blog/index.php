<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\assets\AppAsset;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SearchArticle */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'article_title',
            'article_intro:ntext',
            'article_content:ntext',
            'pub_date',
            // 'tag_id',
            // 'cate_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
