<?php
namespace app\assets;

use yii\web\AssetBundle;

class EChartsAsset extends AssetBundle
{
    public $sourcePath = '@app/node_modules/echarts/dist';
    public $js = [
        'echarts.min.js', // 或者如果你想用非压缩版的 'echarts.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];
}
