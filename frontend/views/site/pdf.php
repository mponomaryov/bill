<?php

/* @var $this yii\web\View */
/* @var $model \common\models\Bill */

use yii\helpers\Html;
use yii\helpers\StringHelper;

$formatter = Yii::$app->formatter;
$this->title = '';
?>

<?php $this->beginBlock('table-caption'); ?>
    <?= implode(' ', [
        'Счет №',
        $formatter->asBillNumber($model->bill_number),
        'от',
        $formatter->asDate($model->created_at),
    ]) ?>
<?php $this->endBlock(); ?>

<?php foreach (['Плательщик', 'Получатель'] as $title): ?>
    <p>
        <?= $title ?>: <?= $model->payer->name ?>, ИНН
        <?= implode('/', array_filter([
            $model->payer->itn,
            $model->payer->iec
        ])) ?>,
        <?= $model->payer->address ?>
    </p>
<?php endforeach ?>

<table class="table">
    <thead>
        <tr>
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
            <tr>
                <td class="table__cell">
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

        <tr>
            <td colspan="5"
                class="table__cell
                       table__cell_border_none
                       table__cell_text-align_right">
                Итого:
            </td>
            <td class="table__cell">
                <?= $formatter->asMoney($totalPrice) ?>
            </td>
        </tr>
        <tr>
            <td colspan="5"
                class="table__cell
                       table__cell_border_none
                       table__cell_text-align_right">
                В том числе НДС (20%):
            </td>
            <td class="table__cell">
                <?= $formatter->asMoney($totalPrice * 0.2) ?>
            </td>
        </tr>
        <tr>
            <td colspan="5"
                class="table__cell
                       table__cell_border_none
                       table__cell_text-align_right">
                    Всего к оплате:
            </td>
            <td class="table__cell">
                <?= $formatter->asMoney($totalPrice) ?>
            </td>
        </tr>
    </tbody>
</table>

<p>
    Всего наименований 1, на сумму <?= $formatter->asMoney($totalPrice) ?>
</p>
<p>
    <b>
        <?= StringHelper::mb_ucfirst(
            $formatter->asPriceInWords($totalPrice)
        ) ?>
    </b>
</p>
<div>
    <p>Индивидуальный предприниматель:</p>
    <p>Пупкин В.В.</p>
    <?= Html::img(Yii::getAlias('@web' . '/stamp.png')) ?>
</div>
