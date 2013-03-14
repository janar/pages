<?php

/**
 * Migration for categories table
 */
class Pages_Create_Categories_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function ($table) {
            $table->increments('id');
            $table->string('name', 200)->unique();
            $table->string('slug', 200)->unique();
            $table->boolean('published')->default(false);
            $table->integer('parent_id')->unsigned()->nullable()->default(null);
            $table->timestamps();
            // Foreign Keys
            $table->foreign('parent_id')->references('id')->on('categories');
        });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function ($table) {
            $table->drop_foreign('categories_parent_id_foreign');
            $table->drop_unique('categories_slug_unique');
            $table->drop_unique('categories_name_unique');
        });
        Schema::drop('categories');
    }

}