<?php
namespace common\components;

use \NumberFormatter;

class Formatter extends \ yii\i18n\Formatter
{
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
