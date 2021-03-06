<?php
Route::get('/', function()
{
	//if a get request is made to root
    return View::make('home.index'); //return the view/home/index.blade.php page.
});

Route::post('/', function()
{ //if a post is sent to root page (form submisstion, AJAX, etc..)

    $url = Input::get('url');//get the value of the input field 'url'

    $validate = Url::validate(array('url'=> $url)); // validate the URL by using the validate method in models/Url.php
    if($validate !==  true){ //if invalid
        return Redirect::to('/')->with_errors($validate->errors);
        // redirect back to root with error messages
    }
    // if the URL is already in the table, return it
    $record = Url::where_url($url)->first();
    if( $record ){
        return View::make('home.result')
                ->with('shortened',$record->shortened);
    }

    // othewise, add a new row aßnd return the shortened url
    $row = Url::create(array(
        'url' => $url, //uses Elequent method 'create' in order to insert both values.
        'shortened' => Url::get_unique_short_url() // see Url.php for more details
    ));
    if($row){ // if there is a response from the database
        return View::make('home.result') // return the home/result.blade.php page
            ->with('shortened', $row->shortened); // with the variable for a shortened url
    }
});

Route::get('(:any)',function($shortened){ // if any request sent to the root page with any data after the '/'

    //query the DB for the row with that short URL
    $row = Url::where_shortened($shortened)->first();
    if( is_null($row)){ // if there isn't that url in the database
        return Redirect::to('/'); //redirect to home page if not found
    }
    return Redirect::to($row->url); //otherwise, redirect to url

});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});
