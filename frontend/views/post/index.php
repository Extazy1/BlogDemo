<?php

use common\models\Post;
use yii\helpers\Html;
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

$this->title = '文章列表';
?>
<div class="container">

<div class="row">

	<div class="col-md-9">

		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= Yii::$app->homeUrl;?>" class="text-decoration-none">首页</a></li>
				<li class="breadcrumb-item active" aria-current="page">文章列表</li>
			</ol>
		</nav>

		<?= ListView::widget([
			'id' => 'postList',
			'dataProvider' => $dataProvider,
			'itemView' => '_listitem', //子视图，显示一篇文章的标题等内容。
			'layout' => '{items} <nav aria-label="Page navigation">{pager}</nav>',
			'pager' => [
				'maxButtonCount' => 10,
				'linkContainerOptions' => ['class' => 'page-item'], // Bootstrap 5 分页项容器类
				'linkOptions' => ['class' => 'page-link'], // Bootstrap 5 分页链接类
				'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link', 'aria-disabled' => 'true'], // Bootstrap 5 禁用分页项
				'nextPageLabel' => Yii::t('app', '下一页'),
				'prevPageLabel' => Yii::t('app', '上一页'),
				'nextPageCssClass' => 'page-item', // Bootstrap 5 下一页项类
				'prevPageCssClass' => 'page-item', // Bootstrap 5 上一页项类
				'disableCurrentPageButton' => true, // 根据需要禁用当前页按钮
			],
		]) ?>


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
