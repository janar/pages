<?php

use Pages\Models\Category;
use Pages\Models\Page;

Route::get('(:bundle)/category/(:all)', function ($slug) {
    // Sanitize slug
    $slug = trim(urldecode($slug), '\ /');
    // Match and fetch category from slug
    list($matched, $cat) = Pages\Category::match_slug_by_path($slug);
    // if no match found, give 404
    if ($matched === false) return Response::error('404');
    $data['pages'] = $cat->pages()
                         ->where_published(1)
                         ->order_by($cat->order_by_column, $cat->order_by_direction)
                         ->paginate(10);
    $data['category'] = $cat;
    $data['children'] = $cat->children;
    // Theme
    $theme = IoC::resolve('Theme');
    $theme->set_theme(Config::get('theme.active'));
    $theme->set_layout('category');
    $theme->title($cat->name);
    return $theme->render('pages::category.list', $data);
});

//Prevent access to /category
Route::get('(:bundle)/category', function () {
    return Response::error('404');
});

Route::get('(:bundle)/(:all)', function ($path) {
    $path = trim(urldecode($path), '\ /');
    $split = explode('/', $path);
    $page_slug = array_pop($split);
    $cat_path = implode('/', $split);
    if (strlen($cat_path) > 0) {
        list($full_slug, $page) = Pages\Page::full_slug($page_slug);
        if ($full_slug !== $path) return Response::error('404');
    } else {
        $page = Page::where_slug($page_slug)
            ->where_published(1)
            ->first();
    }
    if ($page === null) return Response::error('404');
    if ($page->category !== null and strlen($cat_path) === 0)
        return Response::error('404');

    // Theme
    $theme = IoC::resolve('Theme');
    $theme->set_theme(Config::get('theme.active'));
    $theme->set_layout('page');
    $theme->title($page->name);
    return $theme->render('pages::page.view',
                          array('page' => $page));
});