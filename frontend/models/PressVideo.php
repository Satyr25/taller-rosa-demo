<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "press_video".
 *
 * @property int $id
 * @property string $video
 * @property int $press_id
 *
 * @property Press $press
 */
class PressVideo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'press_video';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video', 'press_id'], 'required'],
            [['press_id'], 'integer'],
            [['video'], 'string', 'max' => 255],
            [['press_id'], 'exist', 'skipOnError' => true, 'targetClass' => Press::className(), 'targetAttribute' => ['press_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'video' => 'Video',
            'press_id' => 'Press ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPress()
    {
        return $this->hasOne(Press::className(), ['id' => 'press_id']);
    }
}
