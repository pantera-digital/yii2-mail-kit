<?php

use yii\db\Migration;

/**
 * Handles adding layout_id to table `mail_template`.
 * Has foreign keys to the tables:
 *
 * - `mail_template`
 */
class m181205_020155_add_layout_id_column_to_mail_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%mail_template}}', 'layout_id', $this->integer()->null());

        // creates index for column `layout_id`
        $this->createIndex(
            'idx-mail_template-layout_id',
            '{{%mail_template}}',
            'layout_id'
        );

        // add foreign key for table `mail_template`
        $this->addForeignKey(
            'fk-mail_template-layout_id',
            '{{%mail_template}}',
            'layout_id',
            'mail_template',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `mail_template`
        $this->dropForeignKey(
            'fk-mail_template-layout_id',
            '{{%mail_template}}'
        );

        // drops index for column `layout_id`
        $this->dropIndex(
            'idx-mail_template-layout_id',
            '{{%mail_template}}'
        );

        $this->dropColumn('{{%mail_template}}', 'layout_id');
    }
}
