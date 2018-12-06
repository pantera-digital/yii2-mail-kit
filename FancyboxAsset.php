<?php

namespace pantera\mail;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class FancyboxAsset extends AssetBundle
{
    public $sourcePath = '@bower/fancybox/dist';

    public $css = [
        'jquery.fancybox.css',
    ];

    public $js = [
        'jquery.fancybox.js',
    ];

    public $depends = [
        JqueryAsset::class,
    ];
}
