@layout('admin::layouts.main')

@section('content')
<h1>Pages
    <small>
        <a href="{{ action('admin::pages.create') }}"
           class="btn btn-primary pull-right">
            <i class="icon icon-plus icon-white"></i> Create New Page</a>
    </small>
</h1>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Published</th>
            <th>Updated</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach( $pages->results as $page)
        <tr>
            <td>
                <a href="{{ action('admin::pages/edit') }}?id={{ $page->id }}" title="Edit">
                    {{ $page->name }}
                </a>
            </td>
            @if( $page->category !== null )
            <td>{{ $page->category->name }}</td>
            @else
            <td><i>-None-</i></td>
            @endif
            <td>
                @if ($page->published == 1)
                <span class="label label-info"><i class="icon-ok-sign icon-white"></i></span>
                @else
                <span class="label"><i class="icon-remove-sign icon-white"></i></span>
                @endif
            </td>
            <td>{{ date('d/m/y, h:i a', strtotime($page->updated_at)) }}</td>
            <td>
                <a class="btn btn-info btn-mini"
                   href="{{ action('admin::pages/edit') }}?id={{ $page->id }}">Edit</a>
            </td>
        </tr>
        @endforeach
        <tbody>
</table>
@endsection

@section('pagination')
{{ $pages->links() }}
@endsection