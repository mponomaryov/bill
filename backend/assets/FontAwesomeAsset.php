<?php
namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Font-awesome asset bundle.
 */
class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@bower/font-awesome';
    public $css = [
        'css/font-awesome.min.css',
    ];
}
