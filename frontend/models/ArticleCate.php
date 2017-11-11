<?php

namespace frontend\models;

use Yii;
use frontend\models\Article;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $article_title
 * @property string $article_intro
 * @property string $article_content
 * @property string $pub_date
 * @property integer $tag_id
 * @property integer $cate_id
 */
class ArticleCate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articleCate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cate'], 'required'],
            [['cate'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cate' => 'CATE',
        ];
    }
    //获取文章的分类
    public function getCates()
    {
        return $this->hasMany(Article::className(),['cate_id'=>'id']);

    }

}
