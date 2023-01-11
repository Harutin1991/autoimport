<?php

use yii\db\Migration;

class m160809_183518_drop_fk_pr_img_prod_id extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_pr_img_prod_id','product_image');
    }

    public function down()
    {
        $this->addForeignKey('fk_pr_img_prod_id','product_image','product_id','product','id');
    }

}
