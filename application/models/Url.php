<?php
/**
 * User: AdamBeck
 * Date: 19/02/13
 * Time: 12:00 PM
 */ 
class Url extends Eloquent{

    public static $rules = array(
        'url' => 'required|url' // the url field is requied and must be a valid url. 
    );

    public static function validate($input){
        $v =  Validator::make($input, static::$rules);
        return $v->fails()
            ? $v
            : true;
    }

    public static function get_unique_short_url(){
        $shortened = base_convert(rand(10000,99999), 10, 36); //generates a random number & converts to characters.should be base 64
        if(static::where_shortened($shortened)->first()){
        // if new shortened url matches an existing shortened url
            return static::get_unique_short_url(); //repeat above steps and make a new url
        }
        return $shortened; //otherwise, return it.
    }

}
