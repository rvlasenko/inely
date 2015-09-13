<?php

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
            'id'         => $this->primaryKey(),
            'name'       => $this->string()->notNull(),
            'note'       => $this->text(),
            'list'       => $this->integer(15),
            'author'     => $this->integer(50)->notNull(),
            'isDone'     => $this->integer(1),
            'priority'   => $this->integer(1),
            'time'       => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);

        $this->insert('{{%tasks}}', [
            'id'       => 1,
            'name'     => 'Заполнить резюме с новым проектом и отправить',
            'list'     => 1,
            'author'   => 1,
            'isDone'   => 0,
            'priority' => 1,
            'time'     => null
        ]);

        $this->insert('{{%tasks}}', [
            'id'       => 2,
            'name'     => 'Шарахнуть банхаммером по невменяемым юзерам',
            'list'     => 1,
            'author'   => 2,
            'isDone'   => 0,
            'priority' => 0,
            'time'     => null
        ]);

        $this->createTable('{{%tasks_cat}}', [
            'id'         => $this->primaryKey(),
            'userId'     => $this->integer(100),
            'listName'   => $this->string(100),
            'badgeColor' => $this->string(7)
        ], $tableOptions);

        $this->insert('{{%tasks_cat}}', [
            'id'         => 1,
            'userId'     => null,
            'listName'   => 'Работа',
            'badgeColor' => '#0074D9',
        ]);

        $this->insert('{{%tasks_cat}}', [
            'id'         => 2,
            'userId'     => null,
            'listName'   => 'Личное',
            'badgeColor' => '#7FDBFF',
        ]);

        if ($this->db->driverName === 'mysql') {
            $this->addForeignKey('fk_cat', '{{%tasks}}', 'list', '{{%tasks_cat}}', 'id', 'cascade', 'cascade');
        }
    }

    public function down()
    {
        echo "m150705_091355_tasks cannot be reverted.\n";

        return false;
    }
}
