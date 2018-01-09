<?php

namespace frontend\controllers;

use frontend\models\Article;
use frontend\models\ArticleTag;
use frontend\models\Cate;
use frontend\models\Comment;
use frontend\models\SearchArticle;
use frontend\models\Tag;
use frontend\models\Theme;
use Yii;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * BlogController implements the CRUD actions for Article model.
 */
class BlogController extends Controller
{


    public $_lastError = "";



    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * 首页
     */

    public $enableCsrfValidation = false;
     
    public function actionIndex()

    {
        $searchText=Yii::$app->request->get('searchText');                         //搜索
        $query = Article::find();
        $cateQuery = Cate::find()->all();
        $tagQuery = Tag::find()->all();
        $curTheme=Theme::findOne(1);
        Yii::$app->view->params['theme']=$curTheme;        
        $articleSearchLists = Article::find()->with('cates','author')->andFilterWhere(['like', 'article_title', $searchText])->orderBy(['pub_date' => SORT_DESC])->asArray()->all();

        $pagination = new Pagination([                                                    //分页器
            'defaultPageSize' => 3,
            'totalCount' => $query->count(),
        ]);
        $articles = $query->orderBy('id')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();



        return $this->render('home', [
            'cates' => $cateQuery,
            'tags' => $tagQuery,
            'articles' => $articles,
            'articleList' => $articleSearchLists,
            'pagination' => $pagination
        ]);
    }


    /**
     *  主题操作
     */
    public function actionTheme()
    {

        /*判断是否为ajax请求*/
        if (Yii::$app->request->isAjax) {
            $model = Theme::findOne(1);
            $get = Yii::$app->request->get();
            $themeName = $get['theme'];

            //保存主题值
            if ($themeName) {
                $model->theme_name = $themeName;
                $model->save();
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            //返回值给前端
            if($model->save()){
                return [
                    "themeName" => $themeName,
                    "code" => 100,
                ];
            }else{
                return [
                    "error" => '主题更新失败',
                    "code" => 500,
                ];
            }
        }
    }

    /**
     * 文章详情页
     */
    public function actionDetail()
    {
        $articleId = Yii::$app->request->get('id');                             //当前文章id
        $articleQuery = Article::findOne(['id' => $articleId]);                   //当前文章数据
        $cateQuery = Cate::find()->all();
        $tagQuery = Tag::find()->all();

        //当前文章下的评论
        $commentModel=new Comment();
        $articleComments=$commentModel->getAllComments($articleId);
        $commentNum=$commentModel->getCommentsNum($articleId);


        //当前的主题
        $curTheme=Theme::findOne(1);
        Yii::$app->view->params['theme']=$curTheme;

        //当前文章信息与所属分类
        $curArticle = Article::find(['id' => $articleId])->with('cates','author')->asArray()->all();

        //当前文章的所有标签
        $curArticleTags = $articleQuery->tags;


        return $this->render('detail', [
            'curArticle' => $articleQuery,
            'cates' => $cateQuery,
            'tags' => $tagQuery,
            'curTag' => $curArticleTags,
            'articleComments' => $articleComments,
            'commentCount'=>$commentNum
        ]);
    }

    /**
     * 文章分类页
     */
    public function actionCate()
    {
        $cateId = Yii::$app->request->get('id');
        $cateQuery = Cate::find()->all();
        $tagQuery = Tag::find()->all();
        $curTheme=Theme::findOne(1);
        Yii::$app->view->params['theme'] = $curTheme;


        if($cateId){
//            $cateArticles=Cate::findOne(['id' => $cateId])->cateArticles;
            $cateArticles = Cate::find()->with('cateArticles')->where(['id' => $cateId])->all();

        }else{
            $cateArticles = Cate::find()->with('cateArticles')->all();
        }

        return $this->render('cate', [
            'cates' => $cateQuery,
            'tags' => $tagQuery,
            'cateArticles'=>$cateArticles
        ]);
    }

    /**
     * 文章标签页
     */
    public function actionTag()
    {
        $tagId = Yii::$app->request->get('id');
        $curTheme=Theme::findOne(1);
        Yii::$app->view->params['theme']=$curTheme;       

        $curTagName = tag::findOne(['id' => $tagId]);
        $curTagArticles = ArticleTag::find()->with('tagArticle', 'tagsName')->where(['tag_id' => $tagId])->all();
        $allTagArticles = ArticleTag::find()->with('tagArticle', 'tagsName')->orderBy('id')->all();


        $res=array();
        //判断是否存在标签id
        if($tagId){
            $curTagArticles=$curTagArticles;
        }else{
            $curTagArticles=$allTagArticles;
        }
        $cateQuery = cate::find()->all();
        $tagQuery = tag::find()->all();

        foreach ($curTagArticles as $key=>$curTagArticle){
            $res[$curTagArticle['tag_id']][]=$curTagArticle;
        }



        return $this->render('tag', [
            'cates' => $cateQuery,
            'tags' => $tagQuery,
            'curTag'=>$curTagName['tag'],
            'curTagArticle'=>$res
        ]);
    }


    /**
     *  评论操作
     */
    public function actionComment()
    {

        /*判断是否为ajax请求*/
        if (Yii::$app->request->isAjax) {
            $model = new Comment;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            //插入评论数据
            if($model->createComment()){
                return [
                    "code" =>200,
                ];
            }else{
                return [
                    "error" => $model->errors,
                    "code" => 500,
                ];
            }

        }
    }



    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionSearch()
    {
        $searchModel = new SearchArticle();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $curTheme=Theme::findOne(1);
        Yii::$app->view->params['theme']=$curTheme;       
        return $this->render('view');
    }


    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     
    public function actionCreate()
    {
        $model = new Article;
        $cateQuery = Cate::find()->all();
        $tagQuery = Tag::find()->all();
        $curTheme=Theme::findOne(1);
        Yii::$app->view->params['theme']=$curTheme;
        $post = Yii::$app->request->post();


        //获取用户输入的数据,验证并保存
        if ($model->load($post)&& isset($_POST['article_tag'])) {

            if (!$model->create()) {
                echo '文章表保存失败!';
            } else {
                return $this->redirect('view');
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'cates' => $cateQuery,
                'tags' => $tagQuery,
            ]);
        }
    }


    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $cateQuery = Cate::find()->all();
        $tagQuery = Tag::find()->all();
         $curTheme=Theme::findOne(1);
        Yii::$app->view->params['theme']=$curTheme;   

        if ($model->load(Yii::$app->request->post()) && isset($_POST['article_tag'])) {
            if(!$model->updateArticle($id))
            {
                echo '文章表修改失败!';
            }else
            {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('_form', [
                'model' => $model,
                'cates' => $cateQuery,
                'tags' => $tagQuery,
            ]);
        }
    }


    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //删除文章表中内容
        $this->findModel($id)->delete();

        //删除关联表
        $articleTagModel = new ArticleTag;
        $articleTagModel::deleteAll(['article_id' => $id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
