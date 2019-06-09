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
   * @return Array
   */
  public function getSkillConf($slug)
  {
    
    // GUEST case: use session config if defined.
    if(!(auth()->check()) && session()->exists("$slug"))
      return session()->get("$slug");

    $userId = auth()->check() ? auth()->user()->id : 1;
    $skillId = Skill::select()->where('slug',$slug)->first()->skillId;
    
    $skillConf  =   SkillConf::select()
      ->where('userId',$userId)
      ->where('skillId',$skillId)
      ->first();

    // case: user has no config defined yet, gets from Guest 'default'
    if (!$skillConf)
      $skillConf  =   SkillConf::select()
        ->where('userId',1)
        ->where('skillId',$skillId)
        ->first();
      
    return $skillConf->vconf;
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
    
    foreach($skills as $skill){
      $skillsConf[$skill->slug]= $this->getSkillConf($skill->slug);
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
    $messages=[];
    $slug = 'edv'; //   !!!!! !!!! !!! !!! ! ! ! ! !
    $skill = Skill::where('slug',$slug)->first();
    $skillId=$skill->skillId;

    $vconf=[];  $validArray=[];
    foreach($request->input() as $key => $options){
      $validArray[$key] = 'required';
      $vconf[$key] = $request->input("$key");
    } 
    $this->validate($request,$validArray);
    $vconf = json_encode($vconf);
    
    
    // If user is logged: save config in DB
    if(auth()->check()){
      $userId=auth()->user()->id;
      
      $skillConf = SkillConf::where('userId',$userId)->where('skillId',$skillId)->first();
      if (!$skillConf) $skillConf = new SkillConf;
      
      $skillConf->userId  = $userId;
      $skillConf->skillId = $skillId;
      $skillConf->vconf   = $vconf;
      $skillConf->save();
      
      $messages['edv'] = "Saved";    // <<<<< ------ TRANSLATE THIS 
    } else {
      // GUEST case: save options in session.
      session()->put($slug, $vconf);
      $messages['edv'] = "No loggin";
    }
    
    return view('pages.skills')->with(['skills'=>Skill::all(),'messages'=>$messages]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($skill)
  {    
    return view("skills.$skill.conf")->with([
      'vconf'   => json_decode($this->getSkillConf($skill),true), 
      'slug'    => $skill
      ]);
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
