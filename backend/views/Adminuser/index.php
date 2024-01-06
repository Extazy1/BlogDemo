<?php

use common\models\Adminuser;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\AdminuserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = '管理员管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增管理员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'nickname',
            //'password',
            'email:email',
            // 'profile:ntext',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',

            ['class' => 'yii\grid\ActionColumn',
            		'template'=>'{view} {update} {resetpwd} {privilege}',
            		'buttons'=>[
            				'resetpwd'=>function($url,$model,$key)
            				{
            					$options=[
            							'title'=>Yii::t('yii','重置密码'),
            							'aria-label'=>Yii::t('yii','重置密码'),
            							'data-pjax'=>'0',
            							];
            					return Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-lock-fill" viewBox="0 0 16 16">
                                <path d="M7 6a1 1 0 0 1 2 0v1H7V6zM6 8.3c0-.042.02-.107.105-.175A.637.637 0 0 1 6.5 8h3a.64.64 0 0 1 .395.125c.085.068.105.133.105.175v2.4c0 .042-.02.107-.105.175A.637.637 0 0 1 9.5 11h-3a.637.637 0 0 1-.395-.125C6.02 10.807 6 10.742 6 10.7V8.3z"/>
                                <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-2 6v1.076c.54.166 1 .597 1 1.224v2.4c0 .816-.781 1.3-1.5 1.3h-3c-.719 0-1.5-.484-1.5-1.3V8.3c0-.627.46-1.058 1-1.224V6a2 2 0 1 1 4 0z"/>
                              </svg>',$url,$options);
            				},
            				
            				'privilege'=>function($url,$model,$key)
            				{
            					$options=[
            							'title'=>Yii::t('yii','权限'),
            							'aria-label'=>Yii::t('yii','权限'),
            							'data-pjax'=>'0',
            					];
            					return Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                              </svg>',$url,$options);
            				},
            				
                    ],
            ],
        ],
    ]); ?>


</div>
