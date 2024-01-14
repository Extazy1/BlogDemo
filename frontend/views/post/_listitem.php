<?php
use yii\helpers\Html;
use yii\bootstrap5\BootstrapAsset;

BootstrapAsset::register($this);
?>

<div class="container mt-3">
    <div class="card post">
        <!-- 标题区域，使用了 Bootstrap 的 text-decoration-none 类来移除下划线 -->
        <div class="card-header title">
            <h2><a href="<?= $model->url;?>" class="text-decoration-none" ><?= Html::encode($model->title);?></a></h2>
        </div>
        
        <!-- 作者信息区域，使用了 text-muted 类来变灰文字 -->
        <div class="card-body author">
            <span class="text-muted">
                <i class="bi bi-clock"></i> <?= date('Y-m-d H:i:s', $model->create_time); ?>
            </span>
            <span class="text-muted">
                <i class="bi bi-person-fill"></i> <?= Html::encode($model->author->nickname); ?>
            </span>
        </div>
        
        <!-- 内容区域 -->
        <div class="card-text content mt-3">
            <?= $model->beginning;?>
        </div>
        
        <!-- 标签区域 -->
        <div class="card-footer nav mt-3">
            <i class="bi bi-tags-fill"></i>
            <span><?= implode(', ', $model->tagLinks); ?></span>
        </div>

        <!-- 评论和修改信息区域 -->
        <div class="card-footer mt-2 text-end">
            <?= Html::a("评论 ({$model->commentCount})", $model->url.'#comments', ['class' => 'text-decoration-none']); ?> 
            | 最后修改于 <?= date('Y-m-d H:i:s', $model->update_time); ?>
        </div>
    </div>
</div>
