<?php

namespace app\models;

use Yii;
use yii\base\Model;
use \yii\helpers\VarDumper;

/**
 * ContactForm is the model behind the contact form.
 */
class RegisterForm extends Model
{
    public $name;
    public $surname;
    public $patronymic;
    public $email;
    public $login;
    public $password;
    public $password_repeat;
    public $rules;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'email', 'login', 'password', 'password_repeat', 'rules'], 'required'],
            [['name', 'surname', 'patronymic', 'email', 'login', 'password', 'password_repeat'], 'string', 'max' => 255],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            // [['email'], 'unique'],
            
            //[['surname','name'], 'unique', 'targetAttribute' => ['name','surname']],  
        ];
    }
    
    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function registerUser()
    {
        if ($this->validate()) {
            $user = new User();
            if($user->load($this->attributes, '')){
                /* VarDumper::dump($user->attributes, 10, true); die; */

                if(!$user->save(false)){
                    VarDumper::dump($user->errors); die;
                };
            }

        } else{
            VarDumper::dump($this->errors); die;
        }
        return $user ? $user : false;
    }
}
