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
$this->title = '文章管理';
//$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
\app\assets\EChartsAsset::register($this);
?>

<div class="container-fluid">
    <div class="row">
        <!-- 侧边栏 -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <h1 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span style="font-size : 1.5ex;">Dashboard</span>                </h1>
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
            <div class="row">
                <div class="col-lg-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">用户数</h5>
                            <p class="card-text">310</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">文章数</h5>
                            <p class="card-text">111</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">评论数</h5>
                            <p class="card-text">10056</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">分类详情</h5>
                            <p class="card-text">355</p>
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
// 在这里注册ECharts JavaScript 代码
$script = <<< JS

// 基于准备好的DOM，初始化echarts实例
var myChart = echarts.init(document.getElementById('main'));

// 指定图表的配置项和数据
var option = {
  title: {
    text: 'Stacked Area Chart'
  },
  tooltip: {
    trigger: 'axis',
    axisPointer: {
      type: 'cross',
      label: {
        backgroundColor: '#6a7985'
      }
    }
  },
  legend: {
    data: ['Email', 'Union Ads', 'Video Ads', 'Direct', 'Search Engine']
  },
  toolbox: {
    feature: {
      saveAsImage: {}
    }
  },
  grid: {
    left: '3%',
    right: '4%',
    bottom: '3%',
    containLabel: true
  },
  xAxis: [
    {
      type: 'category',
      boundaryGap: false,
      data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
    }
  ],
  yAxis: [
    {
      type: 'value'
    }
  ],
  series: [
    {
      name: 'Email',
      type: 'line',
      stack: 'Total',
      areaStyle: {},
      emphasis: {
        focus: 'series'
      },
      data: [120, 132, 101, 134, 90, 230, 210]
    },
    {
      name: 'Union Ads',
      type: 'line',
      stack: 'Total',
      areaStyle: {},
      emphasis: {
        focus: 'series'
      },
      data: [220, 182, 191, 234, 290, 330, 310]
    },
    {
      name: 'Video Ads',
      type: 'line',
      stack: 'Total',
      areaStyle: {},
      emphasis: {
        focus: 'series'
      },
      data: [150, 232, 201, 154, 190, 330, 410]
    },
    {
      name: 'Direct',
      type: 'line',
      stack: 'Total',
      areaStyle: {},
      emphasis: {
        focus: 'series'
      },
      data: [320, 332, 301, 334, 390, 330, 320]
    },
    {
      name: 'Search Engine',
      type: 'line',
      stack: 'Total',
      label: {
        show: true,
        position: 'top'
      },
      areaStyle: {},
      emphasis: {
        focus: 'series'
      },
      data: [820, 932, 901, 934, 1290, 1330, 1320]
    }
  ]
};

// 使用刚指定的配置项和数据显示图表。
myChart.setOption(option);

JS;

// 将上述脚本注册到视图中
$this->registerJs($script, \yii\web\View::POS_READY);

$pieChartScript = <<< JS

// 初始化饼图实例
var pieChart = echarts.init(document.getElementById('pie-chart'));

// 指定饼图的配置项和数据
var pieOption = {
    title : {
        text: '文章分类',
        subtext: '示例',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        left: 'left',
        data: ['分类1','分类2','分类3','分类4','分类5']
    },
    series : [
        {
            name: '文章分类',
            type: 'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data:[
                {value:335, name:'分类1'},
                {value:310, name:'分类2'},
                {value:234, name:'分类3'},
                {value:135, name:'分类4'},
                {value:1548, name:'分类5'}
            ],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};

pieChart.setOption(pieOption);

JS;

$this->registerJs($pieChartScript, \yii\web\View::POS_READY);

$carouselScript = <<< JS

// 初始化 ECharts 实例
var carouselChart = echarts.init(document.getElementById('carousel-chart'));

// 图片数组
var images = [
    'https://www.arkui.club/assets/img/2_2_2_1.ac7a0ef6.jpg', // 替换为实际的图片 URL
    'https://www.arkui.club/assets/img/2_2_3_2.5c382962.jpg',
    'https://www.arkui.club/assets/img/2_5_1.623d721a.png',
    'https://www.arkui.club/assets/img/2_9_1_1.75fb2f33.png',
    'https://www.arkui.club/assets/img/2_1_4.806413c6.png',
];

// 当前显示的图片索引
var currentIndex = 0;

// 设置 ECharts 选项
carouselChart.setOption({
    graphic: {
        elements: [{
            type: 'image',
            style: {
                image: images[currentIndex],
                width: 600,
                height: 400
            },
            left: 'center',
            top: 'middle'
        }]
    }
});

// 定时更换图片
setInterval(function () {
    currentIndex = (currentIndex + 1) % images.length;
    carouselChart.setOption({
        graphic: {
            elements: [{
                style: {
                    image: images[currentIndex]
                }
            }]
        }
    });
}, 3000); // 每3秒更换一次图片

JS;

$this->registerJs($carouselScript, \yii\web\View::POS_READY);
?>