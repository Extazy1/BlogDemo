<?php
use yii\helpers\Html;
use yii\bootstrap5\BootstrapAsset;

BootstrapAsset::register($this);
?>

<div class="container mt-3">
    <div class="post">
        <div class="title">
            <h2><a href="<?= $model->url;?>"><?= Html::encode($model->title);?></a></h2>
        </div>
        
        <div class="author">
            <span class="text-muted"><i class="bi bi-clock"></i> <?= date('Y-m-d H:i:s',$model->create_time); ?></span>
            <span class="text-muted"><i class="bi bi-person-fill"></i> <?= Html::encode($model->author->nickname); ?></span>
        </div>
        
        <div class="content mt-3">
            <?= $model->beginning;?>
        </div>
        
		<div class="nav mt-3">
    	<i class="bi bi-tags-fill"></i>
   		 <span><?= implode(', ', $model->tagLinks); ?></span>
		</div>

    	<div class="mt-2">
        <?= Html::a("评论 ({$model->commentCount})", $model->url.'#comments'); ?> | 最后修改于 <?= date('Y-m-d H:i:s', $model->update_time); ?>
    	</div>


    </div>
</div>
