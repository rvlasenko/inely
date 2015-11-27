<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\base\ErrorException;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * Name, email and body are required
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'email', 'body'], 'required'],
            ['name', 'string', 'max' => 25],
            ['email', 'string', 'max' => 50],
            ['body', 'string'],
            ['subject', 'default', 'value' => 'Обращение']
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string $email the target email address
     *
     * @return boolean whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            try {
                return Yii::$app->mailer->compose()
                                        ->setTo($email)
                                        ->setFrom(getenv('ROBOT_EMAIL'))
                                        ->setReplyTo([$this->email => $this->name])
                                        ->setSubject($this->subject)
                                        ->setTextBody($this->body)
                                        ->send();
            } catch (ErrorException $e) {
                Yii::warning(Yii::t('frontend', 'Something went wrong. We apologize.'));
            }
        } else {
            return false;
        }
    }
}
