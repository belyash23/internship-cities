<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%review}}`.
 */
class m210629_103037_create_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%review}}', [
            'id' => $this->primaryKey(),
            'id_city' => $this->integer(),
            'title' => $this->string(100)->notNull(),
            'text' => $this->string(255)->notNull(),
            'rating' => $this->integer(1)->notNull(),
            'img' => $this->string(),
            'id_author' => $this->integer()->notNull(),
            'date_create' => $this->date()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%review}}');
    }
}
