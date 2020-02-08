<?php

use yii\helpers\ArrayHelper;

$this->beginContent('@frontend/views/layouts/custom.php');
?>

<div style="width: 800px">
    <table class="table">
        <caption class="table__caption
                        table__caption_align_center">
            <?= ArrayHelper::getValue($this, 'blocks.table-caption', '') ?>
        </caption>
        <tbody>
            <tr>
                <td class="table__cell
                           table__cell_width_quarter">
                    ИНН 772160030650
                </td>
                <td class="table__cell
                           table__cell_width_quarter">
                    КПП
                </td>
                <td rowspan="2" class="table__cell">
                    СЧ №
                </td>
                <td rowspan="2" class="table__cell">
                    40802810808270000232
                </td>
            </tr>
            <tr>
                <td colspan="2" class="table__cell">
                    Получатель
                    <br>
                    ИП Пупкин Василий Васильевич
                </td>
            </tr>
            <tr>
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
                           table__cell_bottom-border_none">
                    044583999
                </td>
            </tr>
            <tr>
                <td class="table__cell">
                    СЧ №
                </td>
                <td class="table__cell
                           table__cell_top-border_none">
                    30100181060000000999
                </td>
            </tr>
        </tbody>
    </table>

    <?= $content ?>
</div>

<?php $this->endContent(); ?>
