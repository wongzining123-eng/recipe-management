<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['index', 'show']);
    }

}
