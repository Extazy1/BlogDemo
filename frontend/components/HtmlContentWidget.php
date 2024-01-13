<?php
namespace frontend\components;

use yii\base\Widget;
use yii\helpers\HtmlPurifier;
use Parsedown;

class HtmlContentWidget extends Widget
{
    /**
     * @var string HTML content to be purified and displayed. Can be Markdown format.
     */
    public $content;

    public function run()
    {
        if ($this->content === null) {
            return '';
        }
    
        // 使用 Markdown 解析器将 Markdown 转换为 HTML
        $parsedown = new Parsedown();
        $htmlContent = $parsedown->text($this->content);

        //返回HTML 内容
        return $htmlContent;
    }
}
