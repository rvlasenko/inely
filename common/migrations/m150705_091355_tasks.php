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
            'listId'     => $this->integer(15),
            'author'     => $this->integer(50)->notNull(),
            'isDone'     => $this->integer(1),
            'priority'   => $this->integer(1),
            'dueDate'    => $this->date(),
            'updatedAt'  => $this->integer(),
            'createdAt'  => $this->integer()
        ], $tableOptions);

        $this->createTable('{{%projects}}', [
            'id'         => $this->primaryKey(),
            'userId'     => $this->integer(50),
            'listName'   => $this->string(100),
            'badgeColor' => $this->string(7)
        ], $tableOptions);

        $this->insert('{{%projects}}', [
            'id'         => 1,
            'userId'     => null,
            'listName'   => 'Работа',
            'badgeColor' => '#0074D9',
        ]);

        $this->insert('{{%projects}}', [
            'id'         => 2,
            'userId'     => null,
            'listName'   => 'Личное',
            'badgeColor' => '#7FDBFF',
        ]);

        if ($this->db->driverName === 'mysql') {
            $this->addForeignKey('fk_cat', '{{%tasks}}', 'list', '{{%projects}}', 'id', 'cascade', 'cascade');
            $this->addForeignKey('fk_author', '{{%tasks}}', 'author', '{{%user}}', 'id', 'cascade', 'cascade');
        }
    }

    public function down()
    {
        echo "m150705_091355_tasks cannot be reverted.\n";

        return false;
    }
}
