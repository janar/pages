<?php

/**
 * Migration for sorting information columns to categories table
 */
class Pages_Update_Categories_Table_1 {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up() {
        Schema::table('categories', function($table)
        {
            $table->string('order_by_column')->nullable()->default('created_at');
            $table->string('order_by_direction')->nullable()->default('desc');
        });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function ($table)
        {
            $table->drop_column('order_by_column');
            $table->drop_column('order_by_direction');
        });
    }

}
