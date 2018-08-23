<?php

namespace frontend\models;

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
class Cate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cate';
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
            'cate' => '文章分类',
        ];
    }


    //获取所有分类
    public function getAllCates()
    {
        return Cate::find()->all();
    }


    //获取分类下的文章
    public function getCateArticles()
    {
        return $this->hasMany(Article::className(),['cate_id'=>'id'])
            ->asArray();

    }

}
