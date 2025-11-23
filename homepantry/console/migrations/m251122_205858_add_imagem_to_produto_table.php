<?php

use yii\db\Migration;

class m251122_205858_add_imagem_to_produto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251122_205858_add_imagem_to_produto_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251122_205858_add_imagem_to_produto_table cannot be reverted.\n";

        return false;
    }
    */
}
