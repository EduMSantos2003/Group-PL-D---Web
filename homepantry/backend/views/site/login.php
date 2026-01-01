<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Login';
$this->registerCssFile('@web/css/login.css');   // importa o CSS externo
?>

<div class="login-card">

    <div class="login-header">Sign in</div>

    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <!-- Campo Username -->
    <div style="position: relative;">
        <?= $form->field($model, 'username')
            ->textInput([
                'placeholder' => 'Email',
                'class' => 'form-control login-input'
            ])
            ->label(false) ?>
    </div>

    <!-- Campo Password -->
    <div style="position: relative; margin-top: 20px;">
        <?= $form->field($model, 'password')
            ->passwordInput([
                'placeholder' => 'Password',
                'class' => 'form-control login-input'
            ])
            ->label(false) ?>
    </div>


    <!-- Botão login -->
    <?= Html::submitButton('LOGIN', [
        'class' => 'btn btn-login',
        'name' => 'login-button'
    ]) ?>

    <?php ActiveForm::end(); ?>

    <div class="small-links">
        <a href="http://localhost/Group-PL-D---Web/homepantry/frontend/web/index.php?r=site%2Fsignup">Register new account</a>
    </div>

</div>

<!-- Ícones FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
