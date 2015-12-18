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

class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * Имя, email и тело письма обязательны
     * @return array правила валидации.
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
     * Отправка email на указанную электронную почту используя информацию, полученной этой моделью.
     *
     * @param string $email целевой адрес email.
     *
     * @return boolean если модель проходит валидацию.
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
