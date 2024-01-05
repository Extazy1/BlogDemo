<?php

use common\models\Post;
use common\models\Poststatus;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\PostSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('创建文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            //'id',
            ['attribute'=>'id',
            'contentOptions'=>['width'=>'30px'],
            ],
            'title',
        	//'author_id',
        	['attribute'=>'authorName',
        	'label'=>'作者',
        	'value'=>'author.nickname',
    		],
           // 'content:ntext',
            'tags:ntext',
            //'status',
            ['attribute'=>'status',
            'value'=>'status0.name',
            'filter'=>Poststatus::find()
            		->select(['name','id'])
            		->orderBy('position')
            		->indexBy('id')
            		->column(),
   			 ],
            // 'create_time:datetime',
             //'update_time:datetime',
             ['attribute'=>'update_time',
             'format'=>['date','php:Y-m-d H:i:s'],
        	],
             

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'pager' => [
            'maxButtonCount' => 10,
            'linkContainerOptions' => ['class' => 'page-item'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link', 'aria-disabled' => 'true'],
            'nextPageLabel' => Yii::t('app', '下一页'),
            'prevPageLabel' => Yii::t('app', '上一页'),
            'nextPageCssClass' => 'page-item',
            'prevPageCssClass' => 'page-item',
            'disableCurrentPageButton' => true,
        ],
    ]); ?>


</div>
