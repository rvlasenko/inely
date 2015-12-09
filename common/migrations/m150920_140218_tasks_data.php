<?php

use yii\db\Migration;

class m150920_140218_tasks_data extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%task_data}}', [
            'dataId' => $this->primaryKey(),
            'lft'    => $this->integer(15),
            'rgt'    => $this->integer(15),
            'lvl'    => $this->integer(15),
            'pid'    => $this->integer(15),
            'name'   => $this->string(255),
            'note'   => $this->string(255)
        ], $tableOptions);

        $this->createTable('{{%task_comments}}', [
            'commentId'  => $this->primaryKey(),
            'taskId'     => $this->integer(),
            'userId'     => $this->integer(),
            'comment'    => $this->text(),
            'timePosted' => $this->date()
        ], $tableOptions);

        if ($this->db->driverName === 'mysql') {
            $this->addForeignKey('fk_comm', '{{%task_comments}}', 'taskId', '{{%tasks}}', 'taskId', 'cascade', 'cascade');
        }
    }

    public function down()
    {
        if ($this->db->driverName === 'mysql') {
            $this->dropForeignKey('fk_comm', '{{%task_comments}}');
        }
        $this->dropTable('{{%task_data}}');
        $this->dropTable('{{%task_comments}}');
    }
}
