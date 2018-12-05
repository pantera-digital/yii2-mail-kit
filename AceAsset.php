<?php

namespace pantera\mail;

use yii\web\AssetBundle;

class AceAsset extends AssetBundle
{
    public $sourcePath = '@npm/ace-builds';

    public $js = [
        'src-min/ace.js'
    ];
}
