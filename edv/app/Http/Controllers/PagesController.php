<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
  public function index(){  
    
    $skillsData=[
      'edv' => [
        'nomsk' =>  ' tinytext not null',  
        'ruta'  =>  'tinytext not null',
        'imatge'  =>  'tinytext not null'],
      'edm' => [
        'nomsk' =>  ' tinytext not null',  
        'ruta'  =>  'tinytext not null',
        'imatge'  =>  'tinytext not null']
    ];

    return view('pages.index')->with('skillsData', $skillsData);
  }
  
  public function about(){
    return view('pages.about');
  }
}
