<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\VarDumper;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return[
            [['username','password','password_repeat'], 'required'],
            [['username', 'password','password_repeat'], 'string' , 'min' => 5, 'max' => 255],
            ['password_repeat', 'compare', 'compareAttribute' => 'password']
        ];
    }

    public function signup()
    {
        $gebruiker = new Accounts();
        $gebruiker->username = $this->username;
        $gebruiker->password = \Yii::$app->security->generatePasswordHash($this->password);
        $gebruiker->authKey = \Yii::$app->security->generateRandomString();
        $gebruiker->accessToken = \Yii::$app->security->generateRandomString();

        if ($gebruiker->save())
        {
            return true;
        }
        \Yii::error("Gebruiker is niet opgeslagen". VarDumper::dumpAsString($gebruiker->errors));
        return false;
    }
}