<?php

namespace frontend\components;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class CategoryWidget extends Widget
{
    public $categories;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $categoryString = '';

        foreach ($this->categories as $category)
        {
            $url = Yii::$app->urlManager->createUrl(['post/index', 'PostSearch[category_id]' => $category->id], ['style' => 'text-decoration: none;']);
            $categoryString .= '<a href="' . $url . '"style="text-decoration: none;">' . Html::encode($category->name) . '</a> ';
        }

        return $categoryString;
    }
}
