<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use backend\assets\AppAsset;

/** @var yii\web\View $this */
/** @var common\models\PostSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

//$this->title = '数据统计';
//$this->title = $model->name;
//$this->params['breadcrumbs'][] = $this->title;
//$session = Yii::$app->session;
//$username = $session->get('username');
$this->title = '仪表盘';
//$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
\app\assets\EChartsAsset::register($this);
$this->registerCssFile("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css");
$this->registerCssFile("https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css");
$this->registerJsFile("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js");
// 将数据传递给 JavaScript
$this->registerJs(
    "var chartConfig = {$chartConfig};",
    \yii\web\View::POS_HEAD
);
?>

<div class="container-fluid">
    <div class="row">
        <!-- 侧边栏 -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <h1 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span style="font-size : 1.5ex;">仪表盘</span>                </h1>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">
                            <i class="bi bi-house-door-fill"></i>
                            首页
                        </a>
                    </li>
                    <!-- 其他侧边栏项目 -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                        <i class="bi bi-file-earmark-text"></i>
                        文章统计
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-folder"></i>
                            分类统计
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-tags"></i>
                            标签统计
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-chat-left-text"></i>
                            评论统计
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-people"></i>
                            用户统计
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-gear"></i>
                            设置
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- 主内容区 -->
        <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
            <!-- 搜索栏 -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <input class="form-control form-control-dark w-100" type="text" placeholder="搜索" aria-label="Search">
            </div>
            
            <!-- 欢迎信息 -->
            <div class="mb-4">
                <h1><?= "你好," . "管理员！" ?></h1>
            </div>
            
            <!-- 数据总览图 -->
            <div class="card mb-4">
                <div class="card-header">
                    数据总览
                </div>
                <div class="card-body">
                    <!-- 插入图表 -->
                    <div id="main" style="width: 1000px; height: 400px;"></div>
                </div>
            </div>
            
            <!-- 数据总览卡片 -->
            <div class="row g-3">
                <div class="col-lg-3 mb-4">
                    <div class="card h-100 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="small">文章数</div>
                                <div class="text-lg fw-bold">215</div>
                            </div>
                            <i class="bi bi-journal-text fs-1 text-primary"></i>
                        </div>
                        <div class="mt-3">
                            <div class="small">  <span class="stats-increase"><i class="bi bi-arrow-up"></i> 30%</span> 自上周</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-4">
                    <div class="card h-100 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="small">阅读量</div>
                                <div class="text-lg fw-bold">1,400</div>
                            </div>
                            <i class="bi bi-eye fs-1 text-success"></i>
                        </div>
                        <div class="mt-3">
                            <div class="small">  <span class="stats-increase"><i class="bi bi-arrow-up"></i> 23%</span> 自上周</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-4">
                    <div class="card h-100 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="small">评论数</div>
                                <div class="text-lg fw-bold">1,056</div>
                            </div>
                            <i class="bi bi-chat-left-text fs-1 text-info"></i>
                        </div>
                        <div class="mt-3">
                            <div class="small">  <span class="stats-decrease"><i class="bi bi-arrow-down"></i> 10%</span> 自上周</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-4">
                    <div class="card h-100 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="small">搜索量</div>
                                <div class="text-lg fw-bold">355</div>
                            </div>
                            <i class="bi bi-search fs-1 text-warning"></i>
                        </div>
                        <div class="mt-3">
                            <div class="small">  <span class="stats-increase"><i class="bi bi-arrow-up"></i> 15%</span> 自上周</div>
                        </div>
                    </div>
                </div>
            </div>

           
        <!-- 分类饼图 -->
        <div class="card mb-4">
            <div class="card-header" style="display: flex; justify-content: center; align-items: center;">
                分类详情
            </div>
            <div class="card-body" style="display: flex; justify-content: center; align-items: center;">
                <div id="pie-chart" style="width: 600px; height: 400px; margin: auto;"></div>
            </div>
        </div>

        <!-- 相册图 -->
        <div class="card mb-4">
            <div class="card-header" style="display: flex; justify-content: center; align-items: center;">
                相册图
            </div>
            <div class="card-body" style="display: flex; justify-content: center; align-items: center;">
                <div id="carousel-chart" style="width: 600px; height: 400px; margin: auto;"></div>
            </div>
        </div>

        </main>
    </div>
</div>




<?php
// 注册 JavaScript 代码
$js = <<<JS
var myChart = echarts.init(document.getElementById('main'));
myChart.setOption(chartConfig.areaChartOptions);

var pieChart = echarts.init(document.getElementById('pie-chart'));
pieChart.setOption(chartConfig.pieChartOptions);

var carouselChart = echarts.init(document.getElementById('carousel-chart'));
carouselChart.setOption(chartConfig.carouselOptions);
JS;

$this->registerJs($js, \yii\web\View::POS_READY);
?>