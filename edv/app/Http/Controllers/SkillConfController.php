<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SkillConf;
use App\Skill;

class SkillConfController extends Controller
{
  /**
   * Get the configuration from the resource for specific user and skill.
   *
   * @return \Illuminate\Http\Response
   */
  private function getSkillConf($userId,$skill)
  {

    $skillId    =   Skill::select()->where('slug',$skill)->first()->skillId;

    $skillConf  =   SkillConf::select()
      ->where('userId',$userId)
      ->where('skillId',$skillId)
      ->first()->vconf;
      
    return $skillConf;
  }
  
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $skillsConf = [];
    $skills = Skill::all();
    $userId     =   auth()->check() ? auth()->user()->id : 1;
    
    foreach($skills as $skill){
      $skillsConf[$skill->slug]= $this->getSkillConf($userId,$skill->slug);
    }

    return view('pages.skillsconf')->with('skillsConf',$skillsConf);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      return "so yes";
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($skill)
  {
    $userId     =   auth()->check() ? auth()->user()->id : 1;
    $skillConf  = $this->getSkillConf($userId,$skill); 

    return view("skills.$skill.conf")->with(['skillConf' => $skillConf, 'slug' => $skill]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      //
  }
}
