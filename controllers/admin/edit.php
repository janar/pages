<?php

use Pages\Models\Category;
use Pages\Models\Page;

/**
 * Edit pages
 */
class Pages_Admin_Edit_Controller extends Pages_Admin_Base_Controller {

    /**
     * Page edit form
     *
     * @param int $id
     */
    public function get_index()
    {
        $id = Input::get('id');
        $this->data['categories'] = \Pages\Category::to_indented_list_recursive(null);
        $this->data['page'] = Page::with('category')->find($id);
        if (is_null($this->data['page'])) {
            return Response::error('404');
        }
        return View::make('pages::admin.edit.index', $this->data);
    }

    /**
     * Process edit form submission
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
            return Redirect::to(URL::full())->with_errors($validation)
                ->with_input();
        } else {
            // Validation passed. Update page
            $page = Page::with('category')->find(Input::get('id'));
            // Check if page is valid
            if (is_null($page)) {
                return redirect::to(URL::full())
                    ->with('error', 'Invalid page specified');
            }
            // Now update page
            if ($page->name !== Input::get('name')) {
                $page->name = Input::get('name');
                $page->slug = Str::slug(Input::get('name'));
            }
            $page->body = Input::get('body');
            $page->category_id = Input::get('category');
            $page->published = (is_null(Input::get('published')) ? 0 : 1);
            $update = $page->save();
            // Check if update was successful
            if ($update) {
                return Redirect::to_action('admin::pages')
                    ->with('success', 'Successfully updated page: '
                           . Input::get('name'));
            } else {
                return redirect::to(URL::full())
                    ->with('error', 'Unable to update page');
            }
        }
    }

}
