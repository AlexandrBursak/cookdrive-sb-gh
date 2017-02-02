<?php
/**
 * Created by PhpStorm.
<<<<<<< HEAD
 * User: zlemore
 * Date: 24.01.17
 * Time: 15:24
=======
 * User: MyBe
 * Date: 20.01.2017
 * Time: 0:27
>>>>>>> Igor
 */

namespace app\models;

use yii\db\ActiveRecord;

class History extends ActiveRecord
{

    public function myBalance($user_id)
    {

        $data = History::find()->where(['users_id' => \Yii::$app->user->id])->sum('summa');
        if(!$data) {
            return 0;
        }
        return $data;

    }

}