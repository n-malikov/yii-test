<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Url $model */

$this->title = 'Test';
?>

<div class="jumbotron text-center bg-transparent mt-5 mb-5">
    <h1 class="display-4">Генератор QR кодов</h1>
</div>


<div class="mt-5 mb-5">

    <?php $form = ActiveForm::begin([
        'id' => 'ajax-url-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
    ]); ?>

    <?= $form->field($model, 'url') ?>

    <div class="form-group">
        <?= Html::submitButton('ОК', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div id="result"></div>

</div>

<?php
$script = <<<JS
$('#ajax-url-form').on('beforeSubmit', function(e) {
    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function (data) {
            
            console.log(data);
            
            if (data.success) {
                $('#result').html('<div class="alert alert-success">' + data.message + '</div>');
            } else {
                let errors = Object.values(data.errors).flat().join('<br>');
                $('#result').html('<div class="alert alert-danger">' + errors + '</div>');
            }
        },
        error: function () {
            $('#result').html('<div class="alert alert-danger">Ошибка при отправке</div>');
        }
    });
    return false;
});
JS;
$this->registerJs($script);
