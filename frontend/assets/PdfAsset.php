<?php
namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class PdfAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets';
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $css = [
        'css/page-pdf.css',
        'css/table.css',
        'css/text-block.css',
        'css/stamp-place-pdf.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
