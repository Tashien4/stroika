<?php
 
namespace app\models;
 
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{

public $user = false;
private $_user = false;
public $rememberMe = true;
    public static function tableName()
    {
        return 'users';
    }
    public function rules()
    {
        return [
            [['login'], 'required', 'message' => 'Заполните поле'],
           // [['login', 'password'], 'required', 'message' => 'Заполните поле'],
         //   ['password', 'validatePassword'],
        ];
    }
    public function attributeLabels() {
        return [
            'username' => 'Имя пользователя',
            'login' => 'Логин',
            'password' => 'Пароль',
            'role' => 'Роль',
        ];
    }

public function validatePassword($password)
    {
            echo $password;
         //   return Yii::$app->security->validatePassword($password, $this->password);
    }
    
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    public static function getRole($id)
    {
        $mod=static::findOne(['id' => $id]);
        return $mod->role;
    }
    public static function findByLogin($login)
    {
        return static::findOne(['login' => $login]);
    }
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return;// $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return null;
    }
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByLogin($this->login);
        }

        return $this->_user;
    }

}