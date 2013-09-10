<div class="category-{{ $category->slug }}">
    <h1 id="page-title">{{ $category->name }}</h1>

    @if ($category->parent !== null)
        <a class="btn btn-small btn-inverse" href="{{ substr(URL::current(), 0, strrpos(URL::current(), '/')) }}">
            <i class="icon-chevron-left icon-white"></i> Back to {{ $category->parent->name }}
        </a>
    @endif

    @if (count($children))
        <div class="category-children divider-bottom">
            <h2>Browse {{ $category->name }}</h2>
            <ul class="thumbnails">
                @foreach ($children as $child)
                    <li class="span3">
                        <div class="thumbnail">
                            <h3 class="text-center">
                                <a href="{{ URL::current() . '/' . $child->slug }}">
                                    {{ $child->name }}
                                </a>
                            </h3>
                            <a href="{{ URL::current() . '/' . $child->slug }}" class="btn btn-block btn-small">
                                <i class="icon-chevron-right"></i> View
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="category-pages">
        @foreach ($pages->results as $page)
            <div class="category-page divider-bottom">
        <?php $full_slug = substr(URI::current(), strpos(URI::current(), '/'));
        $full_slug = rtrim($full_slug, '/') . '/' . $page->slug;
        ?>
                <h3><a href="{{ url($full_slug) }}">{{ $page->name }}</a></h3>
                <p class="teaser divider-left">
                    {{ Str::words(strip_tags($page->body), 60) . '&hellip;' }}
                </p>
                <div class="row">
                    <div class="span6 text-right published-date">
                        <small>Published: {{ date('jS M, Y', strtotime($page->created_at)) }}</small>
                    </div>
                    <div class="span2 offset1">
                        <a class="btn btn-small" href={{ url($full_slug) }}>
                            <i class="icon-chevron-right"></i> Read More
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if (count($pages->results) === 0 and count($children) === 0)
        <p class="muted">Nothing has been published in {{ $category->name }} yet.</p>
    @endif

    <div class="pagination">
        {{ $pages->links() }}
    </div>
</div>