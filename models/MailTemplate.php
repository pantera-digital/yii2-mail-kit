<?php

namespace pantera\mail\models;

use function array_keys;

/**
 * This is the model class for table "{{%mail_template}}".
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property string $template
 * @property string $from
 * @property string $subject
 * @property string $content_type
 */
class MailTemplate extends \yii\db\ActiveRecord
{
    const CONTENT_TYPE_PLAINT = 'plaint';
    const CONTENT_TYPE_HTML = 'html';

    /**
     * Получить список возможных content type
     * @return array
     */
    public function getContentTypeList(): array
    {
        return [
            self::CONTENT_TYPE_PLAINT => 'Plaint',
            self::CONTENT_TYPE_HTML => 'Html',
        ];
    }

    /**
     * Получить выбраный content type
     * @return string
     */
    public function getCurrentContentType(): string
    {
        return $this->getContentTypeList()[$this->content_type];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mail_template}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['template'], 'string'],
            [['name', 'alias', 'from', 'subject'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['content_type'], 'in', 'range' => array_keys($this->getContentTypeList())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'alias' => 'Alias',
            'template' => 'Template',
            'from' => 'From',
            'subject' => 'Subject',
            'content_type' => 'Content Type',
        ];
    }
}
