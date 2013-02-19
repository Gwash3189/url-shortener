<?php
/**
 * Created by IntelliJ IDEA.
 * User: AdamBeck
 * Date: 19/02/13
 * Time: 12:00 PM
 * To change this template use File | Settings | File Templates.
 */ 
class Url extends Eloquent{

    public static $rules = array(
        'url' => 'required|url'
    );

    public static function validate($input){
        $v =  Validator::make($input, static::$rules);
        return $v->fails()
            ? $v
            : true;
    }

    public static function get_unique_short_url(){
        $shortened = base_convert(rand(10000,99999), 10, 36); //should be base 64
        if(static::where_shortened($shortened)->first()){
        // if new shortened url matches an existing shortened url
            return static::get_unique_short_url(); //make a new one
        }
        return $shortened; //otherwise, return it.
    }

}
