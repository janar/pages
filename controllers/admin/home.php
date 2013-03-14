<?php

use Pages\Models\Page;

/**
 * Extension for Pages bundle
 */
class Pages_Admin_Home_Controller extends Pages_Admin_Base_Controller {

    /**
     * User management landing
     */
    public function get_index()
    {
        $this->data['search'] = true;
        $this->data['q'] = trim(strip_tags(urldecode(Input::get('q'))));
        $this->data['pages'] = Page::with('category')
            ->where('name', 'LIKE', '%' . $this->data['q'] . '%')
            ->order_by('created_at', 'desc')
            ->paginate(10);
        return View::make('pages::admin.home.index', $this->data);
    }

}