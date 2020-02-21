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

        if (!is_array($this->validLengths)) {
            $this->validLengths = array($this->validLengths);
        }

        $allIntegers = array_reduce(
            $this->validLengths,
            function ($result, $item) { return $result && is_int($item); },
            true
        );

        if (!$allIntegers) {
            throw new InvalidConfigException(
               'validLengths must be an integer or array of integers'
            );
        }

        $this->message = 'Length must be ' 
            . implode(', ', $this->validLengths)
            . ' symbols';
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
