<?php
namespace frontend\components;

use yii\base\Widget;
use yii\helpers\Html;

class RctReplyWidget extends Widget
{
    public $recentComments;
    
    public function init()
    {
        parent::init();
    }
    
    public function run()
    {
        $commentString = '';
        
        foreach ($this->recentComments as $comment)
        {
            $commentString .= '<div class="post">' .
                    '<div class="title">' .
                    '<p style="color:#777777;font-style:italic;">' .
                    nl2br($comment->content) . '</p>' .
                    '<p class="text"> <i class="bi bi-person-fill" aria-hidden="true"></i> ' .
                    Html::encode($comment->user->username) . '</p>' .
                    
                    '<p style="font-size:8pt; color:blue">' .
                            '《<a href="' . $comment->post->url . '" class="text-decoration-none">' . Html::encode($comment->post->title) . '</a>》</p>' .
                    '<hr></div></div>';
        }
        return $commentString;
    }
}
