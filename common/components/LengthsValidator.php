<?php
namespace common\components;

use yii\validators\Validator;
use yii\base\InvalidConfigException;

/**
 * Lengths validator
 */
class LengthsValidator extends Validator
{
    public $message;
    public $validLengths;

    public function init()
    {
        parent::init();

        if ($this->validLengths === null) {
            throw new InvalidConfigException(
                'Required parameter not specified: validLengths'
            );
        }

        $this->validLengths = is_array($this->validLengths)
            ? array_unique($this->validLengths)
            : array($this->validLengths);

        sort($this->validLengths);

        $isAllNonNegativeIntegers = array_reduce(
            $this->validLengths,
            function ($r, $i) { return $r && (is_int($i) && $i >= 0); },
            true
        );

        if (!$isAllNonNegativeIntegers) {
            throw new InvalidConfigException(
                'validLengths must be a non-negative integer or '
                . 'an array of non-negative integers'
            );
        }

        $this->message = 'Length must be ';

        if (count($this->validLengths) > 1) {
            $this->message .= implode(' ', [
                implode(', ', array_slice($this->validLengths, 0, -1)),
                'or',
                end($this->validLengths),
                'symbols',
            ]);
        } else {
            $length = $this->validLengths[0];
            $this->message .= implode(' ', [
                $length,
                ['symbol', ' symbols'][!$length || $length > 1],
            ]);
        }
    }

    public function validateAttribute($model, $attribute)
    {
        $length = mb_strlen($model->$attribute, 'UTF-8');

        if (!in_array($length, $this->validLengths)) {
            $this->addError($attribute, $this->message);
        }

    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $lengths = json_encode($this->validLengths);
        $message = json_encode(
            $this->message,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
        return "if ($.inArray(value.length, {$lengths}) === -1) {
            messages.push({$message});
        }";
    }
}
