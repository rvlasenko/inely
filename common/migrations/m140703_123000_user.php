<?php

use common\models\User;
use yii\db\Migration;
use yii\db\Schema;

class m140703_123000_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id'                   => $this->primaryKey(),
            'username'             => $this->string(32),
            'auth_key'             => $this->string(32)->notNull(),
            'password_hash'        => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'email_confirm_token'  => $this->string(32)->notNull(),
            'oauth_client'         => $this->string(),
            'oauth_client_user_id' => $this->string(),
            'email'                => $this->string()->notNull(),
            'status'               => $this->smallInteger()->notNull()->defaultValue(User::STATUS_UNCONFIRMED),
            'created_at'           => $this->integer(),
            'updated_at'           => $this->integer(),
            'logged_at'            => $this->integer()
        ], $tableOptions);

        $this->insert('{{%user}}', [
            'id'            => 1,
            'username'      => 'hirootkit',
            'email'         => 'admiralexo@gmail.com',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('chosen'),
            'auth_key'      => Yii::$app->getSecurity()->generateRandomString(),
            'status'        => User::STATUS_UNCONFIRMED,
            'created_at'    => time(),
            'updated_at'    => time()
        ]);

        $this->createTable('{{%user_profile}}', [
            'user_id'        => $this->primaryKey(),
            'firstname'      => $this->string(),
            'lastname'       => $this->string(),
            'gender'         => $this->string(10),
            'locale'         => $this->string(12)->notNull(),
        ], $tableOptions);

        $this->insert('{{%user_profile}}', [
            'user_id'   => 1,
            'firstname' => 'Roman',
            'lastname'  => 'Vlasenko'
        ]);

        if ($this->db->driverName === 'mysql') {
            $this->addForeignKey('fk_user', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');
        }

    }

    public function down()
    {
        if ($this->db->driverName === 'mysql') {
            $this->dropForeignKey('fk_user', '{{%user_profile}}');
        }
        $this->dropTable('{{%user_profile}}');
        $this->dropTable('{{%user}}');
    }
}
