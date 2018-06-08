<?php

namespace frontend\modules\api\v1\models;

use frontend\modules\api\v1\resources\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;

    private $user = false;
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('frontend', 'Email'),
            'password' => Yii::t('frontend', 'Password'),
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', Yii::t('frontend', 'Incorrect email or password.'));
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user === false) {
            $this->user = User::find()
                ->active()
                ->andWhere(['email' => $this->email])
                ->limit(1)
                ->one();
        }

        return $this->user;
    }

}
