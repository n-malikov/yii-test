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
        'id',
        'url',
        'created_at',
        [
            'label' => 'Мой столбец',
            'format' => 'raw',
            'value' => function($model) {
                //return myCustomFunction($model->id);
            },
        ],
    ],
    'pager' => [
        'class' => 'yii\bootstrap5\LinkPager'
    ],
]);
?>
