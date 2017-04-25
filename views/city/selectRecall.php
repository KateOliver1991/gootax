<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

if (isset($template)) {
    echo $template;
}

if (isset($model)) {
    $this->title = "Добавление нового отзыва";
    ?>
    <h2 class="text-center"><?= $this->title ?></h2>

    <?php
    $form = ActiveForm::begin([
        'id' => 'registration',
        'options' => ['class' => 'form-horizontal col-md-4 col-md-offset-4'],
    ]) ?>
    <?php


    echo $form->field($model, 'city')->widget(\yii\jui\AutoComplete::classname(), [
        'clientOptions' => [
            'source' => $cities,
        ],
    ]);
    echo $form->field($model, 'title');
    echo $form->field($model, 'text');
    echo $form->field($model, 'rating');
    echo $form->field($model, 'img');


    ?>

    <div class="form-group">
        <div>
            <?= Html::submitButton('Выбрать', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>


    <?php ActiveForm::end() ?>

    <?php
}
?>


<div id="cities"></div>

