<?php

use common\models\Comment;
use common\models\Commentstatus;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\CommentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            //'id',
        	[
        	'attribute'=>'id',
        	'contentOptions'=>['width'=>'30px'],
        	],
            //'content:ntext',
            [
            'attribute'=>'content',
            'value'=>'beginning',
    		],
        	//'userid',
        	[
        	'attribute'=>'user.username',
        	'label'=>'作者',
        	'value'=>'user.username',	
        	],
            //'status',
            [
            'attribute'=>'status',
            'value'=>'status0.name',
            'filter'=>Commentstatus::find()
            		  ->select(['name','id'])
            		  ->orderBy('position')
            		  ->indexBy('id')
            		  ->column(),
            'contentOptions'=>
            		function($model)
            		{
            			return ($model->status==1)?['class'=>'bg-danger']:[];
            		}
            ],
           // 'create_time:datetime',
           [
           		'attribute'=>'create_time',
           		'format'=>['date','php:m-d H:i'],
            ],
            
            // 'email:email',
            // 'url:url',
            // 'post_id',
            'post.title',

            [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{view} {update} {delete} {approve}',
            //bootstrap4图标
            'buttons'=>
            	[
            	'approve'=>function($url,$model,$key)
            			{
            				$options=[
            					'title'=>Yii::t('yii', '审核'),
            					'aria-label'=>Yii::t('yii','审核'),
            					'data-confirm'=>Yii::t('yii','你确定通过这条评论吗？'),
            					'data-method'=>'post',
            					'data-pjax'=>'0',
            						];
            				return Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                          </svg>',$url,$options);
            				
            			},
            	],	
            		

            		
            ],
        ],
    ]); ?>


</div>
