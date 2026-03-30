<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\project;

class ProjectsController extends Controller
{
      public function store(Request $request) { return 
Project::create($request->only('Username','Password', 'Email')); } 
}
