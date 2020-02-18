<?php
namespace backend\components;

use Yii;
use yii\helpers\Html;

/**
 * Standard ActionColumn with minor modifications replacing glyphs
 * from bootstrap with font-awesome glyphs
 */
class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * {@inheritdoc}
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye');
        $this->initDefaultButton('update', 'pencil');
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
        $this->initDefaultButton('pdf', 'file-pdf-o', [
            'target' => '_blank',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => "fa fa-{$iconName}"]);
                return Html::a($icon, $url, $options);
            };
       }
    }

    protected function renderFilterCellContent()
    {
        if (!empty(Yii::$app->request->queryString)) {
            return Html::a('Reset', ['index'], [
                'class' => ['btn btn-primary'],
            ]);
        }
    }
}
