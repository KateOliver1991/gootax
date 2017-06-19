<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cities`.
 */
class m170619_093033_create_cities_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function Up()
    {
        $this->createTable('cities', [
            'id' => $this->primaryKey(),
            'name' => $this->string(30)->notNull()->unique(),
            'date_create' => $this->integer(11),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function Down()
    {
        $this->dropTable('cities');
    }
}
