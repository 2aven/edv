<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SkillConfig;
use App\Skill;

class SkillConfigsController extends Controller
{
  /**
   * Get the configuration from the resource for specific user and skill.
   *
   * @return \Illuminate\Http\Response
   */
  private function getSkillConf($userId,$skill)
  {
    $skillId    =   Skill::select('skillId')->where('slug',$skill)->first();
    $skillConf  =   SkillConfig::select('vconf')
    ->where('userId',$userId)
    ->where('skillId',$skillId)
    ->first();

    // previ a tenir dump-data
      return "SkillId: $skillId ;; userId: $userId"; 
    // -- -- -- -- -- -- -- --
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
      $skillsConf[]= $this->getSkillConf($userId,$skill);
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
      //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($skill)
  {
    //$userId = User::where('user',$user)->value('id');
    $userId     =   auth()->check() ? auth()->user()->id : 1;
    
    // previ a tenir dump-data
      $skillConf  = $this->getSkillConf($userId,$skill); 
    // -- -- -- -- -- -- -- --
    return view("skills.$skill.conf")->with('skillConf',$skillConf);
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
