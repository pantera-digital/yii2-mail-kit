<?php

namespace pantera\mail\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
 * @property integer $layout_id
 * @property string $data
 * @property string $code_for_preview
 *
 * @property MailTemplate $layout
 */
class MailTemplate extends ActiveRecord
{
    const CONTENT_TYPE_PLAIN = 'plain';
    const CONTENT_TYPE_HTML = 'html';

    public static function getList(): array
    {
        $models = self::find()
            ->all();
        return ArrayHelper::map($models, 'id', 'name');
    }

    /**
     * Получить список возможных content type
     * @return array
     */
    public function getContentTypeList(): array
    {
        return [
            self::CONTENT_TYPE_PLAIN => 'Plain',
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
            [['name', 'alias', 'content_type'], 'required'],
            [['layout_id'], 'integer'],
            [['template'], 'string'],
            [['name', 'alias', 'from', 'subject'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['data', 'code_for_preview'], 'safe'],
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
            'name' => Yii::t('mail', 'Name'),
            'alias' => Yii::t('mail', 'Alias'),
            'template' => Yii::t('mail', 'Template'),
            'from' => Yii::t('mail', 'From'),
            'subject' => Yii::t('mail', 'Subject'),
            'content_type' => Yii::t('mail', 'Content Type'),
            'layout_id' => Yii::t('mail', 'Layout'),
            'data' => Yii::t('mail', 'Sample data to be transferred to the template'),
            'code_for_preview' => Yii::t('mail', 'Php code for receiving data to be transmitted to preview'),
        ];
    }

    public function getLayout(): ActiveQuery
    {
        return $this->hasOne(MailTemplate::class, ['id' => 'layout_id']);
    }
}
