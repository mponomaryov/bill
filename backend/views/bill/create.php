<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model common\models\Bill */

$this->title = 'Create Bill';
$this->params['breadcrumbs'][] = ['label' => 'Bills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Tabs::widget([
        'renderTabContent' => false,
        'items' => [
            [
                'label' => 'Select from DB',
                'url' => 'create',
                'active' => !$isNewOrganization,
            ],
            [
                'label' => 'New organization',
                'url' => 'create-new',
                'active' => $isNewOrganization,
            ],
        ],
    ]) ?>

    <div class="tab-pane active" style="margin-top: 40px;">

        <?php if (!$isNewOrganization): ?>

            <?= $this->render('_organizationsGrid', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]) ?>

        <?php endif; ?>

        <?php $form = ActiveForm::begin(); ?>

            <?php if (!$isNewOrganization): ?>

                <?= $form->field($model, 'payer_id', [
                    'template' => '{input}',
                    'options' => ['tag' => false],
                ])->hiddenInput() ?>

            <?php else: ?>

                <?php foreach ($model->attributes() as $attribute): ?>

                    <?php if (!in_array($attribute, ['payer_id', 'quantity'])): ?>

                        <?= $form->field($model, $attribute)->textInput() ?>

                    <?php endif; ?>

                <?php endforeach; ?>

            <?php endif; ?>

            <div class="form-group">
                <label class="contol-label">Товар</label>
                <?= Html::dropDownList('', null, \common\models\Item::find()
                    ->select(['name', 'id'])
                    ->indexBy('id')
                    ->column(), ['class' => 'form-control', 'disabled' => true]
                ) ?>
            </div>

            <?= $form->field($model, 'quantity')->textInput([
                'type' => 'number',
                'value' => 1,
                'min' => 1,
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', [
                    'class' => 'btn btn-success'
                ]) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<?php
    if (!$isNewOrganization):
        $gridId = 'organizations-grid';
        $payerInputId = Html::getInputId($model, 'payer_id');
        $this->registerJs(<<<JS
            $('#{$form->id}').on('beforeValidate', function () {
                var grid = $('#{$gridId}');
                var error = grid.siblings('.error');
                var checkedValue = grid.find('input:checked').val();

                if (checkedValue) {
                    $('#{$payerInputId}').val(checkedValue);
                    error.addClass('hidden');
                    return true;
                }

                error.removeClass('hidden');
                return false;
            });

            var setRadioClickHandler = function () {
                $('#{$gridId} input:radio').on('click', function () {
                    var error = $('#{$gridId}').siblings('.error');

                    if (!error.hasClass('hidden')) {
                        error.addClass('hidden');
                    }
                });
            };

            setRadioClickHandler();

            $(document).on('pjax:end', function () {
                setRadioClickHandler();
            });
JS
        );
    endif;
?>
