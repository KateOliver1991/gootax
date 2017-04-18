<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;


?>
<h2 class="text-center">Авторизация</h2>
<div>
<?php
$form = ActiveForm::begin([
    'id' => 'login',
    'options' => ['class' => 'form-horizontal col-md-4 col-md-offset-4'],
]) ?>
<?php

echo $form->field($model, 'email');
echo $form->field($model, 'password');


?>

<div class="form-group">
    <div>
        <?= Html::submitButton('Выбрать', ['class' => 'btn btn-primary']) ?>
    </div>
</div>


<?php ActiveForm::end() ?>
</div>

<div class="text-center" style="clear:left">
Вы еще не зарегистрированы?
<br>
    <?= Html::a('Регистрация',['/city/registration']);?>
</div>