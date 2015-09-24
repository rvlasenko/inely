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

        $this->createTable('{{%tasks_data}}', [
            'dataId' => $this->primaryKey(),
            'lft'    => $this->integer(15),
            'rgt'    => $this->integer(15),
            'lvl'    => $this->integer(15),
            'pid'    => $this->integer(15),
            'pos'    => $this->integer(15),
            'name'   => $this->string(255)
        ], $tableOptions);

        if ($this->db->driverName === 'mysql') {
            $this->addForeignKey('fk_data', '{{%tasks_data}}', 'dataId', '{{%tasks}}', 'id', 'cascade', 'cascade');
        }
    }

    public function down()
    {
        echo "m150920_140218_tasks_data cannot be reverted.\n";

        return false;
    }
}
