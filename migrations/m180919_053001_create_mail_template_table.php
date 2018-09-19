<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mail_template`.
 */
class m180919_053001_create_mail_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mail_template}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'alias' => $this->string()->notNull()->unique(),
            'template' => $this->text()->null(),
            'from' => $this->string()->null(),
            'subject' => $this->string()->null(),
            'content_type' => 'ENUM("plain", "html") NOT NULL DEFAULT "html"',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mail_template}}');
    }
}
