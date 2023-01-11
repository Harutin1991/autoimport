<?php

use yii\db\Migration;

class m161111_092342_add_default_package_to_product_package extends Migration
{
    public function up()
    {
        $this->addColumn('product_package', 'default_package', $this->smallInteger(1)->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('product_package', 'default_package');
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
