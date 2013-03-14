@layout('admin::layouts.main')

@section('content')
<h1>Edit Category <small>{{ $category->name }}</h1>
{{ Form::open(URL::current(), 'POST', array('class' => 'form-horizontal')) }}

<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
    {{ Form::label('name', 'Name', array('class' => 'control-label')) }}
    <div class="controls">
        <input type="text" name="name" value="{{ $category->name }}" required>
    </div>
</div>

<?php
$parent_id = is_null($category->parent) ? '' : $category->parent->id;
list($full_slug, $cat) = \Pages\Category::full_slug($category->id);
?>

<div class="control-group {{ $errors->has('parent') ? 'error' : '' }}">
    {{ Form::label('parent', 'Parent', array('class' => 'control-label')) }}
    <div class="controls">
        <select name="parent">
            <option value="">----None (Top Level)----</option>
            @foreach ( $categories as $key => $val )
            <option value="{{ $key }}" {{ $parent_id === $key ? 'selected' : '' }}>
                {{ $val }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<div class="control-group">
    {{ Form::label('full-slug', 'Slug', array('class' => 'control-label')) }}
    <div class="controls">
        <code>{{ $full_slug }}</code>
    </div>
</div>

<div class="control-group {{ $errors->has('published') ? 'error' : '' }}">
    {{ Form::label('published', 'Published', array('class' => 'control-label')) }}
    <div class="controls">
        {{ Form::checkbox('published', $category->published, $category->published == 1 ? true : false) }}
    </div>
</div>

<div class="form-actions">
    <a href="{{ action('admin::pages/categories') }}" class="btn">&larr; Cancel</a>
    <input type="submit" value="Save Changes" class="btn btn-primary">
</div>

{{ Form::hidden('id', $category->id) }}
{{ Form::token() }}
{{ Form::close() }}
@endsection