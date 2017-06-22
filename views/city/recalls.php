<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\models\ChooseCity;

/* @var $this yii\web\View */

?>


<style>
    th {
        text-align: center;
    }
</style>
<?php

/*

if (isset(Yii::$app->request->cookies["login"]) && !empty($model) && !empty($model->recalls)) {


    ?>

    <table class='table table-bordered table-striped'>
        <thead>
        <th>Дата создания</th>
        <th>Название</th>
        <th>Описание</th>
        <th>Рейтинг</th>
        <th>Изображение</th>
        <th>Автор</th>
        </thead>
        <tbody>

        <?php
        foreach ($model->recalls as $recall) {
            $row = "<tr>";
            $row .= "<td>" . $recall->date_create . "</td>" . "<td>" . $recall->title . "</td>" . "<td>" . $recall->text . "</td>" . "<td>" . $recall->rating . "</td><td>" . $recall->img . "</td>";
            isset($recall["users"]->fio) ? $row .= "<td>" . $recall["users"]->fio . "</td>" : $row .= "<td>" . "без автора" . "</td>";
            $row .= "<td>" . HTML::a("Редактировать", '', ["class" => "edit_recall", 'data' => ['city' => YII::$app->session["city"]["name"], 'title' => $recall->title, 'text' => $recall->text, 'rating' => $recall->rating, 'img' => $recall->img]]) . "</td>";
            $row .= "<td>" . HTML::a("Удалить", ['city/del-recall'], ["class" => "del_recall", 'data' => ['id' => $recall->id]]) . "</td>";
            $row .= "</tr>";
            echo $row;
        }
        ?>

        </tbody>
    </table>
    <?php



    ?>


    <div style='display:none;' id='form_hide' class="row">


        <?php Pjax::begin(); ?>
        <?php
        $form = ActiveForm::begin([
            'options' => ['data-pjax' => true, 'timeout' => 5000],

            'action' => 'add-recall',
            'id' => 'registration',
            'options' => ['class' => 'form-horizontal col-md-4 col-md-offset-4'],
        ]) ?>
        <?php


                        echo $form->field($model, 'city')->widget(\yii\jui\AutoComplete::classname(), [
                            'clientOptions' => [
                                'source' => $cities,
                            ],
                        ]);

        echo $form->field($model, 'city');
        echo $form->field($model, 'title');
        echo $form->field($model, 'text');
        echo $form->field($model, 'rating');
        echo $form->field($model, 'img');


        ?>


        <div class="form-group">
            <div>
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>


        <?php ActiveForm::end() ?>

        <?php Pjax::end(); ?>

    </div>

    <?php
} else if (!isset(Yii::$app->request->cookies["login"]) && !empty($model) && !empty($model->recalls)) {
    ?>
    <div class='alert alert-info'>Войдите в свою учетную запись, чтобы видеть отзывы</div>
    <?php
}




$city = IsYourCity::findOne(["name" => Yii::$app->session["city"]]);

*/

if (isset(Yii::$app->request->cookies["login"]) && !empty($model) && !empty($model->recalls)) {

    ?>




    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'title',
            'text',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


    <?php
    echo HTML::a("Добавить", "#", ["id" => "add_recall"]) . "\r\n";


    ?>


    <div style='' id='form_hide' class="row">


        <?php


        $form = ActiveForm::begin([
            'action' => 'add-recall',
            'id' => 'add',
            'options' => ['class' => 'form-horizontal col-md-4 col-md-offset-4'],
        ]) ?>
        <?php
        echo $form->field($model, 'city');
        echo $form->field($model, 'title');
        echo $form->field($model, 'text');
        echo $form->field($model, 'rating');
        echo $form->field($model, 'img');
        ?>


        <div class="form-group">
            <div>
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>


        <?php ActiveForm::end() ?>


    </div>

    <?php
} else if (!isset(Yii::$app->request->cookies["login"]) && !empty($model) && !empty($model->recalls) || isset($template)) {
    ?>
    <div class='alert alert-info'>Войдите в свою учетную запись, чтобы видеть отзывы</div>
    <?php
}


?>




