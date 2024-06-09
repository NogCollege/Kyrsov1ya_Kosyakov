<?php

use yii\db\Migration;

/**
 * Class m240608_143628_orders
 */
class m240608_143628_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'customer_name' => $this->string()->notNull(),
            'phone_number' => $this->string(20)->notNull(),
            'address' => $this->string()->notNull(),
            'promocode' => $this->string()->notNull(),
            'delivery_method' => $this->string()->notNull(),
            'customer_email' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240608_143628_orders cannot be reverted.\n";

        return false;
    }
    */
}
