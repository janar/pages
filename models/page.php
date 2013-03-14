<?php namespace Pages\Models;

/**
 * Page model
 */
class Page extends \Eloquent {

    /**
     * Enable timestamps
     */
    public static $timestamps = true;

    /**
     * Each page can have one category or have null
     */
    public function category()
    {
        return $this->belongs_to('Pages\Models\Category');
    }

    /**
     * Each page can have one user
     */
    public function user()
    {
        return $this->has_one('Admin\Models\User', 'id');
    }

    /**
     * Set slug
     */
    public function set_slug($slug)
    {
        $new_slug = $slug;
        $slug_rows = Page::where('slug', 'LIKE', $slug . '%')
            ->order_by('slug', 'asc')
            ->get();
        if (count($slug_rows) > 0) {
            $slugs_values = array();
            foreach ($slug_rows as $row) {
                $slugs_values[] = $row->slug;
            }
            $last_slug = array_reverse(explode('-', array_pop($slugs_values)));
            if ((int) $last_slug[0] !== 0) {
                $new_slug = $slug . '-' . (((int) $last_slug[0]) + 1);
            } else {
                $new_slug = $slug . '-1';
            }
        }
        $this->set_attribute('slug', $new_slug);
    }

}
