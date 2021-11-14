<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%articles}}".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $body
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 *
 * @property Register $createdBy
 */
class Articles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%articles}}';
    }

    public static function behavior()
    {
        return [
            TimestampBehavior::class,[
                'class'=>BlameableBehavior::class,
                'UpdatedByAttribute'=>false
            ],
            [
                'class'=>SluggableBehavior::class,
                'Attribute'=>'title'
            ]
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['body'], 'string'],
            [['created_at', 'updated_at', 'created_by'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'created_by'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Register::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'body' => 'Body',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Register::className(), ['id' => 'created_by']);
    }
}
