<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m170619_101607_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'fio' => $this->string(100),
            'email' => $this->string(50),
            'phone' => $this->string(50),
            'date_create' => $this->integer(11),
            'password' => $this->string(50),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
