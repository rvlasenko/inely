<?php

use yii\db\Migration;

class m150703_123000_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%achievements}}', [
            'id'              => $this->primaryKey(),
            'achievementName' => $this->string(250)->notNull(),
            'badgeSrc'        => $this->text()->notNull(),
            'description'     => $this->text(),
            'amountNeeded'    => $this->integer(11)->notNull(),
            'timePeriod'      => $this->integer(32)->notNull(),
            'status'          => $this->string()
        ], $tableOptions);

        $this->createTable('{{%levels}}', [
            'id'               => $this->primaryKey(),
            'levelName'        => $this->string(250),
            'experienceNeeded' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createTable('{{%users_ach}}', [
            'id'       => $this->primaryKey(),
            'userId'   => $this->integer(),
            'achID'    => $this->integer()->notNull(),
            'amount'   => $this->integer()->notNull(),
            'lastTime' => $this->integer()->notNull(),
            'status'   => $this->string()->notNull()
        ], $tableOptions);

        $this->createTable('{{%users_stats}}', [
            'id'         => $this->primaryKey(),
            'username'   => $this->string(250),
            'experience' => $this->integer(),
            'level'      => $this->integer()
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%achievements}}');
        $this->dropTable('{{%levels}}');
    }
}
