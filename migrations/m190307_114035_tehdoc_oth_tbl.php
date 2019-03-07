<?php

use yii\db\Migration;

/**
 * Class m190307_114035_tehdoc_oth_tbl
 */
class m190307_114035_tehdoc_oth_tbl extends Migration
{

  const TABLE_NAME = '{{%teh_oth_tbl}}';

  public function up()
  {
    $tableOptions = null;
    if ($this->db->driverName === 'mysql') {
      $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    }
    $this->createTable(self::TABLE_NAME, [
        'id' => $this->primaryKey(),
        'eq_id' => $this->integer()->notNull(),
        'eq_oth_title' => $this->string(255),
        'valid' => $this->boolean()->defaultValue(1),
    ], $tableOptions);
  }

  public function down()
  {
    $this->dropTable(self::TABLE_NAME);
    return false;
  }

}
