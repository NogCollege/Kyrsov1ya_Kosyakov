<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth_assignment}}`.
 */
class m240523_085444_create_auth_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('auth_assignment', [
            'item_name' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk-auth_assignment', 'auth_assignment', ['item_name', 'user_id']);
        $this->addForeignKey('fk-auth_assignment-user_id', 'auth_assignment', 'user_id', 'user', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('auth_assignment');
    }
}
