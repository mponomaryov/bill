<?php
namespace frontend\components;

use yii\helpers\ArrayHelper;

class ActiveField extends \yii\bootstrap\ActiveField
{
    public function textInput($options = [])
    {
        $placeholder = ArrayHelper::getValue($options, 'placeholder', '');

        if (!$placeholder && $placeholder !== false) {
            $options['placeholder'] = $this->model->getAttributeLabel(
                $this->attribute
            );
        }

        return parent::textInput($options);
    }
}
