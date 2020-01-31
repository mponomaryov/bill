<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

//use common\widgets\Alert;
use frontend\assets\AppAsset;

AppAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <style>
            .table {
                width: 100%;
                border-spacing: 0;
                border-collapse: collapse;
            }

            .table__caption {
                caption-side: bottom;
            }

            .table__cell {
                padding-left: 5px;
                padding-right: 5px;
                height: 40px;
                border: 1px black solid;
            }

            .table__cell_width_quarter {
                width: 25%;
            }

            .table__cell_top-border_none {
                border-top: none;
            }

            .table__cell_bottom-border_none {
                border-bottom: none;
            }

            .table__cell_text-align_right {
                text-align: right;
            }

            .fieldset {
                border: none;
                display: grid;
                grid-template-rows: repeat(3, 1fr);
                grid-template-columns: 1fr 1fr;
            }
        </style>
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
        <?= $content ?>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
