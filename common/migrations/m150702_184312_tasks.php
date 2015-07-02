<?php

use yii\db\Schema;
use yii\db\Migration;

class m150702_184312_tasks extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tasks}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(255) NULL',
            'category' => Schema::TYPE_INTEGER . '(1)',
            'author' => Schema::TYPE_INTEGER . '(1)',
            'is_done' => Schema::TYPE_INTEGER . '(1)',
            'priority' => Schema::TYPE_STRING . '(12) NULL',
            'time' => Schema::TYPE_STRING . '(15) NULL',
            'is_done_date' => Schema::TYPE_STRING . '(3) NULL'
        ], $tableOptions);

        $this->insert('{{%tasks}}', [
            'id' => 1,
            'name' => 'Заполнить резюме и отправить работодателю',
            'category' => 1,
            'author' => 1,
            'is_done' => 0,
            'priority' => 'medium',
            'time' => '12/08 11:43'
        ]);

        $this->createTable('{{%tasks_cat}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(255) NULL'
        ], $tableOptions);

        $this->insert('{{%tasks_cat}}', [
            'id' => 1,
            'name' => 'Работа'
        ]);

        if ($this->db->driverName === 'mysql') {
            $this->addForeignKey('fk_cat', '{{%tasks_cat}}', 'id', '{{%tasks}}', 'id', 'cascade', 'cascade');
        }
    }

    public function down()
    {
        echo "m150702_184312_tasks cannot be reverted.\n";

        return false;
    }
}
