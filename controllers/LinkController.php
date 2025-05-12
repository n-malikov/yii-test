<?php

namespace app\controllers;

use app\models\Url;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class LinkController extends Controller
{
    public function actionIndex()
    {
        $urlID = (int) Yii::$app->request->get('url');

        $model = Url::findOne($urlID);

        if (!$model)
            throw new NotFoundHttpException('Запрашиваемая страница не найдена.');

        return $model->url;
    }

    public function actionQr()
    {
        // /link/qr?url=1
        $urlID = (int) Yii::$app->request->get('url');

        $model = Url::findOne($urlID);

        if (!$model)
            throw new BadRequestHttpException('Некорректный или отсутствующий URL');

        $qrCode = QrCode::create( Url::getShortLinkByID( $model->id ) )
            ->setSize(300)
            ->setMargin(10)
            ->setEncoding(new \Endroid\QrCode\Encoding\Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new \Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh());

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', $result->getMimeType());

        return $result->getString();
    }
}