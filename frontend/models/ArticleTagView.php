<?php

namespace frontend\models;

use Yii;

use frontend\models\ArticleTag;

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
class ArticleTagView extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articleTagView';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tag_id','article_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_id' => 'ArticleTag ID',
            'cate_id' => 'ArticleCate ID',
        ];
    }

    //获取标签下的文章
    public function getTagArticle()
    {
        return $this->hasMany(Article::className(),['id'=>'article_id']);
    }

    //获取分类名
    public function getTagsName()
    {
        return $this->hasMany(ArticleTag::className(),['id'=>'tag_id']);
    }

}
