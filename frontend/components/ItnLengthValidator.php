<?php
namespace frontend\components;

use yii\validators\Validator;

/**
 * ITN length validator
 */
class ItnLengthValidator extends Validator
{
    public $message = 'length must be 10 or 12 symbols';

    public function validateAttribute($model, $attribute)
    {
        $length = mb_strlen($model->$attribute, 'UTF-8');

        if (!in_array($length, [10, 12])) {
            $this->addError($attribute, $this->message);
        }

    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $lengths = json_encode([10, 12]);
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return "if ($.inArray(value.length, $lengths) === -1) {
            messages.push($message);
        }";
    }
}
