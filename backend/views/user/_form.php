<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->input('text', ['disabled' => true]) ?>

    <?= $form->field($model, 'email')->input('email', ['disabled' => true]) ?>

    <?= $form->field($model, 'role')->dropDownList($model->getRoles(), ['value' => $model->getRole()]) ?>

    <?= $form->field($model, 'status')->input('text', ['disabled' => true, 'value' => $model->getStatusLabel($model->status)]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
