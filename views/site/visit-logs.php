<?php

/** @var yii\web\View $this */

use app\models\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

$this->title = 'Логи переходов';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 class="mb-5"><?= Html::encode($this->title) ?></h1>

<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => 'Короткая ссылка',
            'format' => 'raw',
            'value' => function($model) {
                return Url::getShortLinkByID( $model->url_id );
            },
        ],
        [
            'label' => 'Целевая ссылка',
            'format' => 'raw',
            'value' => function($model) {
                return Url::getUrlByID( $model->url_id );
            },
        ],
        'ip',
        'created_at',
    ],
    'pager' => [
        'class' => 'yii\bootstrap5\LinkPager'
    ],
]);
?>
