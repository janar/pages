<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ $theme_data['title'] }}</title>
        {{ $theme_data['metadata'] }}
        {{ theme_partial('components/ie6') }}
        <link rel="shortcut icon" href="{{ asset('themes/default/assets/img/favicon.ico') }}">
    </head>
    <body class="page-body {{ (rtrim(URL::current(), '/ ') === rtrim(URL::base(), '/ ')) ? 'front' : 'not-front' }}">

        @if (rtrim(URL::current(), '/ ') === rtrim(URL::base(), '/'))
        {{ theme_partial('sections/header_front') }}
        @else
        {{ theme_partial('sections/header_not_front') }}
        @endif

        <div class="container-fluid content-wrapper-outer">
            <div class="container">
                <div class="content-wrapper row">
                    <section>
                        <div class="content span9">
                            {{ $theme_content }}
                        </div><!-- /.content -->
                    </section>
                    <aside>
                        <div class="sidebar span3 divider-left">
                            {{ theme_partial('sections/sidebar') }}
                        </div><!-- /.sidebar -->
                    </aside>
                </div><!-- /.content-wrapper -->
            </div>
        </div><!-- /.container -->

        <footer>
            <div class="footer container-fluid">
                    {{ theme_partial('sections/footer') }}
            </div><!-- /.container -->
        </footer>

    </body>
</html>