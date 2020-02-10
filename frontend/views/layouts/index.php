<?php

use yii\helpers\ArrayHelper;

$this->beginContent('@frontend/views/layouts/main.php');
?>

<div class="page">
    <table class="table page__block">
        <caption class="table__caption
                        table__caption--bottom
                        table__caption--align_center">
            <?= ArrayHelper::getValue($this, 'blocks.table-caption', '') ?>
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
                    Филиал "Бизнес онлайн" Публичного акционерного общества
                    "Ханты-Мансийский банк Открытие"
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
</div>

<?php $this->endContent(); ?>
