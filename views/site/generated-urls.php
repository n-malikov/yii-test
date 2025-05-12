<?php

/** @var yii\web\View $this */

use app\models\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

$this->title = 'Сгенерированные ссылки';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 class="mb-5"><?= Html::encode($this->title) ?></h1>

<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        //'id',
        [
            'attribute' => 'url',
            'label' => 'Оригинальная ссылка',
        ],
        [
            'attribute' => 'created_at',
            'label' => 'Создано',
        ],
        [
            'attribute' => 'visits_count',
            'label' => 'Переходов',
        ],
        [
            'label' => '',
            'format' => 'raw',
            'value' => function($model) {
                return sprintf('<a href="%s" target="_blank">Короткая ссылка</a>', Url::getShortLinkByID( $model->id ));
            },
        ],
        [
            'label' => '',
            'format' => 'raw',
            'value' => function($model) {
                return sprintf('<a href="%s" target="_blank">QR</a>', Url::getQrCodeByID( $model->id ));
            },
        ],
    ],
    'pager' => [
        'class' => 'yii\bootstrap5\LinkPager'
    ],
]);
?>
