<?php
namespace common\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    /**
     * @return string 返回该模型对应的数据表名
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @return array 返回该模型的验证规则
     */
    public function rules()
    {
        return [
            [['name'], 'required'],  // name 字段是必填的
            [['name'], 'string', 'max' => 255],  // name 字段是字符串，最大长度255
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类',
        ];
    }

    /**
     * 获取分类列表
     *
     * @return array 返回键值对形式的分类数组，其中键是分类的ID，值是分类的名称
     */
    public static function getCategoryList()
    {
        $categories = self::find()->all();
        return \yii\helpers\ArrayHelper::map($categories, 'id', 'name');
    }

    /**
     * 根据名称查找分类
     *
     * @param string $name 分类名称
     * @return Category|null 返回与名称匹配的分类对象，如果没有找到则返回 null
     */
    public static function findByName($name)
    {
        return self::findOne(['name' => $name]);
    }
}
