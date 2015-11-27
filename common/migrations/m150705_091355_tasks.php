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
            'ownerId'      => $this->integer(50)->notNull(),
            'taskPriority' => $this->smallInteger(4),
            'dueDate'      => $this->date(),
            'isDone'       => $this->smallInteger(4),
            'updatedAt'    => $this->integer(),
            'createdAt'    => $this->integer(),
            'assignedTo'   => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%projects}}', [
            'id'         => $this->primaryKey(),
            'ownerId'    => $this->integer(50),
            'assignedTo' => $this->integer(),
            'listName'   => $this->string(100),
            'badgeColor' => $this->string(7)
        ], $tableOptions);

        if ($this->db->driverName === 'mysql') {
            $this->addForeignKey('fk_cat', '{{%user}}', 'id', '{{%tasks}}', 'ownerId', 'cascade', 'cascade');
            $this->addForeignKey('fk_data', '{{%tasks}}', 'taskId', '{{%task_data}}', 'dataId', 'cascade', 'cascade');
        }
    }

    public function down()
    {
        echo "m150705_091355_tasks cannot be reverted.\n";

        return false;
    }
}
