<?php

namespace common\models;

use Yii;
use yii\base\Model;
use app\models\Unit;
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
            $check_users_status = Yii::$app->request->post('check_users_status');
            if (!$user || !$user->validatePassword($this->password)) {
                if($check_users_status==1){
                    $this->addError($attribute, 'คุณไม่มีสิทธิ์เข้าถึงระบบ เนื่องจากผู้ดูแลปิดสิทธิ์การเข้าใช้งานของคุณ');
                }else{
                    $this->addError($attribute, 'Incorrect username or password.');
                }

            }else{
                $query = User::find()
                ->select('id,role,name,user_group,unit_id,username')
                ->where("username = '".$this->username."' and password = '".md5($this->password)."'")->one();
                $unit = Unit::find()->select('unit_name')->where("unit_id = '".$query->unit_id."'")->one();
                $session = Yii::$app->session;
                $session->set('user_id', $query->id);
                $session->set('user_role', $query->role);
                $session->set('user_name', $query->name);
                $session->set('user_username', $query->username);
                $session->set('user_group', $query->user_group);
                $session->set('unit_id', $query->unit_id);

                $ip = $_SERVER['REMOTE_ADDR']; 
                $log_date = date("Y-m-d H:i:s");
                $create_date = date("Y-m-d");
                $command = Yii::$app->db->createCommand("INSERT INTO `user_log_usaged`(`username`, `log_date`, `remark`, `create_date`, `status`, `ip_address`,`user`,`unit`) VALUES ('" . $query->id . "','" . $log_date . "','','" . $create_date . "','1','".$ip."','".$query->name."','".$unit->unit_name."')")->execute();
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
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
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
