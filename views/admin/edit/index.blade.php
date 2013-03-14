@layout('admin::layouts.main')

@section('content')
<h1>Edit Page <small>{{ $page->name }}</small></h1>
{{ Form::open(URL::current(), 'POST', array('class' => 'form-horizontal')) }}

<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
    {{ Form::label('name', 'Name', array('class' => 'control-label')) }}
    <div class="controls">
        <input type="text" name="name" value="{{ $page->name }}" required>
    </div>
</div>

<?php
$category_id = is_null($page->category) ? '' : $page->category->id;
list($full_slug, $page) = \Pages\Page::full_slug($page->id)
?>

<div class="control-group {{ $errors->has('category') ? 'error' : '' }}">
    {{ Form::label('category', 'Category', array('class' => 'control-label')) }}
    <div class="controls">
        <select name="category">
            <option value="">----None----</option>
            @foreach ( $categories as $key => $val )
            <option value="{{ $key }}" {{ $category_id == $key ? 'selected' : '' }}>
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

<div class="control-group {{ $errors->has('body') ? 'error' : '' }}">
    {{ Form::label('body', 'Body', array('class' => 'control-label')) }}
    <div class="controls">
        <textarea name="body" rows="12" class="input-xxlarge ckeditor" required>{{ $page->body }}</textarea>
    </div>
</div>

<div class="control-group {{ $errors->has('published') ? 'error' : '' }}">
    {{ Form::label('published', 'Published', array('class' => 'control-label')) }}
    <div class="controls">
        {{ Form::checkbox('published', $page->published, $page->published == 1 ? true : false) }}
    </div>
</div>

<div class="form-actions">
    <a href="{{ action('admin::pages') }}" class="btn">&larr; Cancel</a>
    <input type="submit" value="Save Changes" class="btn btn-primary">
</div>

{{ Form::hidden('id', $page->id) }}
{{ Form::token() }}
{{ Form::close() }}
@endsection