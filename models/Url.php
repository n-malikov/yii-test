<?php

namespace app\models;

use yii\base\Model;

class Url extends Model
{
    public $url;

    public function rules()
    {
        return [
            ['url', 'required'],
            ['url', 'validateUrlManually'],
        ];
    }

    public function validateUrlManually($attribute, $params)
    {
        $url = $this->$attribute;

        // Проверка на наличие схемы
        if (!preg_match('~^https?://~i', $url)) {
            $this->addError($attribute, 'Ссылка должна начинаться с http:// или https://');
            return;
        }

        // Проверка валидности URL (без использования 'url'-валидатора)
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->addError($attribute, 'Некорректный формат URL');
        }
    }

    public static function isUrlAccessible($url)
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
