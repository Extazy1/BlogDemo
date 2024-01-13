<?php

namespace common\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\web\UploadedFile;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $tags
 * @property int $status
 * @property int|null $create_time
 * @property int|null $update_time
 * @property int $author_id
 * @property int $remind 0:未提醒;1:已提醒 
 * 
 * @property Adminuser $author
 * @property Comment[] $comments
 * @property Poststatus $status0
 */
class Post extends \yii\db\ActiveRecord
{
    private $_oldTags;
    public $attachment;  // 用于处理上传的文件

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'status', 'author_id'], 'required'],
            [['content', 'tags'], 'string'],
            [['status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Adminuser::class, 'targetAttribute' => ['author_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Poststatus::class, 'targetAttribute' => ['status' => 'id']],
            [['attachment'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, pdf, doc, docx', 'maxFiles' => 10], // 允许多文件上传
            [['category_id'], 'required'],
            [['category_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'tags' => '标签',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'author_id' => '作者',
            'remind' => '是否提醒',
            'attachment' => '附件',
            'category_id' => '文章分类',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Adminuser::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id']);
    }

    public function getActiveComments()
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id'])
        ->where('status=:status',[':status'=>2])->orderBy('id DESC');
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
    
    /**
     * Gets query for [[Status0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Poststatus::class, ['id' => 'status']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->create_time = time();
            }
            $this->update_time = time();
    
            // 处理多文件上传
            $this->attachment = UploadedFile::getInstances($this, 'attachment');
            $filesPath = [];
            foreach ($this->attachment as $file) {
                $filePath = 'uploads/' . $file->baseName . '.' . $file->extension;
                if ($file->saveAs($filePath)) {
                    $filesPath[] = $filePath;
                }
            }
    
            // 将文件路径数组转换为JSON字符串
            $this->file_path = json_encode($filesPath);
            
            // 确保 category_id 被正确设置
            if ($this->category_id !== null) {
                $this->category_id = intval($this->category_id);
            }  

            return true;
        } else {
            return false;
        }
    }
    
    
    
    public function getUrl()
    {
    	return Yii::$app->urlManager->createUrl(
    			['post/detail','id'=>$this->id,'title'=>$this->title]);
    }
    
    public function getBeginning($length=288)
    {
    	$tmpStr = strip_tags($this->content);
    	$tmpLen = mb_strlen($tmpStr);
    	 
    	$tmpStr = mb_substr($tmpStr,0,$length,'utf-8');
    	return $tmpStr.($tmpLen>$length?'...':'');
    }
    
    /**
     * 返回清洁后的内容
     *
     * @return string
     */
    public function getCleanContent()
    {
        return HtmlPurifier::process($this->content);
    }

    /**
     * 返回附件文件名列表
     */
    public function getAttachmentList()
    {
        // 首先检查 $this->file_path 是否为空
        if (empty($this->file_path)) {
            return []; // 如果为空，直接返回空数组
        }

        $attachments = json_decode($this->file_path);
        $attachmentList = [];

        if (is_array($attachments)) {
            foreach ($attachments as $attachment) {
                $attachmentList[] = basename($attachment);
            }
        }

        return $attachmentList;
    }

    public function  getTagLinks()
    {
    	$links=array();
    	foreach(Tag::string2array($this->tags) as $tag)
    	{
    		$links[]=Html::a(Html::encode($tag),array('post/index','PostSearch[tags]'=>$tag));
    	}
    	return $links;
    }

    public function getCommentCount()
    {
    	return Comment::find()->where(['post_id'=>$this->id,'status'=>2])->count();
    }

    public function afterFind()
    {
    	parent::afterFind();
    	$this->_oldTags = $this->tags;
    }
    
    public function afterSave($insert, $changedAttributes)
    {
    	parent::afterSave($insert, $changedAttributes);
    	Tag::updateFrequency($this->_oldTags, $this->tags);
    }
    
    public function afterDelete()
    {
    	parent::afterDelete();
    	Tag::updateFrequency($this->tags, '');
    }
}