@layout('master')
    @section('container')
        <h1>Here is your short URL</h1>
        {{ HTML::link($shortened, "url.dev/$shortened") }}
    @endsection