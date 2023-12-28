<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\PostSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = '数据统计';
$this->params['breadcrumbs'][] = $this->title;
\app\assets\EChartsAsset::register($this);
?>
<div class="charts-index">

<h1><?= Html::encode($this->title) ?></h1>

<div id="main" style="width: 600px; height: 400px;"></div>

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
