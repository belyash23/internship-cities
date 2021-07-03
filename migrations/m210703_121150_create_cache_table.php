<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cache}}`.
 */
class m210703_121150_create_cache_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cache}}', [
            'id' => $this->primaryKey(),
            'expire' => $this->integer(),
            'data' => 'BLOB'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cache}}');
    }
}
