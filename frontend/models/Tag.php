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
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tag'], 'required'],
            [['tag'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag' => '文章标签',
        ];
    }

    //获取所有标签
    public function getAllTags()
    {
        return Tag::find()->all();
    }


    //获取标签下的文章
    public function getTagArticles(){
        return $this->hasMany(Article::className(),['id'=>'article_id'])
            ->viaTable('article_tag',['tag_id'=>'id'])
            ->asArray();
    }


}
