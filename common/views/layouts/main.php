<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use common\assets\PdfAsset;
use common\assets\ImagesAsset;

PdfAsset::register($this);
$imagesBundle = ImagesAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
        <div class="page">

            <table class="table
                          page__block
                          page__block--top-margin_0">
                <caption class="table__caption
                                table__caption--bottom
                                table__caption--align_center">
                    <?= ArrayHelper::getValue($this, 'blocks.table-caption') ?>
                </caption>
                <colgroup>
                    <col width="25%">
                    <col width="25%">
                    <col width="10%">
                    <col width="40%">
                </colgroup>
                <tbody>
                    <tr class="table__row">
                        <td class="table__cell">
                            ИНН 772160030650
                        </td>
                        <td class="table__cell">
                            КПП
                        </td>
                        <td rowspan="2" class="table__cell">
                            СЧ №
                        </td>
                        <td rowspan="2" class="table__cell">
                            40802810808270000232
                        </td>
                    </tr>
                    <tr class="table__row">
                        <td colspan="2" class="table__cell">
                            Получатель
                            <br>
                            ИП Фамилия Имя Отчество
                        </td>
                    </tr>
                    <tr class="table__row">
                        <td rowspan="2" colspan="2" class="table__cell">
                            Банк получателя
                            <br>
                            Филиал "Бизнес онлайн" Публичного акционерного
                            общества "Ханты-Мансийский банк Открытие"
                        </td>
                        <td class="table__cell">
                            БИК
                        </td>
                        <td class="table__cell
                                   table__cell--bottom-border_none">
                            044583999
                        </td>
                    </tr>
                    <tr class="table__row">
                        <td class="table__cell">
                            СЧ №
                        </td>
                        <td class="table__cell
                                   table__cell--top-border_none">
                            30100181060000000999
                        </td>
                    </tr>
                </tbody>
            </table>

            <?= $content ?>

            <div class="stamp-place
                        page__block">
                <p class="stamp-place__field">
                    Индивидуальный предприниматель:
                </p>
                <p class="stamp-place__value">
                    Фамилия И.О.
                </p>
                <?= Html::img($imagesBundle->baseUrl . '/stamp.png', [
                    'class' => [
                        'stamp-place__stamp',
                        'stamp-place__stamp--align_right',
                    ],
                ]) ?>
            </div>

        </div>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
