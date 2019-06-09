<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coffret;
use App\Skill;

class CoffretController extends Controller
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
    $slug = $request->skill;
    $skillId = Skill::where('slug',$slug)->first()->skillId;

    $vresults = json_decode($request->vresults,true);
    $coffretData = [
      'skill'     => $slug,
      'vresults'  => $vresults
    ];
    $coffret = new Coffret;
    $coffret->userId = auth()->user()->id;
    $coffret->skillId = Skill::where('slug',$slug)->first()->skillId;;
    $coffret->vdata= json_encode($coffretData);

    $coffret->save();

    return view("skills.$slug.data")->with('vresults', $vresults);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
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
