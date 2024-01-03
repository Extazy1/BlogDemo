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
AppAsset::register($this);
\app\assets\EChartsAsset::register($this);
?>

<div class="container-fluid">
    <div class="row">
        <!-- 侧边栏 -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <h1 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>BlogDemo</span>
                </h1>
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
                <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
            </div>
            
            <!-- 欢迎信息 -->
            <div class="mb-4">
                <h1><?= "你好," . "管理员！" ?></h1>
            </div>
            
            <!-- 销售图表 -->
            <div class="card mb-4">
                <div class="card-header">
                    销售图表
                </div>
                <div class="card-body">
                    <!-- 插入图表 -->
                </div>
            </div>
            
            <!-- 订单和销售数据卡片 -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">订单</h5>
                            <p class="card-text">310</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">销售</h5>
                            <p class="card-text">¥3,759.00</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 渠道分析 -->
            <div class="card mb-4">
                <div class="card-header">
                    渠道分析
                </div>
                <div class="card-body">
                    <!-- 插入饼图 -->
                </div>
            </div>
            
            <!-- 最近评论 -->
            <div class="card mb-4">
                <div class="card-header">
                    最近评论
                </div>
                <div class="card-body">
                    <!-- 插入评论列表 -->
                </div>
            </div>
        </main>
    </div>
</div>




<?php
// 在这里注册你的 ECharts JavaScript 代码
$script = <<< JS

// 基于准备好的DOM，初始化echarts实例
var myChart = echarts.init(document.getElementById('main'));

// 指定图表的配置项和数据
var option = {
title: {
    text: 'ECharts 入门示例'
},
tooltip: {},
legend: {
    data:['销量']
},
xAxis: {
    data: ["衬衫","群众","雪纺衫","裤子","高跟鞋","袜子"]
},
yAxis: {},
series: [{
    name: '销量',
    type: 'line',
    data: [5, 20, 36, 10, 10, 20]
}]
};

// 使用刚指定的配置项和数据显示图表。
myChart.setOption(option);

JS;

// 将上述脚本注册到视图中
$this->registerJs($script, \yii\web\View::POS_READY);
?>
