<?php

use yii\db\Migration;

/**
 * Handles the creation of table `recalls`.
 */
class m170619_094913_create_recalls_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('recalls', [
            'id' => $this->primaryKey(),
            'id_city' => $this->integer(11),
            'title' => $this->string(50),
            'text' => $this->string(100),
            'rating' => $this->integer(5),
            'img' => $this->string(50),
            'id_author' => $this->integer(5),
            'date_create' => $this->integer(11),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('recalls');
    }
}
