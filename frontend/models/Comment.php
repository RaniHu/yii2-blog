<?php

namespace frontend\models;

use common\models\User;
use Yii;


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
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'user_id', 'content'], 'required'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => '文章id',
            'user_id' => '评论用户id',
            'content' => '评论内容',
            'date' => '评论时间',
        ];
    }


    //获取某篇文章下的评论条数
    public function getCommentsNum($articleId)
    {
        return Comment::find()->where(['article_id' => $articleId])->count();
    }

    //获取每篇文章下的评论内容
    public function getAllComments($articleId)
    {
        $allComments = Comment::find()->with('user')->where(['article_id' => $articleId])->asArray()->all();
        return $allComments;
    }


    //评论与作者的一对一关系
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])
            ->asArray();
    }

    //创建评论
    public function createComment()
    {
        //开启事务
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new Comment;
            $get = Yii::$app->request->get();
            $commContent = $get['commentContents'];
            $articleId = intval($get['articleId']);

            //保存评论
            $model->article_id = $articleId;
            $model->user_id = Yii::$app->user->identity->id;
            $model->content = $commContent;
            $model->date = date("Y-m-d H:i:s");
            $model->save();

            //事务成功
            if ($model->save()) {
                $transaction->commit();
                return true;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }

    }

}
