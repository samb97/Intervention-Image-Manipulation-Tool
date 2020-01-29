<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class InterventionController extends Controller
{
    public function index($rules, $image_url)
    {
        $image = Image::make($image_url);
        $rules = explode('-', $rules);

        /**
         * Map all rules as an associative array, the key being 
         * the rules letter
         */
        $rules = collect($rules)->mapWithKeys(function($rule) {
            return [$rule[0] => str_replace($rule[0], '', $rule)];
        });

        $image->resize($rules->get('w'), $rules->get('h'), function($constraint) {
            $constraint->aspectRatio();

            /**
             * Enabling this prevents images from going bigger than 
             * their original source size
             */
            // $constraint->upsize();
        });

        return $image->response();

        dd($image);

    }
}
