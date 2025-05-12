<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $url_id
 * @property string $ip
 * @property string $created_at
 */
class UrlLog extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'url_logs'; // Указываем имя таблицы
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url_id', 'ip'], 'required'],
            [['url_id'], 'integer'],
            [['ip'], 'string', 'max' => 45],
            [['created_at'], 'safe'],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->created_at = date('Y-m-d H:i:s');
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url_id' => 'URL ID',
            'ip' => 'IP адрес',
            'created_at' => 'Дата визита',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUrl()
    {
        return $this->hasOne(Url::class, ['id' => 'url_id']);  // Связь с таблицей url
    }

}
