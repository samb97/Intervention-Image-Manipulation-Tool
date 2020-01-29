<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class InterventionController extends Controller
{
    public function index(Request $request, $image_url)
    {
        $image = Image::make($image_url);

        if ($request->query('fill') === 'true') {
            $image->fit($request->query('width'), $request->query('height'), function($constraint) {
                $constraint->upsize();
            });
        } else {
            $image->resize($request->query('width'), $request->query('height'), function($constraint) use ($request) {
                $constraint->aspectRatio();
    
                if ($request->query('upsize')) {
                    $constraint->upsize();
                }
            });
        }

        return $image->response();
    }
}
