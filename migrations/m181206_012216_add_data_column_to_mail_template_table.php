<?php

use yii\db\Migration;

/**
 * Handles adding data to table `mail_template`.
 */
class m181206_012216_add_data_column_to_mail_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%mail_template}}', 'data', $this->text()->null()->comment('Данные которые будут переданы в шаблон'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%mail_template}}', 'data');
    }
}
