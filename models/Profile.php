<?php
/**
 * Created by PhpStorm.
 * User: MyBe
 * Date: 23.01.2017
 * Time: 20:46
 */

namespace app\models;


use yii\base\Model;

class ProfileForm extends Model
{
    public $user_id;
    public $name;
    public $public_email;
    public $gravatar_email;
    public $gravatar_id;
    public $location;
    public $website;
    public $bio;
    public $timezone;
    public $user;

    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name'], 'required'],
            // email has to be a valid email address
            ['gravatar_email', 'email'],
            // verifyCode needs to be entered correctly
            ['website', 'string'],
        ];
    }

}