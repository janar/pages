<?php namespace Pages;

/**
 * Provides various data fetching methods for Category
 */
class Category {

    /**
     * Provides entire tree for the category
     */
    protected static $tree = array();

    /**
     * Process a subtree
     *
     * @param array $items
     * @param integer $parent_id
     * @see http://stackoverflow.com/a/8518561/575242
     * @return array
     */
    protected static function get_subtree($items, $parent_id = null) {
        $tree = array();
        foreach($items as $item) {
            $item = $item->to_array();
            if($item['parent_id'] === $parent_id) {
                $tree[$item['id']] = $item;
                $tree[$item['id']]['children'] = static::get_subtree(
                    $items,
                    $item['id']);
            }
        }

        return $tree;
    }

    /**
     * Creates a tree from top down
     *
     * Creates an adjacency list from categories table with a single
     * SQL query. Please improve this if possible.
     *
     * @see http://stackoverflow.com/a/7874978/575242
     */
    public static function get_tree()
    {
        $all_categories = \Pages\Models\Category::all();
        if(empty(static::$tree)) {
            static::$tree = static::get_subtree($all_categories);
        }
        return static::$tree;
    }

    /**
     * Siblings for Category
     *
     * @param \Pages\Models\Category $category
     * @return array
     */
    public static function get_siblings(\Pages\Models\Category $category)
    {
        return \Pages\Models\Category::where_parent_id($category->parent_id)
            ->where_not_in('id', array($category->id))->get();
    }

    /**
     * Converts tree to html unordered list elements
     *
     * @access public
     * @param array $items
     *   A tree array
     * @param null | int $parent_id
     * @return string
     */
    public static function to_html_list_recursive($items = null, $level = 0)
    {
        $output = '';
        if (is_null($items)) {
            $items = static::get_tree();
        }
        if(empty($items)) return $output;
        foreach($items as $item) {
            $output .= '<li class="item level-item-' . $level . '">' . $item['name'];
            if (count($item['children'])) {
                $output .= '<ul class="level-children-' . $level . '">';
                $output .= static::to_html_list_recursive($item['children'],
                                                          ++$level);
                $output .= '</ul>';
            }
            $output .= '</li>';
        }
        return $output;
    }

    /**
     * Converts tree to list of indented items by depth
     *
     * @access public
     * @param array $items
     *   A tree array
     * @param null | int $parent_id
     * @return array
     */
    public static function to_indented_list_recursive($items = null, $level = 0)
    {
        $output = array();
        $stack = array();
        if (is_null($items)) {
            $items = static::get_tree();
        }
        if(empty($items)) return $output;
        foreach ($items as $item) {
            $stack[] = array(
                $item['id'] => str_repeat('- ', $level) . $item['name']
                );
            if (count($item['children'])) {
                $stack[] = static::to_indented_list_recursive($item['children'],
                                                              ($level + 1));
            }
        }
        $walk = function ($value, $key) use ($stack, &$output) {
            //$output[] = array($key => $value);
            $output[$key] = $value;
        };
        array_walk_recursive($stack, $walk);
        return $output;
    }

/**
 * Generate full slug for category
 *
 * Call this method as:
 *
 * <code>
 * list($full_slug, $category) = Category::full_slug($input);
 * </code>
 *
 * @access static
 * @param int | string $input
 * @param string $slug_string
 * @return array(string, \Pages\Models\Category | null)
 */
    public static function full_slug($input, $slug_string = '')
    {
        // Fetch Category by checking whether $input is integer or
        // string. We do the integer testing first because it will
        // speed up recursion.
        if (is_int($input) or
            (ctype_digit($input) && strlen((int) $input) == strlen($input))) {
            $cat = \Pages\Models\Category::find($input);
        } elseif (is_string($input)) {
            $cat = \Pages\Models\Category::where_slug($input)->first();
        }
        // If no category is found, return $slug_string
        if ($cat === null) {
            return array($slug_string, $cat);
        }
        // If category is found, get slug
        $slug_string = trim($cat->slug . '/' . $slug_string, '/');
        // Check if category has a parent. If yes, do a recursion to
        // find the slug of the parent categories till a root category
        // is reached
        if ($cat->parent === null) {
            return array($slug_string, $cat);
        } else {
            $full_slug = static::full_slug($cat->parent->id, $slug_string);
            return array($full_slug[0], $cat);
        }
    }

/**
 * Match slug by path
 *
 * @param string $path
 * @return array(bool, \Pages\Models\Category | null)
 */
    public static function match_slug_by_path($path)
    {
        $path = trim(urldecode($path), '\ /');
        $split = array_reverse(explode('/', $path));
        $full_slug = static::full_slug($split[0]);
        if ($full_slug[0] === $path) {
            return array(true, $full_slug[1]);
        } else {
            return array(false, $full_slug[1]);
        }
    }

}