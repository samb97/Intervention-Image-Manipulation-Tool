<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class InterventionController extends Controller
{
    public function index(Request $request, $image_url)
    {
        $image = Image::make($image_url);

        /* Fill */
        if ($request->query('fill') === 'true') {
            $image->fit($request->query('width'), $request->query('height'), function($constraint) use ($request) {
                if ($request->query('upsize')) {
                    $constraint->upsize();
                }
            });

            return $image->response();
        }
        
        /* No Fill (Contain) */
        if ($request->query('fill') !== 'true'){
            $image->resize($request->query('width'), $request->query('height'), function($constraint) use ($request) {
                $constraint->aspectRatio();
    
                if ($request->query('upsize')) {
                    $constraint->upsize();
                }
            });

            return $image->response();
        }

    }
}
