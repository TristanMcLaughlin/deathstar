<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DroidController extends Controller
{
    /**
     * start
     *
     * @return void
     */
    public function start ()
    {
        // Save the currently explored map line as an item in the DB with co-ords X and Y
        // Then set off aiming for the next square.

        $path = Path::all();

        
    }
}
