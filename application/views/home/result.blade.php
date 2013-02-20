@layout('master')
    @section('container')
        <h1>Here is your short URL</h1>
        {{ HTML::link($shortened, "url.dev/$shortened") }} <!-- use Laravel HTML class to show a link -->
        <!-- url text will display the value of the shortened URL --> 
        <!-- Value will be the same. -->
    @endsection
