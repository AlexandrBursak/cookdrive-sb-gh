<?php
namespace app\models;

use dektrium\user\models\User as BaseProfile;
class User extends BaseProfile
{
	public function sendOrderMail($order) 
	{
	    $sum = 0;
		foreach($order as $key => $dish)
		    {
		      	$msg .= $dish['product_name'].' | ';
		    	$msg .= $dish['quantity'].' шт. |';
		    	$msg .= $dish['sum'].' грн.|<br>';
				$sum += $dish['sum'];
			}
		$msg .= 'Всего: '.$sum.'грн.';

		$this->sendMail('order', 'Ваш заказ принят.', ['Orders' => $msg, 'OrderDate' => date("Y:m:d")]);
	}

    public function sendMail($view, $subject, $params = []) {
        // Set layout params
        \Yii::$app->mailer->getView()->params['userName'] = $this->username;

        $result = \Yii::$app->mailer->compose([
            'html' => 'views/' . $view . '-html',
            'text' => 'views/' . $view . '-text',
        ], $params)->setTo([$this->email => $this->username])
            ->setSubject($subject)
            ->send();

        // Reset layout params
        \Yii::$app->mailer->getView()->params['userName'] = null;

        return $result;
    }
} 		