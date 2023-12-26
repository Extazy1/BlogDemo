html
<?php

use common\models\Post;
use common\models\Comment;
use frontend\models\DynamicModel;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use frontend\components\TagsCloudWidget;
use frontend\components\RctReplyWidget;
use yii\caching\DbDependency;
use yii\caching\yii\caching;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\PostSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>
<div class="container">

    <div class="row">

        <div class="col-md-9">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= Yii::$app->homeUrl;?>" class="text-decoration-none">首页</a></li>
                    <li class="breadcrumb-item" ><a href="<?= Yii::$app->homeUrl;?>?r=post/index" class="text-decoration-none">文章列表</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $model->title?></li>
                </ol>
            </nav>

            <div class="post">
                <div class="title">
                    <h2><a href="<?= $model->url;?>" class="text-decoration-none"><?= Html::encode($model->title);?></a></h2>
                </div>
                <div class="author d-flex align-items-center">
                    <i class="bi bi-clock-fill me-1" aria-hidden="true"></i>
                    <em><?= date('Y-m-d H:i:s',$model->create_time)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";?></em>

                    <i class="bi bi-person-fill ms-1" aria-hidden="true"></i>
                    <em><?= Html::encode($model->author->nickname);?></em>
                </div>
            </div>

            <div class="content">
                <?php echo $model->content;?>
            </div> 

            <br>
            <div class="nav" >
                <i class="bi bi-tags-fill me-1" aria-hidden="true" ></i>
                <span style="text-decoration: none;"><?= implode(', ',$model->tagLinks);?> </span>
                <br>
                <?= Html::a("评论({$model->commentCount})",[$model->url,'#comments'],['class'=>'text-decoration-none']);?>
                <span class="small">最后修改于<?= date('Y-m-d H:i:s',$model->update_time);?></span>
            </div>

            <div id="comments">
                
                <?php if($added) {?>
                <br>
                <div class="alert alert-warning alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  
                  <h4>谢谢您的回复，我们会尽快审核后发布出来！</h4>
                  
                  <p><?= nl2br($commentModel->content);?></p>
                  	<i class="bi bi-clock" aria-hidden="true"></i><em><?= date('Y-m-d H:i:s',$model->create_time)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";?></em>
                    <i class="bi bi-person-fill" aria-hidden="true"></i><em><?= Html::encode($model->author->nickname);?></em>	  
                </div>			
                <?php }?>

                <?php if($model->commentCount>=1) :?>
                
                <h5><?= $model->commentCount.'条评论';?></h5>
                <?= $this->render('_comment',array(
                        'post'=>$model,
                        'comments'=>$model->activeComments,
                ));?>
                <?php endif;?>
                
                <h5>发表评论</h5>
                <?php 
                $commentModel =new Comment();
                echo $this->render('_guestform',array(
                        'id'=>$model->id,
                        'commentModel'=>$commentModel, 
                ));?>
                
            </div>

        </div>

        <div class="col-md-3">

            <div class="searchbox">
                <ul class="list-group">
                    <li class="list-group-item">
                        查找文章 (<?= Post::find()->count(); ?>)
                    </li>
                    <li class="list-group-item">
                        <form class="d-flex" action="<?= Yii::$app->urlManager->createUrl(['post/index']); ?>" method="get">
                            <input type="text" class="form-control me-2" name="PostSearch[title]" placeholder="按标题">
                            <button type="submit" class="btn btn-outline-secondary">搜索</button>
                        </form>
                    </li>
                </ul>
            </div>

            <div class="tagcloudbox">
                <ul class="list-group">
                    <li class="list-group-item">
                        <i class="bi bi-tags-fill"></i> 标签云
                    </li>
                    <li class="list-group-item">
                        <?php ?>
                        <?= TagsCloudWidget::widget(['tags' => $tags]); ?>
                    </li>
                </ul>
            </div>

            <div class="commentbox">
                <ul class="list-group">
                    <li class="list-group-item">
                        <i class="bi bi-chat-left-text-fill"></i> 最新回复
                    </li>
                    <li class="list-group-item">
                        <?= RctReplyWidget::widget(['recentComments' => $recentComments]) ?>
                    </li>
                </ul>
            </div>

        </div>

    </div>

</div>
