<?php
namespace common\components;

use \NumberFormatter;
use yii\i18n\MessageFormatter;

class Formatter extends \ yii\i18n\Formatter
{
    public function asPriceInWords($value)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        $whole = (int) $value;
        $fractional = (int) (round(fmod($value, 1), 2) * 100);

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

    public function asBillNumber($value)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        $options = [
            NumberFormatter::PADDING_POSITION => NumberFormatter::PAD_AFTER_PREFIX,
            NumberFormatter::FORMAT_WIDTH => 5
        ];
        $textOptions = [
            NumberFormatter::PADDING_CHARACTER => '0',
        ];

        return $this->asInteger($value, $options, $textOptions);
    }
}
