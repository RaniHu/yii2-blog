<?php

namespace frontend\controllers;

use frontend\models\Article;
use frontend\models\ArticleCate;
use frontend\models\ArticleTag;
use frontend\models\ArticleTagView;
use frontend\models\SearchArticle;
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

    
    public function actionIndex()

    {
        $searchText=Yii::$app->request->get('searchText');                         //搜索
        $query = Article::find();
        $cateQuery = ArticleCate::find()->all();
        $tagQuery = ArticleTag::find()->all();
        $articleSearchLists=Article::find()->with('cates')->andFilterWhere(['like','article_title',$searchText])->asArray()->all();


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

    //文章详情页
    public function actionDetail()
    {
        $articleId = Yii::$app->request->get('id');                             //当前文章id
        $articleQuery = Article::findOne(['id' => $articleId]);                   //当前文章数据
        $cateQuery = ArticleCate::find()->all();
        $tagQuery = ArticleTag::find()->all();
        $curArticleCate = ArticleCate::findOne($articleQuery['cate_id']);         //当前文章分类

        //获取当前文章的所有标签
        $curTagsArr=array();
        $curArticleTags = ArticleTagView::find()->with('tagsName')->where(['article_id'=>$articleId])->asArray()->all();

        foreach ($curArticleTags as $curArticleTag){
            $curTags =$curArticleTag['tagsName'][0];
            array_push($curTagsArr,$curTags);
        }


        return $this->render('detail', [
            'curArticle' => $articleQuery,
            'cates' => $cateQuery,
            'tags' => $tagQuery,
            'curCate' => $curArticleCate,
            'curTag' => $curTagsArr
        ]);
    }

    //文章分类页
    public function actionCate()
    {
        $cateId = Yii::$app->request->get('id');
        $cateQuery = ArticleCate::find()->all();
        $tagQuery = ArticleTag::find()->all();
        $curCateArticle= ArticleCate::find()->with('cates')->where(['id'=>$cateId])->asArray()->all();
        $articleAndCate = ArticleCate::find()->with('cates')->asArray()->all();               //文章和分类数据
        if($cateId){
            $cateArticles=$curCateArticle;
        }else{
            $cateArticles=$articleAndCate;

        }

        return $this->render('cate', [
            'cates' => $cateQuery,
            'tags' => $tagQuery,
            'cateArticles'=>$cateArticles
        ]);
    }

    //文章标签页
    public function actionTag()
    {
        $tagId = Yii::$app->request->get('id');
        $curTagName=ArticleTag::findOne(['id'=>$tagId]);
        $curTagArticles = ArticleTagView::find()->with('tagArticle','tagsName')->where(['tag_id'=>$tagId])->asArray()->all();
        $allTagArticles=ArticleTagView::find()->with('tagArticle','tagsName')->orderBy('id')->asArray()->all();

        //判断是否存在标签id
        $res=array();
        if($tagId){
            $curTagArticles=$curTagArticles;
        }else{
            $curTagArticles=$allTagArticles;
        }
        $cateQuery = ArticleCate::find()->all();
        $tagQuery = ArticleTag::find()->all();

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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        $cateQuery = ArticleCate::find()->all();
        $tagQuery = ArticleTag::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
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
        $this->findModel($id)->delete();

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
