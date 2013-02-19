@layout('master')
@section('container')
    <h1>My Awesome URL Shortener</h1>
    {{ Form::open('/') }}
        {{ Form::text('url') }}
    {{ Form::close() }}

{{ $errors->first('url', '<p class="error">:message</p>') }}
@endsection
