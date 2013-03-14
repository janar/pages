<?php namespace Pages\Models;

/**
 * Category model
 */
class Category extends \Eloquent {

    public static $timestamps = true;

    /**
     * Parent of current category
     */
    public function parent()
    {
        return $this->belongs_to('Pages\Models\Category', 'parent_id');
    }

    /**
     * Children of Category
     */
    public function children()
    {
        return $this->has_many('Pages\Models\Category', 'parent_id', 'id');
    }

    /**
     * A category can have many pages
     */
    public function pages()
    {
        return $this->has_many('Pages\Models\Page');
    }

    /**
     * Set slug
     */
    public function set_slug($slug)
    {
        $new_slug = $slug;
        $slug_rows = Category::where('slug', 'LIKE', $slug . '%')
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