<?php namespace Pages;

/**
 * Provides various data fetching methods for Page
 */
class Page {

    /**
     * Generate full slug of a page based on category slug
     */
    public static function full_slug($input)
    {
        // Fetch information
        if (is_int($input) or
            (ctype_digit($input) && strlen((int) $input) == strlen($input))) {
            $page = \Pages\Models\Page::with('category')
                ->find((int) $input);
        } elseif (is_string($input)) {
            $page = \Pages\Models\Page::with('category')
                ->where_slug($input)
                ->first();
        }
        if (is_null($page)) {
            return null;
        }
        if ($page->category === null) {
            return array($page->slug, $page);
        } else {
            list($slug, $cat) = Category::full_slug($page->category->id);
            return array($slug . '/' . $page->slug,
                         $page);
        }
    }

}