<?php

use yii\db\Migration;

/**
 * Class m190315_071719_table_chat
 */
class m190315_071719_table_chat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safUp()
    {
        $this->createTable('chat', [
            'id' => $this->primaryKey(),
            'chanel' => $this->string(),
            'message' => $this->string(),
            'user_id' => $this->integer(),
            'created_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('%chat');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190315_071719_table_chat cannot be reverted.\n";

        return false;
    }
    */
}
