@layout('admin::layouts.main')

@section('content')
<h1>Create Category</h1>
{{ Form::open(URL::current(), 'POST', array('class' => 'form-horizontal')) }}

<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
    {{ Form::label('name', 'Name', array('class' => 'control-label')) }}
    <div class="controls">
        <input type="text" name="name" value="{{ Input::old('name') }}" required>
    </div>
</div>

<div class="control-group {{ $errors->has('parent') ? 'error' : '' }}">
    {{ Form::label('parent', 'Parent', array('class' => 'control-label')) }}
    <div class="controls">
        <select name="parent">
            <option value="">----None (Top Level)----</option>
            @foreach ( $categories as $key => $val )
            <option value="{{ $key }}" {{ (Input::old('parent') == $key) ? 'selected' : '' }}>
                {{ $val }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<div class="control-group {{ $errors->has('order_by_column') ? 'error' : '' }}">
    {{ Form::label('order_by_column', 'Order by column', array('class' => 'control-label')) }}
    <div class="controls">
        <select name="order_by_column">
            @foreach ( $sort_columns as $key => $val )
            <option value="{{ $key }}" {{ (Input::old('order_by_column') == $key) ? 'selected' : '' }}>
                {{ $val }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<div class="control-group {{ $errors->has('order_by_direction') ? 'error' : '' }}">
    {{ Form::label('order_by_direction', 'Order by direction', array('class' => 'control-label')) }}
    <div class="controls">
        <select name="order_by_direction">
            @foreach ( $sort_directions as $key => $val )
            <option value="{{ $key }}" {{ (Input::old('order_by_direction') == $key) ? 'selected' : '' }}>
                {{ $val }}
            </option>
            @endforeach
        </select>
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