<?php
namespace common\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class PdfAsset extends AssetBundle
{
    public $sourcePath = '@common/assets/pdf';
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $css = [
        'css/page.css',
        'css/table.css',
        'css/text-block.css',
        'css/stamp-place.css',
    ];
}
