@layout('admin::layouts.main')

@section('content')
<h1>Categories</h1>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Parent</th>
            <th>Published</th>
            <th>Updated</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach( $categories->results as $cat)
        <tr>
            <td>
                <a href="{{ action('admin::pages/categories/edit') }}?id={{ $cat->id }}" title="Edit">
                    {{ $cat->name }}
                </a>
            </td>
            @if( $cat->parent !== null )
            <td>{{ $cat->parent->name }}</td>
            @else
            <td><i>-None-</i></td>
            @endif
            <td>
                @if ($cat->published == 1)
                <span class="label label-info"><i class="icon-ok-sign icon-white"></i></span>
                @else
                <span class="label"><i class="icon-remove-sign icon-white"></i></span>
                @endif
            </td>
            <td>{{ date('d/m/y, h:i a', strtotime($cat->updated_at)) }}</td>
            <td>
                <a class="btn btn-info btn-mini"
                   href="{{ action('admin::pages/categories/edit') }}?id={{ $cat->id }}">Edit</a>
            </td>
        </tr>
        @endforeach
        <tbody>
</table>
@endsection

@section('pagination')
{{ $categories->links() }}
@endsection