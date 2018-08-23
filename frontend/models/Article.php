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
class Article extends \yii\db\ActiveRecord
{

    public $_lastError = "事务处理出错啦！";

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
            [['cate_id'], 'integer'],
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
            'article_title' => '文章标题',
            'article_intro' => '文章简介',
            'article_content' => '正文',
            'pub_date' => '发布时间',
            'cate_id' => 'cate ID',
        ];
    }


    /**
     * 获取每篇文章的分类
     */
    public function getCates()
    {
        return $this->hasOne(Cate::className(), ['id' => 'cate_id']);

    }


    /**
     * 获取每篇文章的所有标签
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id'])
            ->asArray();
    }

    //获取每篇文章的作者
    public function getAuthor()
    {
        return $this->hasOne(User::className(),['id'=>'author_id']);
    }


    /**
     * 创建文章
     */
    public function create()
    {

        //开启事务
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model = new Article;
            $articleTagModel = new ArticleTag;
            $model->setAttributes($this->attributes);

            //保存文章表
            $model->setAttributes(array(
                'article_title' => $_POST['article_title'],
                'article_intro' => $_POST['article_intro'],
                'article_content' => $_POST['article_content'],
                'pub_date' => date("Y-m-d H:i:s"),
                'cate_id' => $_POST['article_cate'],
            ));
            $model->author_id=Yii::$app->user->identity->id;
            $model->save();
            $articleId = $model->attributes['id'];

            //批量插入文章标签关系表
            if ($model->save(false)) {

                //遍历标签
                for ($i = 0; $i < count($_POST['article_tag']); $i++) {
                    $res[$i] = [$_POST['article_tag'][$i], $articleId];
                }
                Yii::$app->db->createCommand()->batchInsert($articleTagModel::tableName(), ['tag_id', 'article_id'], $res)->execute();
                if ($articleTagModel->save(false)) {
                    $articleTagModel::deleteAll(['article_id' => 0]);
                    $transaction->commit();
                    return true;
                }
            }

        } catch (\Exception $e) {
            echo '新增失败！';
            $transaction->rollBack();
            return false;
        }

    }


    /**
     * 修改文章
     */
    public function updateArticle($articleId)
    {

        //开启事务
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model = Article::findOne($articleId);
            $articleTagModel = new ArticleTag;

            //修改文章表
            $model->article_title=$_POST['article_title'];
            $model->article_intro=$_POST['article_intro'];
            $model->article_content=$_POST['article_content'];
            $model->cate_id=$_POST['article_cate'];
            $model->save();

            //批量插入文章标签关系表
            if ($model->save(false)) {

                //删除关联表中之前的标签
                $articleTagModel::deleteAll(['article_id' => $articleId]);

                //遍历标签
                for ($i = 0; $i < count($_POST['article_tag']); $i++) {
                    $res[$i] = [$_POST['article_tag'][$i], $articleId];
                }
                Yii::$app->db->createCommand()->batchInsert($articleTagModel::tableName(), ['tag_id', 'article_id'], $res)->execute();
                if ($articleTagModel->save(false)) {
                    $articleTagModel::deleteAll(['article_id' => 0]);
                    $transaction->commit();
                    return true;
                }
            }

        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }

    }

    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

