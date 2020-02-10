<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class MapController extends Controller {
    public function map () 
    {
        $attributes = request()->validate([
            'path' => 'required'
        ]);

        $path = str_split($attributes['path']);

        $map = [
            [0,0,0,1,1,1,0,0,0],
            [0,0,0,0,0,1,0,0,0],
            [0,0,0,0,1,1,0,0,0],
            [0,0,0,0,1,1,0,0,0],
            [0,1,1,1,1,0,0,0,0],
            [0,2,0,0,0,0,0,0,0],
        ];

        // Represent the droid co-ordinates when starting
        // $x seems to be +1 if the droid moves forward
        // $y + 1 if r
        // $y -1 if l
        $x = 0;
        $y = 4;

        foreach ($path as $direction) {
            // Update the X and Y co-ords for each run
            switch ($direction) {
                case 'f':
                    $x = $x+1;
                break;
                case 'r':
                    $y = $y+1;
                break;
                case 'l':
                    $y = $y-1;
                break;
            }

            Log::info($map[$x][$y]);

            // If the droid crashes, return a 417 response
            if ($map[$x][$y] == 0) {
                return response()->json(['map' =>  array_slice($map, 0, $x)])->setStatusCode(417);
            } 
        }

        // Keep going until we run out of string or 2 is reached
        if ($map[$x][$y] == 2) {
            // If we reach the end, return 200
            return response()->json(['map' => implode(',', $map)]);
        } elseif ($map[$x][$y] == 1) {
            // If there is still a way to go and the droid is stuck, return a 410
            return response()->json(['map' => implode(',', array_slice($map, 0, $x))])->setStatusCode(410);
        }

    }
}
