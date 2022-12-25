<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $patronymic
 * @property string $email
 * @property string $login
 * @property string $password
 * @property int $role_id
 * @property string $auth_key
 */

class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'email', 'login', 'password', 'role_id', 'auth_key'], 'required'],
            [['role_id'], 'integer'],
            [['name', 'surname', 'patronymic', 'email', 'login', 'password', 'auth_key'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['login'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'patronymic' => 'Patronymic',
            'email' => 'Email',
            'login' => 'Login',
            'password' => 'Password',
            'role_id' => 'Role ID',
            'auth_key' => 'Auth Key',
        ];
    }

    public function getOrders(){
        return $this->hasMany(Role::class(), ['user_id' => 'id']);
    }

    public function getRole()
    {
        return $this->hasOne(Role::class(), ['id' => 'role_id']);
    }
     public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
                $this->role_id = Role::getRoleId('user');
            }
            return true;
        }
        return false;
    }

    
    public static function findByUsername($login){
        return static::findOne(['login' => $login]);
    }

    public function validatePassword($password){
        return Yii::$app->security->validatePassword($password, $this->password);
    }

}
