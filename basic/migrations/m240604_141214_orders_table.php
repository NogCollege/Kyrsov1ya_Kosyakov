<?php

use yii\db\Migration;

/**
 * Class m240604_141214_orders_table
 */
class m240604_141214_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'customer_name' => $this->string()->notNull(),
            'customer_email' => $this->string()->notNull(),
            'delivery_method' => $this->string()->notNull(),
            'promocode' => $this->string(),
            'total' => $this->decimal(10, 2)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240604_141214_orders_table cannot be reverted.\n";

        return false;
    }
    */
}
