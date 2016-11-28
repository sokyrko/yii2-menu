<?php

use sokyrko\yii2menu\models\Menu;
use sokyrko\yii2menu\models\MenuItem;
use yii\db\Migration;

class m161124_141301_menu_module extends Migration
{
    public function safeUp()
    {
        $this->createTable(Menu::tableName(), [
            'id'   => $this->primaryKey()->unsigned(),
            'name' => $this->string(32),
        ]);

        $this->createTable(MenuItem::tableName(), [
            'id'        => $this->primaryKey()->unsigned(),
            'title'     => $this->string(64),
            'url'       => $this->string(128),
            'menu_id'   => $this->integer()->unsigned()->notNull(),
            'parent_id' => $this->integer()->unsigned()->defaultValue(null),
            'position'  => $this->integer()->unsigned()->defaultValue(0),
        ]);

        $this->createIndex('menu-name-idx', Menu::tableName(), 'name');
        $this->addForeignKey('menu_item-menu_id-menu-id-fk', MenuItem::tableName(), 'menu_id', Menu::tableName(), 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('menu_item-parent_id-menu_item-id', MenuItem::tableName(), 'parent_id', MenuItem::tableName(), 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('menu_item-menu_id-menu-id-fk', MenuItem::tableName());
        $this->dropForeignKey('menu_item-parent_id-menu_item-id', MenuItem::tableName());
        $this->dropTable(Menu::tableName());
        $this->dropTable(MenuItem::tableName());
    }
}
