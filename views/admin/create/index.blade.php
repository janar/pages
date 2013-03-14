@layout('admin::layouts.main')

@section('content')
<h1>Create Page</h1>
{{ Form::open(URL::current(), 'POST', array('class' => 'form-horizontal')) }}

<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
    {{ Form::label('name', 'Name', array('class' => 'control-label')) }}
    <div class="controls">
        <input type="text" name="name" value="{{ Input::old('name') }}" required>
    </div>
</div>

<div class="control-group {{ $errors->has('category') ? 'error' : '' }}">
    {{ Form::label('category', 'Category', array('class' => 'control-label')) }}
    <div class="controls">
        <select name="category">
            <option value="">----None----</option>
            @foreach ( $categories as $key => $val )
            <option value="{{ $key }}" {{ (Input::old('category') == $key) ? 'selected' : '' }}>
                {{ $val }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<div class="control-group {{ $errors->has('body') ? 'error' : '' }}">
    {{ Form::label('body', 'Body', array('class' => 'control-label')) }}
    <div class="controls">
        <textarea name="body" rows="12" class="input-xxlarge ckeditor">{{ Input::old('body') }}</textarea>
    </div>
</div>

<div class="control-group {{ $errors->has('published') ? 'error' : '' }}">
    {{ Form::label('published', 'Published', array('class' => 'control-label')) }}
    <div class="controls">
        <input type="checkbox" name="published" value="{{ Input::old('published') }}">
    </div>
</div>

<div class="form-actions">
    <input type="submit" value="Submit" class="btn btn-primary">
</div>

{{ Form::token() }}
{{ Form::close() }}
@endsection