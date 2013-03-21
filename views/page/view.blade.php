<h1 id="page-title">{{ $page->name }}
    @if ($page->category !== null)
    <small>{{ $page->category->name }}</small></h1>
    @else
</h1>
    @endif

@if ($page->category !== null)
<div class="margin-top margin-bottom-xxlarge">
    <a class="btn btn-small" href="{{ url('category/' . Pages\Category::full_slug($page->category->id)[0]) }}">
        <i class="icon-chevron-left"></i> Back to {{ $page->category->name }}
    </a>
</div>
@endif

<div class="content">
    {{ $page->body }}
</div>
