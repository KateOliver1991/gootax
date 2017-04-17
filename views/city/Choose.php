<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>



<?php
$form = ActiveForm::begin([
    'id' => 'choose',
    'options' => ['class' => 'form-horizontal col-md-4 col-md-offset-4'],
]) ?>
<?php

if (!empty($cities)) {
    $items = ArrayHelper::map($cities, 'name', 'name');


    echo $form->field($model, 'city')->dropDownList($items);
}

?>


<div class="form-group">
    <div>
        <?= Html::submitButton('Выбрать', ['class' => 'btn btn-primary']) ?>
    </div>
</div>


<?php ActiveForm::end() ?>


