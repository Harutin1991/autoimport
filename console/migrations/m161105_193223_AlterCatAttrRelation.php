<?php

use yii\db\Migration;

class m161105_193223_AlterCatAttrRelation extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `attribute` DROP FOREIGN KEY `fk_attr_category_id`; ALTER TABLE `attribute` ADD CONSTRAINT `fk_attr_category_id` FOREIGN KEY (`category_id`) REFERENCES `odenssnus`.`category`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;";
        $this->execute($sql);
        $sql = "ALTER TABLE `tr_brand` DROP FOREIGN KEY `fk_brand_brand_id`; ALTER TABLE `tr_brand` ADD CONSTRAINT `fk_brand_brand_id` FOREIGN KEY (`brand_id`) REFERENCES `odenssnus`.`brand`(`id`) ON DELETE CASCADE ON UPDATE CASCADE; ALTER TABLE `tr_brand` DROP FOREIGN KEY `fk_brand_language_id`; ALTER TABLE `tr_brand` ADD CONSTRAINT `fk_brand_language_id` FOREIGN KEY (`language_id`) REFERENCES `odenssnus`.`language`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;";
        $this->execute($sql);
    }

    public function down()
    {
        echo "m161105_193223_AlterCatAttrRelation cannot be reverted.\n";

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
