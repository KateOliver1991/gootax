<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */

?>

<div class="site-index">

    <div class="jumbotron">

        <?php
        $session = Yii::$app->session;

        if (empty($session["city"])) {

            ?>

            <h1>Здравствуйте</h1>

            <p class="lead"> <?= $model->city ?> ваш город?</p>
            <?php
            $form = ActiveForm::begin([
                'id' => 'login-form',

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
            <p class="lead">Ваш город: <?= $session["city"]; ?></p>
            <?php

        }
		?>
		<style>
		th{
			text-align:center;
		}
		</style>
		<?php

if(!empty($model->recalls)){
	
	

	echo "<table class='table table-bordered table-striped'>";
	echo "<thead>";
	echo "<th>Дата создания</th><th>Название</th><th>Описание</th><th>Рейтинг</th><th>Изображение</th><th>Автор</th>";
	echo "</thead>";
	echo "<tbody>";
	foreach($model->recalls as $recall){
		echo "<tr><td>".$recall->date_create."</td>"."<td>".$recall->title."</td>"."<td>".$recall->text."</td>"."<td>".$recall->rating."</td><td>".$recall->img.".jpg"."</td><td>".$recall["users"]->fio."</td></tr>";
	}
	echo "</tbody>";
	echo "</table>";

}



?>

	
	<?php
	
	
	?>


        









