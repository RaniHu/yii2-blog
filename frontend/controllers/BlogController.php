<?php

namespace frontend\controllers;

use frontend\models\Article;
use frontend\models\ArticleTag;
use frontend\models\Cate;
use frontend\models\SearchArticle;
use frontend\models\Tag;
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


    /**
     * 首页
     */
    public function actionIndex()

    {
        $searchText=Yii::$app->request->get('searchText');                         //搜索
        $query = Article::find();
        $cateQuery = Cate::find()->all();
        $tagQuery = Tag::find()->all();
        $articleSearchLists = Article::find()->with('cates')->andFilterWhere(['like', 'article_title', $searchText])->orderBy(['pub_date' => SORT_DESC])->asArray()->all();

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
        $cateQuery = Cate::find()->all();
        $tagQuery = Tag::find()->all();

        //当前文章所属分类
        $curArticleCate = cate::findOne($articleQuery['cate_id']);

        //当前文章的所有标签
        $curArticleTags = $articleQuery->tags;

//        $curArticleTags = ArticleTag::find()->with('tagsName')->where(['article_id'=>$articleId])->asArray()->all();
//        foreach ($curArticleTags as $curArticleTag){
//            $curTags =$curArticleTag['tagsName'][0];
//            array_push($curTagsArr,$curTags);
//        }

        return $this->render('detail', [
            'curArticle' => $articleQuery,
            'cates' => $cateQuery,
            'tags' => $tagQuery,
            'curCate' => $curArticleCate,
            'curTag' => $curArticleTags
        ]);
    }

    //文章分类页
    public function actionCate()
    {
        $cateId = Yii::$app->request->get('id');
        $cateQuery = Cate::find()->all();
        $tagQuery = Tag::find()->all();

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

    //文章标签页
    public function actionTag()
    {
        $tagId = Yii::$app->request->get('id');

        $curTagName = tag::findOne(['id' => $tagId]);
        $curTagArticles = ArticleTag::find()->with('tagArticle', 'tagsName')->where(['tag_id' => $tagId])->all();
        $allTagArticles = ArticleTag::find()->with('tagArticle', 'tagsName')->orderBy('id')->all();

        print_r(Tag::findOne($tagId)->getTagArticles()->orderBy(['id' => SORT_DESC]));
//        //当前标签对应的文章
//        $curTagArticles = Tag::find()->with('tagArticles')->where(['id'=>$tagId])->all();
//
//        //所有标签对应的文章
//        $allTagArticles=Tag::find()->with('tagArticles')->all();

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
        return $this->render('view');
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public $enableCsrfValidation = false;
     
    public function actionCreate()
    {
        $model = new Article;
        $articleTagModel = new ArticleTag;
        $cateQuery = Cate::find()->all();
        $tagQuery = Tag::find()->all();
        $post = Yii::$app->request->post();


        //获取用户输入的数据,验证并保存
//        if ($model->load($post)&& $articleTagModel->load($post)&& Model::validateMultiple([$model,$articleTagModel])) {
        if ($model->load($post) && $model->validate()) {

            Article::create();


//            $model->save(false);
//            $articleTagModel->article_id=$model->id;
//            $articleTagModel->save(false);
//            echo $model->attributes['id'];
//            $model->setAttributes(array(
//                'article_title' => $_POST['article_title'],
//                'article_intro' => $_POST['article_intro'],
//                'pub_date' => date("Y-m-d H:i:s"),
//                'cate_id' => $_POST['article_cate'],
//            ));
//            $model->save();
//            foreach ($_POST['article_tag'] as $tags) {
//                $articleTagModel->setAttributes(array(
//                    'article_id' => $model->id,
//                    'tag_id' => $tags,
//                ));
//                $articleTagModel->save();
//            }


//            $model->link('tags',Tag::find()->where(['article_id'=>$model->id]));


        } else {
            return $this->render('create', [
                'model' => $model,
                'cates' => $cateQuery,
                'tags' => $tagQuery,
            ]);
        }
    }

    /**
     * 保存文章标签
     */
    public function saveTags($id, $tag)
    {
        if ($tag) {
            foreach ($tag as $key => $value) {
                $ArticleTag = new ArticleTag();
                $ArticleTag->tag_id = $value;
                $ArticleTag->article_id = $id;
                $ArticleTag->insert();
            }
        }

        return true;
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
