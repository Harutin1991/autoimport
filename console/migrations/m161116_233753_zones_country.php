<?php

use yii\db\Migration;

class m161116_233753_zones_country extends Migration
{
    public function up()
    {
        $tableSchema = Yii::$app->db->schema->getTableSchema('zone_countries');
        if ($tableSchema) {//drop table
            $this->dropTable('zone_countries');
        }
        $this->createTable('zone_countries', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer(11),
            'zone_id' => $this->integer(11),



        ]);
        $this->addForeignKey(
            'fk_zones_country',
            'zone_countries',
            'country_id',
            'countries',
            'id',
            'CASCADE'


        );
        $this->addForeignKey(
            'fk_zones_zone',
            'zone_countries',
            'zone_id',
            'zones',
            'id',
            'CASCADE'


        );
    }

    public function down()
    {
        echo "m161116_233753_zones_country cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
