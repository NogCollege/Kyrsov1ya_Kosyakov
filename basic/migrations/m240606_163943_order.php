<?php

use yii\db\Migration;

/**
 * Class m240606_163943_order
 */
class m240606_163943_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'customer_name' => $this->string()->notNull(),
            'customer_email' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
            'promocode' => $this->string(),
            'delivery_method' => $this->string()->notNull(),
            // Add other columns as needed
            // ...
        ]);

        // Add foreign key constraint
        $this->addForeignKey(
            'fk-order-user_id',
            'order',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign key constraint first
        $this->dropForeignKey('fk-order-user_id', 'order');

        $this->dropTable('order');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240606_163943_order cannot be reverted.\n";

        return false;
    }
    */
}
