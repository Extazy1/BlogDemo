<?php

use common\models\Post;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use frontend\components\CategoryWidget;
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
	<!-- 左侧侧边栏 -->
	<div class="col-md-1" id="category-sidebar">
    	<button id="toggle-category" class="btn btn-primary mb-2">文章分类</button>
    	<div id="category-box">
        	<ul class="list-group">
				<!-- 循环输出分类列表 -->
				<li class="list-group-item">
					<?= CategoryWidget::widget(['categories' => $categories]) ?>
				</li>
			</ul>
		</div>
		<div id="rss">
			<!-- RSS 订阅图标链接 -->
			<a href="http://backend.test/rss.html" target="_blank" title="订阅 RSS">
				<img src="https://ts1.cn.mm.bing.net/th/id/R-C.836829e6642b0f4920dc56143112fe03?rik=erdNdDZgJEe84Q&riu=http%3a%2f%2fwww.ranklogos.com%2fwp-content%2fuploads%2f2012%2f04%2fRSS-logo.png&ehk=bH7ZQE7aEOGgCH28o3U5jkJj5Uz9jGl08sWFGKj%2fK3U%3d&risl=&pid=ImgRaw&r=0" \
				alt="RSS" class="rss-icon" style="width:64px; height:64px; margin-top: 10px;">
			</a>
		</div>
	</div>

	<div class="col-md-8" id="main-content">

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

	<div class="col-md-3" id="right-sidebar">

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    var toggleButton = document.getElementById('toggle-category');
    var categorySidebar = document.getElementById('category-sidebar');
    var mainContent = document.getElementById('main-content');
    var rightSidebar = document.getElementById('right-sidebar');

    toggleButton.addEventListener('click', function() {
        var isCategoryBoxVisible = categorySidebar.style.display !== 'none';
        
        if (isCategoryBoxVisible) {
            // 隐藏分类列表
            categorySidebar.style.display = 'none';
            // 调整主内容区域的宽度
            mainContent.className = 'col-md-9';
            // 调整右侧边栏的宽度
            rightSidebar.className = 'col-md-3';
        } else {
            // 显示分类列表
            categorySidebar.style.display = 'block';
			categorySidebar.className = 'col-md-1';
            // 还原主内容区域的宽度
            mainContent.className = 'col-md-8';
            // 还原右侧边栏的宽度
            rightSidebar.className = 'col-md-3';
        }
    });
});
</script>

