<?php

use Pages\Models\Category;
use Pages\Models\Page;

/**
 * Create pages
 */
class Pages_Admin_Create_Controller extends Pages_Admin_Base_Controller {

    /**
     * Page creation form
     */
    public function get_index()
    {
        $this->data['categories'] = \Pages\Category::to_indented_list_recursive(null);
        return View::make('pages::admin.create.index', $this->data);
    }

    /**
     * Handles POST from page creation form
     */
    public function post_index()
    {
        // Validation rules
        $rules = array(
            'name' => 'required|max:100',
            'body' => 'required',
            );
        // Prepare validation
        $validation = Validator::make(Input::all(), $rules);
        // Run validation
        if($validation->fails()) {
            return Redirect::to(URL::current())->with_errors($validation)
                ->with_input();
        } else {
            // Validation passed. Create page
            $page = new Page(array(
                                 'name' => Input::get('name'),
                                 'slug' => Str::slug(Input::get('name')),
                                 'body' => Input::get('body'),
                                 'published' => (is_null(Input::get('published')) ? 0 : 1),
                                 ));
            if (strlen(Input::get('category')) > 0) {
                $category = Category::find(Input::get('category'));
                $insert = $category->pages()->insert($page);
            } else {
                $insert = $page->save();
            }
            if ($insert) {
                return Redirect::to_action('admin::pages')
                    ->with('success', 'Successfully created page: '
                           . Input::get('name'));
            } else {
                return redirect::to(URL::current())
                    ->with('error', 'Unable to create page');
            }
        }
    }

}