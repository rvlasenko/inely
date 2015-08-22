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
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'category' => $this->integer(15),
            'author' => $this->integer(50)->notNull(),
            'isDone' => $this->integer(1),
            'priority' => $this->integer(5),
            'time' => $this->string(15),
            'isDoneDate' => $this->string(15),
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
            'name' => 'Покинь борды, стань альфой',
            'category' => 3,
            'author' => 3,
            'isDone' => 1,
            'priority' => 2,
            'time' => ''
        ]);

        $this->createTable('{{%tasks_cat}}', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer(100),
            'name' => $this->string(100),
            'badgeColor' => $this->string(7)
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
