<?php

class Pages_Create_Pages_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function ($table) {
            $table->increments('id');
            $table->string('name', 200);
            $table->string('slug', 200)->unique();
            $table->text('body');
            $table->boolean('published')->default(false);
            $table->integer('category_id')->unsigned()->nullable()->default(null);
            $table->integer('user_id')->unsigned()->nullable()->default(null);
            $table->timestamps();
            // Foreign Keys
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function ($table) {
            $table->drop_foreign('pages_category_id_foreign');
            $table->drop_foreign('pages_user_id_foreign');
            $table->drop_unique('pages_slug_unique');
        });
        Schema::drop('pages');
    }

}