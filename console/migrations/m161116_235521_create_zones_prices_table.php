<?php

use yii\db\Migration;

/**
 * Handles the creation of table `zones_prices`.
 */
class m161116_235521_create_zones_prices_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    { $tableSchema = Yii::$app->db->schema->getTableSchema('zone_prices');
        if ($tableSchema) {//drop table
            $this->dropTable('zone_prices');
        }
        $this->createTable('zone_prices', [
            'id' => $this->primaryKey(),
            'zone_id' => $this->integer(11)->notNull(),
            'weight_from'=> $this->float()->notNull(),
            'weight_to'=> $this->float()->notNull(),
            'price' => $this->float()->notNull()
        ]);
        $this->addForeignKey(
            'fk_zones_price',
            'zone_prices',
            'zone_id',
            'zones',
            'id',
            'CASCADE'


        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('zone_prices');
    }
}
