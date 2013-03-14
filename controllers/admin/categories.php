<?php

use Pages\Models\Category;

/**
 * Category methods for Pages bundle
 */
class Pages_Admin_Categories_Controller extends Pages_Admin_Base_Controller {

    /**
     * Category management landing
     */
    public function get_index()
    {
        $this->data['search'] = true;
        $this->data['q'] = trim(strip_tags(urldecode(Input::get('q'))));
        $this->data['categories'] = Category::with('parent')
            ->where('name', 'LIKE', '%' . $this->data['q'] . '%')
            ->order_by('parent_id', 'asc')
            ->paginate(10);
        return View::make('pages::admin.category.index', $this->data);
    }

    /**
     * Category creation form
     */
    public function get_create()
    {
        $this->data['categories'] = \Pages\Category::to_indented_list_recursive(null);
        return View::make('pages::admin.category.create', $this->data);
    }

    /**
     * Handles POST from category creation form
     */
    public function post_create()
    {
        // Validation rules
        $rules = array(
            'name' => 'required|max:100',
            );
        // Prepare validation
        $validation = Validator::make(Input::all(), $rules);
        // Run validation
        if($validation->fails()) {
            return Redirect::to(URL::current())->with_errors($validation)
                ->with_input();
        } else {
            // Validation passed. Create page
            $category = new Category(array(
                                 'name' => Input::get('name'),
                                 'slug' => Str::slug(Input::get('name')),
                                 'published' => (is_null(Input::get('published')) ? 0 : 1),
                                         ));
            if (strlen(Input::get('parent')) > 0) {
                $parent = Category::find(Input::get('parent'));
                $insert = $parent->children()->insert($category);
            } else {
                $insert = $category->save();
            }
            if ($insert) {
                return Redirect::to_action('admin::pages.categories')
                    ->with('success', 'Successfully created category: '
                           . Input::get('name'));
            } else {
                return redirect::to(URL::current())
                    ->with('error', 'Unable to create category');
            }
        }
    }

    /**
     * Categories edit form
     */
    public function get_edit()
    {
        $id = Input::get('id');
        $this->data['categories'] = \Pages\Category::to_indented_list_recursive(null);
        $this->data['category'] = Category::with('parent')->find($id);
        if (is_null($this->data['category'])) {
            return Response::error('404');
        }
        return View::make('pages::admin.category.edit', $this->data);
    }

    /**
     * Process Category edit form submission
     */
    public function post_edit()
    {
        // Validation rules
        $rules = array(
            'name' => 'required|max:100',
            );
        // Prepare validation
        $validation = Validator::make(Input::all(), $rules);
        // Run validation
        if($validation->fails()) {
            return Redirect::to(URL::full())->with_errors($validation)
                ->with_input();
        } else {
            // Validation passed. Update category
            $category = Category::with('parent')->find(Input::get('id'));
            // Check if category is valid
            if (is_null($category)) {
                return redirect::to(URL::full())
                    ->with('error', 'Invalid category specified');
            }
            // Now update category
            if ($category->name !== Input::get('name')) {
                $category->name = Input::get('name');
                $category->slug = Str::slug(Input::get('name'));
            }
            $category->parent_id = (Input::get('parent') === '') ? null : Input::get('parent');
            $category->published = (is_null(Input::get('published')) ? 0 : 1);
            $update = $category->save();
            // Check if update was successful
            if ($update) {
                return Redirect::to_action('admin::pages/categories')
                    ->with('success', 'Successfully updated category: '
                           . Input::get('name'));
            } else {
                return redirect::to(URL::full())
                    ->with('error', 'Unable to update category');
            }
        }
    }
}
