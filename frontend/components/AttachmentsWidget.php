<?php
namespace frontend\components;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use common\models\Post; // 确保你有一个Post模型与数据库交互

class AttachmentsWidget extends Widget
{
    public $postId; // 文章ID

    public function init()
    {
        parent::init();
        if ($this->postId === null) {
            throw new \InvalidArgumentException('AttachmentWidget::postId must be set.');
        }
    }
    
    public function run()
    {
        // 获取文章模型
        $post = Post::findOne($this->postId);
        if (!$post) {
            return ""; // 如果没有找到文章，不显示任何内容
        }
        
        // 获取附件列表
        $attachments = $post->getAttachmentList();
        if (empty($attachments)) {
            return ""; // 如果没有附件，不显示任何内容
        }
        
        $attachmentLinks = [];
        foreach ($attachments as $attachment) {
            // 生成指向后端下载脚本的URL
            $url = Yii::getAlias('@backend') . '/uploads/download.php?file=' . urlencode($attachment); 
            // 生成链接并添加到链接数组中
            // 使用 download 属性来指定下载文件而不是导航
            $attachmentLinks[] = Html::a(Html::encode($attachment), $url, [
                'class' => 'text-decoration-none',
                'download' => true
            ]);
        }
        
        // 返回所有附件链接的HTML字符串，用空格分隔
        return implode(' ', $attachmentLinks);
    }
}
