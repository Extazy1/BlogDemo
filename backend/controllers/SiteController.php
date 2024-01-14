<?php

namespace backend\controllers;

use common\models\AdminLoginForm;
use Yii;
use Parsedown;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use Zend\Feed\Writer\Feed;
use common\models\Post; 

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'rss'], // 添加 'rss' 到此数组
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new AdminLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    private function generateSummary($content)
    {
        // 例如，简单地截取前200个字符作为摘要
        return mb_substr(strip_tags($content), 0, 200) . '...';
    }

    /**
     * Displays RSS Feed.
     *
     * @return string
     */
    public function actionRss()
    {
        try {
            $feed = new Feed();
            $feed->setTitle('BlogDemo RSS Feed');
            $feed->setLink(Yii::$app->request->getHostInfo());
            $feed->setFeedLink(Yii::$app->request->getHostInfo() . '/rss.html', 'rss');
            $feed->setDescription('最新文章');
            $feed->setDateModified(time());
    
            $posts = Post::find()->orderBy('create_time DESC')->all();
            Yii::info("Found " . count($posts) . " posts"); // 调试信息
            foreach ($posts as $post) {
                $entry = $feed->createEntry();
                $entry->setTitle($post->title);
                $entry->setLink(Yii::$app->request->getHostInfo() . '/post/view?id=' . $post->id);
                $entry->setDateModified($post->update_time);
                $entry->setDateCreated($post->create_time);

                // 使用 Markdown 解析器将 Markdown 转换为 HTML
                $parsedown = new Parsedown();
                $htmlContent = $parsedown->text($post->content);
                // 生成内容摘要
                //$summary = $this->generateSummary($htmlContent);

                // 设置内容为摘要和链接
                //$htmlContent = $summary;
                $entry->setContent($htmlContent);
                $feed->addEntry($entry);
            }
    
            Yii::$app->response->format = Response::FORMAT_RAW;     //以原始格式显示
            Yii::$app->response->headers->add('Content-Type', 'text/xml');
            return $feed->export('rss');
        } catch (\Exception $e) {
            Yii::error("RSS feed generation error: " . $e->getMessage());
            throw $e; // 或者返回一个错误消息
        }
    }
}
