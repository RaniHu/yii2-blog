<?php

namespace frontend\models;

use Yii;
use frontend\models\ArticleCate;
use frontend\models\ArticleTagView;

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
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     * 返回该AR类关联的数据表名
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_title', 'article_intro', 'article_content'], 'required'],
            [['article_intro', 'article_content'], 'string'],
            [['pub_date'], 'safe'],
            [['tag_id', 'cate_id'], 'integer'],
            [['article_title'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     * AR 把相应数据行的每一个字段映射为 AR 对象的一个个特性变量（Attribute）,
     * 一个特性就好像一个普通对象的公共属性一样
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_title' => 'Article Title',
            'article_intro' => 'Article Intro',
            'article_content' => 'Article Content',
            'pub_date' => 'Pub Date',
            'tag_id' => 'ArticleTag ID',
            'cate_id' => 'ArticleCate ID',
        ];
    }

    //获取文章的分类
    public function getCates()
    {
        return $this->hasOne(ArticleCate::className(),['id'=>'cate_id']);

    }

}

