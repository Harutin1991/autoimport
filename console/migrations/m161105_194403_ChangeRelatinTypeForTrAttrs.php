<?php

use yii\db\Migration;

class m161105_194403_ChangeRelatinTypeForTrAttrs extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `tr_attribute` DROP FOREIGN KEY `fk_attr_attribute_id`; ALTER TABLE `tr_attribute` ADD CONSTRAINT `fk_attr_attribute_id` FOREIGN KEY (`attribute_id`) REFERENCES `odenssnus`.`attribute`(`id`) ON DELETE CASCADE ON UPDATE CASCADE; ALTER TABLE `tr_attribute` DROP FOREIGN KEY `fk_attr_language_id`; ALTER TABLE `tr_attribute` ADD CONSTRAINT `fk_attr_language_id` FOREIGN KEY (`language_id`) REFERENCES `odenssnus`.`language`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;";
        $this->execute($sql);
        $sql = "ALTER TABLE `tr_category` DROP FOREIGN KEY `fk_cat_category_id`; ALTER TABLE `tr_category` ADD CONSTRAINT `fk_cat_category_id` FOREIGN KEY (`category_id`) REFERENCES `odenssnus`.`category`(`id`) ON DELETE CASCADE ON UPDATE CASCADE; ALTER TABLE `tr_category` DROP FOREIGN KEY `fk_cat_language_id`; ALTER TABLE `tr_category` ADD CONSTRAINT `fk_cat_language_id` FOREIGN KEY (`language_id`) REFERENCES `odenssnus`.`language`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;";
        $this->execute($sql);
        $sql = "ALTER TABLE `tr_product` DROP FOREIGN KEY `fk_lan_language_id`; ALTER TABLE `tr_product` ADD CONSTRAINT `fk_lan_language_id` FOREIGN KEY (`language_id`) REFERENCES `odenssnus`.`language`(`id`) ON DELETE CASCADE ON UPDATE CASCADE; ALTER TABLE `tr_product` DROP FOREIGN KEY `fk_pr_product_id`; ALTER TABLE `tr_product` ADD CONSTRAINT `fk_pr_product_id` FOREIGN KEY (`product_id`) REFERENCES `odenssnus`.`product`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;";
        $this->execute($sql);
    }

    public function down()
    {
        echo "m161105_194403_ChangeRelatinTypeForTrAttrs cannot be reverted.\n";

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
