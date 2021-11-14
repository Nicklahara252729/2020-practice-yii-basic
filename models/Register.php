<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "register".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password
 * @property string|null $email
 * @property string|null $accesstoken
 * @property string|null $auth
 */
class Register extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface    
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'register';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', ], 'string', 'max' => 80],
            [[ 'password','accesstoken', 'authkey'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
        ];
    }

    public static function findIdentity($id){
        return self::findOne($id);
    }

    public static function  findIdentityByAccessToken($token, $type=null){
        return self::findOne(['accesstoken'=>$token]);
    }

    public static function findByUsername($username){
        return self::findOne(['username'=>$username]);
    }

    public function getId(){
        return $this->id;
    }

    public function getAuthKey(){
        return $this->authkey === $auth;
    }

    public function validatePassword($password){
        return password_verify($password, $this->password);
    }

    public function validateAuthKey($auth){
        return $this->authkey===$auth;
    }


}
