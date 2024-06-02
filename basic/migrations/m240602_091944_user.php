<?php

use yii\db\Migration;

/**
 * Class m240602_091944_user
 */
class m240602_091944_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'role' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Create initial users
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'email' => 'kolt12566@gmail.com',
            'password_hash' => Yii::$app->security->generatePasswordHash('admin1'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'role' => 'admin',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%user}}', [
            'username' => 'courier',
            'email' => 'cramz992@yandex.ru',
            'password_hash' => Yii::$app->security->generatePasswordHash('courier1'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'role' => 'courier',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240602_091944_user cannot be reverted.\n";

        return false;
    }
    */
}
