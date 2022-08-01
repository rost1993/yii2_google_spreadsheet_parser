<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up() {
        $this->createTable('ma', [
            'id' => $this->primaryKey(),
            'category' => $this->string(255),
            'product' => $this->string(255),
            'january' => $this->double(10, 2),
            'february' => $this->double(10, 2),
            'march' => $this->double(10, 2),
            'april' => $this->double(10, 2),
            'may' => $this->double(10, 2),
            'june' => $this->double(10, 2),
            'july' => $this->double(10, 2),
            'august' => $this->double(10, 2),
            'september' => $this->double(10, 2),
            'october' => $this->double(10, 2),
            'november' => $this->double(10, 2),
            'december' => $this->double(10, 2),
            'total' => $this->double(10, 2),
            'comment' => $this->string(1000),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down() {
        $this->dropTable('ma');
    }
}
