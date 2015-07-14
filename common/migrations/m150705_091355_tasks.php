<?php

use yii\db\Schema;
use yii\db\Migration;

class m150705_091355_tasks extends Migration
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
            'category' => Schema::TYPE_INTEGER . '(15)',
            'author' => Schema::TYPE_INTEGER . '(100)',
            'isDone' => Schema::TYPE_INTEGER . '(1)',
            'priority' => Schema::TYPE_INTEGER . '(5) NULL',
            'time' => Schema::TYPE_STRING . '(15) NULL',
            'isDoneDate' => Schema::TYPE_STRING . '(15) NULL'
        ], $tableOptions);

        $this->insert('{{%tasks}}', [
            'id' => 1,
            'name' => 'Заполнить резюме с новым проектом и отправить',
            'category' => 1,
            'author' => 1,
            'isDone' => 0,
            'priority' => 3,
            'time' => ''
        ]);

        $this->insert('{{%tasks}}', [
            'id' => 2,
            'name' => 'Шарахнуть банхаммером по невменяемым юзерам',
            'category' => 1,
            'author' => 2,
            'isDone' => 0,
            'priority' => 4,
            'time' => ''
        ]);

        $this->insert('{{%tasks}}', [
            'id' => 3,
            'name' => 'Покинь 2ch, заведи тян, стань альфой',
            'category' => 3,
            'author' => 3,
            'isDone' => 1,
            'priority' => 2,
            'time' => ''
        ]);

        $this->createTable('{{%tasks_cat}}', [
            'id' => Schema::TYPE_PK,
            'userId' => Schema::TYPE_INTEGER . '(100) NULL',
            'name' => Schema::TYPE_STRING . '(100)',
            'badgeColor' => Schema::TYPE_STRING . '(7) NULL'
        ], $tableOptions);

        $this->insert('{{%tasks_cat}}', [
            'id' => 1,
            'name' => 'Работа',
            'userId' => 1,
            'badgeColor' => '#0074D9',
        ]);

        $this->insert('{{%tasks_cat}}', [
            'id' => 3,
            'name' => 'Семья',
            'userId' => 3,
            'badgeColor' => '#2ECC40',
        ]);

        $this->insert('{{%tasks_cat}}', [
            'id' => 2,
            'userId' => 2,
            'name' => 'Личное',
            'badgeColor' => '#7FDBFF',
        ]);

        if ($this->db->driverName === 'mysql') {
            $this->addForeignKey('fk_cat', '{{%tasks}}', 'category', '{{%tasks_cat}}', 'id', 'cascade', 'cascade');
        }
    }

    public function down()
    {
        echo "m150705_091355_tasks cannot be reverted.\n";

        return false;
    }
}
