<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets';
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $css = [
        'css/page.css',
        'css/table.css',
        'css/line.css',
        'css/fieldset.css',
        'css/form.css',
        'css/grid.css',
        'css/button.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
