<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;





/* @var $this yii\web\View */

?>

<div class="site-index">

    <div class="jumbotron">

        <?php



        if(Yii::$app->session->getFlash('success')){
            echo "<div class='alert alert-success'>";
            echo Yii::$app->session->getFlash('success');
            echo "</div>";
        }

        if(Yii::$app->session->getFlash('success_register')){
            echo "<div class='alert alert-info'>";
            echo Yii::$app->session->getFlash('success_register');
            echo "</div>";
        }






        $session = Yii::$app->session;

        if (empty($session["city"])) {

            ?>

            <h1>Здравствуйте</h1>

            <p class="lead"> <?= $model->city ?> ваш город?</p>
            <?php
            $form = ActiveForm::begin([
                'id' => 'is_your_city',
                'options' => ['class' => 'form-horizontal'],
            ]) ?>
            <?= $form->field($model, 'is_your_city')->radioList([
                'yes' => 'да',
                'no' => 'нет',
            ])->label(false);
            ?>

            <?= $form->field($model, 'city')->hiddenInput()->label(false); ?>


            <div class="form-group">
                <div>
                    <?= Html::submitButton('Выбрать', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end() ?>
            <?php
        } else {
            ?>
            <p class="lead">Ваш город: <?= $session["city"]["name"]; ?></p>
            <?php

        }
        ?>










