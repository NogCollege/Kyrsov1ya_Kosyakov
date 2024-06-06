<?php

use yii\db\Migration;

/**
 * Class m240604_135308_promocode
 */
class m240604_135308_promocode extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%promo_code}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull()->unique(),
            'discount' => $this->integer()->notNull(),
            'valid_from' => $this->dateTime()->notNull(),
            'valid_to' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%promo_code}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240604_135308_promocode cannot be reverted.\n";

        return false;
    }
    */
}
