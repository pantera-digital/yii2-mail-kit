<?php

namespace pantera\mail;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class SweetAlertAsset extends AssetBundle
{
    public $sourcePath = '@bower/sweetalert2';

    public $css = [
        'dist/sweetalert2.min.css',
    ];

    public $js = [
        'dist/sweetalert2.min.js',
    ];

    public $depends = [
        JqueryAsset::class,
    ];
}
