Pages for Laravel
=================

This bundle provides a pages and categories for Laravel 3 with the
[Admin Framework](https://github.com/CodeBinders/admin-framework).

Features
--------

- Supports multi-level categories
- Pages can be "top-level" or in categories
- Integration with Admin Framework to make it easy to create/edit
  pages and categories.

Requirements
------------

- [Admin Framework](https://github.com/CodeBinders/admin-framework)

- [Themes Bundle](https://github.com/kaustavdm/Laravel_Theme_Bundle) -
preferably use this fork.

- Laravel 3

Installation
------------

- Git clone or copy the bundle to Laravel's `bundles` directory with
  the name of `pages`.

    ```sh
    $ git clone git@github.com:CodeBinders/pages.git
    ```

- Edit `application/bundles.php` and register Pages bundle. To have
  Pages bundle serve requests without any intermediate URI segment, use
  `'/'` as the `'handles'` value:

    ```php
    'pages' => array('handles' => '/'),
    ```

  Else, specify the handles value accordingly, e.g. for serving pages
  as `/p/my-page`, use this:

    ```php
    'pages' => array('handles' => 'p'),
    ```

- Run migrations. Run this command in Laravel's project directory:

    ```sh
    php artisan migrate:pages
    ```

- Implement a theme based on the Theme bundle. The theme should
  implement two layouts - categories and pages. For example of those
  layouts see `examples/layouts/` directory.

- If a `theme.php` config file is not already present in Laravel's
  `application/config/` directory, copy `config/theme.php` to
  Laravel's `application/config/` directory.

License
-------

Released under the terms of the GNU General Public License v3+. For
full license text see: http://www.gnu.org/licenses/gpl.txt
