<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->getUser();
        if (!$user) {
            return false;
        }

        // 👇 FILTRO ESPECÍFICO PARA O BACKEND
        if (Yii::$app->id === 'app-backend') {
            $auth = Yii::$app->authManager;
            $roles = $auth->getRolesByUser($user->id);

            // só deixam passar admin ou gestorCasa
            if (!isset($roles['admin']) && !isset($roles['gestorCasa'])) {
                $this->addError('username', 'Não tens acesso ao backoffice.');
                return false;
            }
        }

        // se passou nas validações todas, faz login normal
        return Yii::$app->user->login(
            $user,
            $this->rememberMe ? 3600 * 24 * 30 : 0
        );
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
