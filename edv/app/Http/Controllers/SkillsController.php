<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Skill;
use App\Http\Controllers\SkillConfController;

class SkillsController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $skills = Skill::all();
    return view('pages.skills')->with('skills',$skills);
  }
  
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($slug)
  {
    $vconf  = json_decode((new SkillConfController)->getSkillConf($slug),true);

    // Get Word-List (method,lang)
    $file = 'edv/en/wl_sigma1-en.txt';
    $lines = file($file);
    $wordlist = [];
    for($i=0;$i<144;$i++){
      $random = rand(0,100000000)/100000000;
      //  Search apropiate pondered index: lineal search (since prob. density is inverse)
      $n = count($lines);
      $index = 1;

      for($n=1;$n<count($lines);$n++){
        $line = preg_split("/\s+/",$lines[$n]);
        if ($random >= (float)$line[1]){
          continue;
        }
        $wordlist[] = $line[2];
        break;
      }

      // if ($rand == $)
      

    }

    // 

    return view("skills.$slug.$slug")->with('wordlist',$wordlist);
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
