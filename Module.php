<?php

namespace pantera\mail;

use Yii;

class Module extends \yii\base\Module
{
    /* @var array Массив ролей которым доступна админка */
    public $permissions = ['@'];

    public function getMenuItems()
    {
        return [
            [
                'label' => 'E-mail',
                'url' => '#',
                'icon' => 'envelope',
                'items' => [
                    ['label' => Yii::t('mail', 'Mail Templates'), 'url' => ['/mail/template/index']],
                ]
            ]
        ];
    }

    public function init()
    {
        parent::init();
        ModuleAsset::register(Yii::$app->view);
        Yii::$app->view->registerJs('(new mailTemplateClass()).init()');
    }
}
