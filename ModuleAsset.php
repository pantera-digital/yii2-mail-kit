<?php

namespace pantera\mail;

use yii\web\AssetBundle;

class ModuleAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/assets';

    public $css = [
        'css/style.css',
    ];

    public $js = [
        'js/script.js',
    ];

    public $depends = [
        AceAsset::class,
    ];
}
