<?php
/**
 * Created by PhpStorm.
 * User: MyBe
 * Date: 23.01.2017
 * Time: 15:40
 */

namespace app\controllers;
use dektrium\user\controllers\RegistrationController as BaseRegistrationController;
use dektrium\user\models\Profile;
use dektrium\user\models\User;
use yii\web\NotFoundHttpException;


class RegistrationController extends  BaseRegistrationController
{

    public function actionConnect($code)
    {
        $account = $this->finder->findAccount()->byCode($code)->one();

        if ($account === null || $account->getIsConnected()) {
            throw new NotFoundHttpException();
        }

        /** @var User $user */
        $user = \Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'connect',
            'username' => $account->username,
            'email'    => $account->email,
        ]);
        
        $event = $this->getConnectEvent($account, $user);

        $this->trigger(self::EVENT_BEFORE_CONNECT, $event);

        $account_json = json_decode($account->data, true);


        $profile = \Yii::createObject([
            'class' => Profile::className(),
            'name' => $account_json['name']['familyName'] . ' ' . $account_json['name']['givenName'],
            'public_email' => $account->email,
            'gravatar_email' => $account->email,
            'website' => isset($account_json['url'])?$account_json['url']:'',
            'photo_url' => isset($account_json['image']['url'])?substr($account_json['image']['url'],0, -6):'',
        ]);

        $user->profile = $profile;
        
        if ($user->load(\Yii::$app->request->post()) && $user->create()) {

            $account->connect($user);
            $this->trigger(self::EVENT_AFTER_CONNECT, $event);

            \Yii::$app->user->login($user, $this->module->rememberFor);

            return $this->goBack();
        }

        return $this->render('connect', [
            'model'   => $user,
            'account' => $account,
        ]);
    }

}