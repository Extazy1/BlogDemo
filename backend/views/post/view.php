<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Post $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '您确定删除这篇文章吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content:ntext',
            'tags:ntext',
            ['label' => '状态',
             'value' => $model->status0->name,            
            ],
            ['label' => '创建时间',
            'value' => date('Y-m-d H:i:s', $model->create_time),            
           ],
           ['label' => '修改时间',
           'value' => date('Y-m-d H:i:s', $model->update_time),            
          ],
            ['label' => '作者',
             'value' => $model->author->nickname,            
            ],
            ['label' => '附件',
            'value' => implode(', ', $model->getAttachmentList()),
            'format' => 'raw',          
           ],
        ],
        'template'=>'<tr><th style="width:120px;">{label}</th><td>{value}</td></tr>',
    	'options'=>['class'=>'table table-striped table-bordered detail-view'],
    ]) ?>

</div>
