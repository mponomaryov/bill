<?php

/* @var $this yii\web\View */
/* @var $model \common\models\Bill */

use yii\helpers\Html;
use yii\helpers\StringHelper;

$formatter = Yii::$app->formatter;
$this->title = '';
?>

<?php $this->beginBlock('table-caption'); ?>
    Счет № <?= $formatter->asBillNumber($model->bill_number) ?>
    от <?= $formatter->asDate($model->created_at) ?>
<?php $this->endBlock(); ?>

<div class="text-block page__block">
    <?php foreach (['Плательщик', 'Получатель'] as $title): ?>

        <p class="text-block__paragraph">
            <?= $title ?>: <?= $model->payer->asFullString ?>
        </p>

    <?php endforeach ?>
</div>

<table class="table page__block">
    <thead>
        <tr class="table__row
                   table__row--height_auto">
            <th class="table__cell">
                №
            </th>
            <th class="table__cell">
                Наименование товара, работ, услуг
            </th>
            <th class="table__cell">
                Кол-во
            </th>
            <th class="table__cell">
                Ед.
            </th>
            <th class="table__cell">
                Цена
            </th>
            <th class="table__cell">
                Сумма
            </th>
        </tr>
    </thead>
    <tbody>

        <?php
            $totalPrice = 0;

            foreach ($model->billItems as $index => $billItem):
                $totalPrice += $billItem->itemTotalPrice;
        ?>
            <tr class="table__row">
                <td class="table__cell
                           table__cell--align_center">
                    <?= $index + 1 ?>
                </td>
                <td class="table__cell">
                    <?= $billItem->item->name ?>
                </td>
                <td class="table__cell">
                    <?= $billItem->quantity ?>
                </td>
                <td class="table__cell">
                    шт.
                </td>
                <td class="table__cell">
                    <?= $formatter->asMoney($billItem->item->price) ?>
                </td>
                <td class="table__cell">
                    <?= $formatter->asMoney($billItem->itemTotalPrice) ?>
                </td>
            </tr>
        <?php endforeach ?>

        <tr class="table__row">
            <td colspan="5" class="table__cell
                                   table__cell--border_none
                                   table__cell--align_right">
                Итого:
            </td>
            <td class="table__cell">
                <?= $formatter->asMoney($totalPrice) ?>
            </td>
        </tr>
        <tr class="table__row">
            <td colspan="5" class="table__cell
                                   table__cell--border_none
                                   table__cell--align_right">
                В том числе НДС (20%):
            </td>
            <td class="table__cell">
                <?= $formatter->asMoney($totalPrice * 0.2) ?>
            </td>
        </tr>
        <tr class="table__row">
            <td colspan="5" class="table__cell
                                   table__cell--border_none
                                   table__cell--align_right">
                    Всего к оплате:
            </td>
            <td class="table__cell">
                <?= $formatter->asMoney($totalPrice) ?>
            </td>
        </tr>
    </tbody>
</table>

<div class="text-block page__block">
    <p class="text-block__paragraph">
        Всего наименований 1, на сумму <?= $formatter->asMoney($totalPrice) ?>
    </p>
    <p class="text-block__paragraph
              text-block__paragraph--bold">
        <?= StringHelper::mb_ucfirst($formatter->asPriceInWords($totalPrice)) ?>
    </p>
</div>
