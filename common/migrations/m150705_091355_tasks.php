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
            'taskId'       => $this->primaryKey(),
            'listId'       => $this->integer(15),
            'userId'       => $this->integer(50)->notNull(),
            'taskPriority' => $this->smallInteger(4),
            'dueDate'      => $this->date(),
            'isDone'       => $this->smallInteger(4),
            'updatedAt'    => $this->integer(),
            'createdAt'    => $this->integer()
        ], $tableOptions);

        $this->createTable('{{%projects}}', [
            'id'         => $this->primaryKey(),
            'userId'     => $this->integer(50),
            'listName'   => $this->string(100),
            'lft'        => $this->integer(15),
            'rgt'        => $this->integer(15),
            'lvl'        => $this->integer(15),
            'badgeColor' => $this->string(7)
        ], $tableOptions);

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
