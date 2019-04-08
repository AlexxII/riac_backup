<?php

use yii\db\Migration;

class m181203_075833_vks_type_tbl extends Migration
{
  const TABLE_NAME = '{{%vks_types_tbl}}';

  public function up()
  {
    $tableOptions = null;
    if ($this->db->driverName === 'mysql') {
      $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
    }
    $this->createTable(self::TABLE_NAME, [
      'id' => $this->binary(16)->notNull(),
      'root' => $this->binary(16),
      'lft' => $this->integer()->notNull(),
      'rgt' => $this->integer()->notNull(),
      'lvl' => $this->smallInteger(5)->notNull(),
      'name' => $this->string(120)->notNull(),
      'parent_id' => $this->integer(),
      'valid' => $this->boolean()->defaultValue(1),
      'del_reason' => $this->string(255)
    ], $tableOptions);

//    $this->addPrimaryKey('id', self::TABLE_NAME, 'id');

//    $defaultId = ;
//    $sql = 'INSERT INTO ' . self::TABLE_NAME . ' (id, root, lft, rgt, lvl, name, parent_id)
//                VALUES (' . $defaultId . ', ' . $defaultId . ', 1, 2, 0, "Тип ВКС", ' . $defaultId . ')';
//    \Yii::$app->db->createCommand($sql)->execute();
  }

  public function down()
  {
    $this->dropTable(self::TABLE_NAME);
    return false;
  }
}
