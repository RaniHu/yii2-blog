<?php

namespace frontend\models;

use Yii;
use Yii\db\Query;
use frontend\models\Tag;
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

    //获取每篇文章的分类
    public function getCates()
    {
        return $this->hasOne(Cate::className(), ['id' => 'cate_id']);

    }

    //获取每篇文章的所有标签
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id'])
            ->asArray();
    }


    //创建完成之后事件方法
    private function  _eventAfterCreate($data)
    {
        
        //删除原先的关联关系
        ArticleTag::deleteAll(['article_id'=>$data['id']]);

        if( $_POST['article_tag']){
            foreach( $_POST['article_tag'] as $key=>$val){
                $tags[$key]['article_id']=$this->id;
                $tags[$key]['tag_id']=$val;
            }
            //批量插入
            $res=Yii::$app->db->createCommand()
                ->batchInsert(ArticleTag::tableName(),['article_id','tag_id'],$tags)
                ->execute();

            if(!$res){
                throw new Exception("关系表保存失败!");
                
            }
        }

      


    }


    public function create()
    {

        //事务(保证数据的完整性)
       $transaction=Yii::$app->db->beginTransaction();

        try{
            $model=new Article();
            $model->article_title='标题';
            $model->article_intro='简介';
            $model->pub_date=date("Y-m-d H:i:s");
            $model->cate_id=6;
//            $model->setAttributes(array(
//                'article_title' => $_POST['article_title'],
//                'article_intro' => $_POST['article_intro'],
//                'pub_date' => date("Y-m-d H:i:s"),
//                'cate_id' => $_POST['article_cate'],
//            ));
            $model->save();


            //保存失败
//            if(!$model->save()){
//                throw new \Exception('文章保存失败!');
//            }

//            //保存成功
//            $this->id=$model->id;
//
//            //调用事件(文章创建之后)
//            $data=arrar_merge($this->getAttributes(),$model->getAttributes());
//
//            $this->_eventAfterCreate($data);

            //事件提交
            $transaction->commit();

            return true;

        }catch(\Exception $e){
            $transaction->rollBack();
            $this->_lastError=$e->getMessage();
            return false;
        }
    }

}

