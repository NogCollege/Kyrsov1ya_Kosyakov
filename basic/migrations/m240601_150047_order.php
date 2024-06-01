<?php

use yii\db\Migration;

/**
 * Class m240601_150047_order
 */
class m240601_150047_order extends Migration
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
            'promocode' => $this->string()->notNull(),
            'delivery_method' => $this->string()->notNull(),
            'total' => $this->decimal(10, 2)->notNull()->defaultValue(0.00),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Добавляем индекс для поля status
        $this->createIndex('idx-order-status', '{{%order}}', 'status');
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
        echo "m240601_150047_order cannot be reverted.\n";

        return false;
    }
    */
}
