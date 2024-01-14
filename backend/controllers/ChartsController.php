<?php

namespace backend\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ChartsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    // 准备图表所需的数据
    private function getChartConfig()
    {
        return [
            'areaChartOptions' => [
                //'title' => ['text' => 'Stacked Area Chart'],
                'tooltip' => [
                    'trigger' => 'axis',
                    'axisPointer' => [
                        'type' => 'cross',
                        'label' => ['backgroundColor' => '#6a7985']
                    ]
                ],
                'legend' => [
                    'data' => ['用户数', '文章数', '阅读量', '评论数', '搜索量']
                ],
                'toolbox' => [
                    'feature' => ['saveAsImage' => new \stdClass()]
                ],
                'grid' => [
                    'left' => '3%',
                    'right' => '4%',
                    'bottom' => '3%',
                    'containLabel' => true
                ],
                'xAxis' => [
                    [
                        'type' => 'category',
                        'boundaryGap' => false,
                        'data' => ['星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期天']
                    ]
                ],
                'yAxis' => [
                    ['type' => 'value']
                ],
                'series' => [
                    [
                        'name' => '用户数',
                        'type' => 'line',
                        'stack' => 'Total',
                        'areaStyle' => new \stdClass(), // 空对象
                        'emphasis' => [
                            'focus' => 'series'
                        ],
                        'data' => [120, 132, 101, 134, 90, 230, 210]
                    ],
                    [
                        'name' => '文章数',
                        'type' => 'line',
                        'stack' => 'Total',
                        'areaStyle' => new \stdClass(), // 空对象
                        'emphasis' => [
                            'focus' => 'series'
                        ],
                        'data' => [220, 182, 191, 234, 290, 330, 310]
                    ],
                    [
                        'name' => '阅读量',
                        'type' => 'line',
                        'stack' => 'Total',
                        'areaStyle' => new \stdClass(), // 空对象
                        'emphasis' => [
                            'focus' => 'series'
                        ],
                        'data' => [150, 232, 201, 154, 190, 330, 410]
                    ],
                    [
                        'name' => '评论数',
                        'type' => 'line',
                        'stack' => 'Total',
                        'areaStyle' => new \stdClass(), // 空对象
                        'emphasis' => [
                            'focus' => 'series'
                        ],
                        'data' => [320, 332, 301, 334, 390, 330, 320]
                    ],
                    [
                        'name' => '搜索量',
                        'type' => 'line',
                        'stack' => 'Total',
                        'label' => [
                            'show' => true,
                            'position' => 'top'
                        ],
                        'areaStyle' => new \stdClass(), // 空对象
                        'emphasis' => [
                            'focus' => 'series'
                        ],
                        'data' => [820, 932, 901, 934, 1290, 1330, 1320]
                    ]
                ]
            ],
            'pieChartOptions' => [
                // 饼图配置数据
                'title' => [
                    'text' => '文章分类',
                    'x' => 'center'
                ],
                'tooltip' => [
                    'trigger' => 'item',
                    'formatter' => "{a} <br/>{b} : {c} ({d}%)"
                ],
                'legend' => [
                    'orient' => 'vertical',
                    'left' => 'left',
                    'data' => ['C', 'C++', 'C#', 'Java', 'Yii']
                ],
                'series' => [
                    [
                        'name' => '文章分类',
                        'type' => 'pie',
                        'radius' => '55%',
                        'center' => ['50%', '60%'],
                        'data' => [
                            ['value' => 5, 'name' => 'C'],
                            ['value' => 6, 'name' => 'C++'],
                            ['value' => 11, 'name' => 'C#'],
                            ['value' => 12, 'name' => 'Java'],
                            ['value' => 19, 'name' => 'Yii']
                        ],
                        'itemStyle' => [
                            'emphasis' => [
                                'shadowBlur' => 10,
                                'shadowOffsetX' => 0,
                                'shadowColor' => 'rgba(0, 0, 0, 0.5)'
                            ]
                        ]
                    ]
                ]
            ],
            'carouselOptions' => [
                // 轮播图配置数据
                'graphic' => [
                    'elements' => [
                            // 这里根据实际情况添加图像元素
                            [
                                'type' => 'image',
                                'style' => [
                                    'image' => 'https://tse1-mm.cn.bing.net/th/id/OIP-C.8Q17_TCLayXr3xf4qMH5oAHaEU?rs=1&pid=ImgDetMain',
                                    'width' => 600,
                                    'height' => 400
                                ],
                                'left' => 'center',
                                'top' => 'middle'
                            ],
                            [
                                'type' => 'image',
                                'style' => [
                                    'image' => 'https://pic2.zhimg.com/v2-282e4046cae1a77c72adbc260a95c61e_b.jpg',
                                    'width' => 600,
                                    'height' => 400
                                ],
                                'left' => 'center',
                                'top' => 'middle'
                            ],
                            [
                                'type' => 'image',
                                'style' => [
                                    'image' => 'https://tse2-mm.cn.bing.net/th/id/OIP-C.8T-A0VXHyVMpArtaF1r7TgHaDy?rs=1&pid=ImgDetMain',
                                    'width' => 600,
                                    'height' => 400
                                ],
                                'left' => 'center',
                                'top' => 'middle'
                            ],
                        ]
                    ]
                ],
            ];
    }

    // 显示所有图表的动作
    public function actionIndex()
    {
        $chartConfig = json_encode($this->getChartConfig());
        return $this->render('index', ['chartConfig' => $chartConfig]);
    }

    
    //显示特定图表
    public function actionView()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $chartData = json_encode($this->getChartData());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'chartData' => $chartData,
        ]);
    }
}
