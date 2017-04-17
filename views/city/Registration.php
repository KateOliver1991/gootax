<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "Регистрация нового пользователя";
?>
<h2 class="text-center">Регистрация нового пользователя</h2>

<?php
$form = ActiveForm::begin([
    'id' => 'registration',
    'options' => ['class' => 'form-horizontal col-md-4 col-md-offset-4'],
]) ?>
<?php

echo $form->field($model, 'fio');
echo $form->field($model, 'email');
echo $form->field($model, 'phone');
echo $form->field($model, 'password');
echo $form->field($model, 'password_repeat');

echo $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::classname(), [
    'captchaAction' => 'city/captcha'
]);


?>

<div class="form-group">
    <div>
        <?= Html::submitButton('Выбрать', ['class' => 'btn btn-primary']) ?>
    </div>
</div>


<?php ActiveForm::end() ?>
