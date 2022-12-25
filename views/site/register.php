<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\widgets\Pjax;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
         <div class="col-lg-5">
            <?php Pjax::begin([
                'options' => ['data-pjax' => true]
            ]); ?>

            <?php $timeout=5000; ?>
                <?php $enableReplaceState = false ?>
                <?php $enablePushState = false ?>
                <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>
                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                    <?= $form->field($model, 'surname')->textInput(['autofocus' => true]) ?>
                    <?= $form->field($model, 'patronymic')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'login') ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                    <?= $form->field($model, 'rules')->checkbox() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'register-btn']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            <?php Pjax::end(); ?>
         </div>
    </div>
</div>
