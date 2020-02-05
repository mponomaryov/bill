<?php
namespace frontend\helpers;

use yii\i18n\MessageFormatter;

class PriceHelper
{
    public static function price2Str($price)
    {
        $whole = (int) $price;
        $fractional = (int) (round(fmod($price, 1), 2) * 100);

        $patterns = [
            'whole' => [
                '{value, spellout}',
                '{value, plural, =0{рублей} =1{рубль} one{рубль} few{рубля} many{рублей} other{рублей}}',
            ],
            'fractional' => [
                '{value, spellout,%spellout-cardinal-feminine}',
                '{value, plural, =0{копеек} =1{копейка} one{копейка} few{копейки} many{копеек} other{копеек}}',
            ],
        ];

        $formatter = new MessageFormatter();
        $result = [];

        foreach (['whole', 'fractional'] as $value) {
            foreach ($patterns[$value] as $pattern) {
                $result[] = $formatter->format(
                    $pattern,
                    ['value' => $$value],
                    'ru-RU'
                );
            }
        }

        return implode(' ', $result);
    }
}
