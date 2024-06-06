<?php

use yii\db\Migration;

/**
 * Class m240604_141358_orders_item
 */
class m240604_141358_orders_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_item}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'tovar_id' => $this->integer()->notNull(), // Изменяем поле на 'tovar_id'
            'quantity' => $this->integer()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Добавляем внешний ключ к таблице заказов
        $this->addForeignKey(
            'fk-order_item-order_id',
            'order_item',
            'order_id',
            'order',
            'id',
            'CASCADE'
        );

        // Добавляем внешний ключ к таблице TOVAR
        $this->addForeignKey(
            'fk-order_item-tovar_id',
            'order_item',
            'tovar_id',
            'TOVAR', // Имя вашей таблицы TOVAR
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-order_item-order_id', 'order_item');
        $this->dropForeignKey('fk-order_item-tovar_id', 'order_item');
        $this->dropTable('{{%order_item}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240604_141358_orders_item cannot be reverted.\n";

        return false;
    }
    */
}
