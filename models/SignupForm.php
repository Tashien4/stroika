<?php 
namespace app\models;
use yii\base\Model;
 
class SignupForm extends Model {
    
    public $login;
    public $password;
    public $role;
    
    public function rules() {
        return [
            [['login', 'password'], 'required', 'message' => 'Заполните поле'],
        //    ['role','string','max' => 2],
        ];
    }
    
    public function attributeLabels() {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
            'role' => 'Роль',
        ];
    }
    
}
?>