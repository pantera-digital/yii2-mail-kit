<?php

use yii\db\Migration;

/**
 * Handles adding code_for_preview to table `mail_template`.
 */
class m190919_052624_add_code_for_preview_column_to_mail_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('mail_template', 'code_for_preview', $this->text()->null()->comment('Php код для получения данных которые передать в предпросмотр'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('mail_template', 'code_for_preview');
    }
}
