<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SkillConfig;
use App\Skill;

class SkillConfigsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      //
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
    $skillId    =   Skill::select('skillId')->where('slug',$skill)->first();
    $skillConfig =  SkillConfig::select('vconf')
      ->where('userId',$userId)
      ->where('skillId',$skillId)
      ->first();

    $skillConfig = "SkillId: $skillId ;; userId: $userId"; 
    return view("skills.$skill.conf")->with('skillConfig',$skillConfig);
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
