<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Url extends ActiveRecord
{
    public static function tableName()
    {
        return '{{url}}';
    }

    public function rules()
    {
        return [
            ['url', 'required'],
            ['url', 'string', 'max' => 255],
            ['url', 'validateUrlManually'],
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

    public function validateUrlManually($attribute, $params)
    {
        $url = $this->$attribute;

        // Проверка на наличие протокола
        if (!preg_match('~^https?://~i', $url)) {
            $this->addError($attribute, 'Ссылка должна начинаться с http:// или https://');
            return;
        }

        // Проверка валидности URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->addError($attribute, 'Некорректный формат URL');
        }

        if (!Url::isUrlAccessible($url))
            $this->addError($attribute, 'Данный URL не доступен');
    }

    /**
     * @param int $url_id
     * @return string
     */
    public static function getShortLinkByID (int $url_id): string
    {
        $domain = Yii::$app->request->getHostInfo();
        return $domain . '/link/?url=' . $url_id;
    }

    /**
     * @param int $url_id
     * @return string
     */
    public static function getQrCodeByID (int $url_id): string
    {
        $domain = Yii::$app->request->getHostInfo();
        return $domain . '/link/qr/?url=' . $url_id;
    }

    /**
     * @param string $url
     * @return bool
     */
    public static function isUrlAccessible(string $url): bool
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true); // не загружать тело ответа
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // таймаут в секундах
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // следовать редиректам
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // для https без проверки SSL

        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_errno($ch);
        curl_close($ch);

        return ($err === 0 && $httpCode >= 200 && $httpCode < 400);
    }

}
