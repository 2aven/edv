<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coffret;
use App\Skill;

class CoffretController extends Controller
{

  /**
   * Display a Graph of the logged user PPM evolution
   * 
   * @return \Lava::LineChart 
   */
  private function PPMevolution($skillId,$userId){
    $userCoffrets = Coffret::select()
      ->where('skillId',$skillId)
      ->where('userId',$userId)
      ->get()->toArray();
    $DataTable = \Lava::DataTable();
    $DataTable->addDateColumn('Date')->addNumberColumn('PPM');
    
    
    foreach ($userCoffrets as $coffret) {
      $analisys= json_decode($coffret['vdata'],true);
      $DataTable->addRow([
        $coffret['created_at'],
        round($analisys['vresults']['pacum']*600/$analisys['vresults']['t'],2)
      ]);
    }
    return \Lava::LineChart('statistics', $DataTable);
  }

  /**
   * Display a Graph of all users PPM, or WPM if the second parameter is true
   *  
   * @return \Lava::ColumnChart 
   */
  private function PPMnormal($skillId,$wpm = false){
    $coffrets = Coffret::where('skillId',$skillId)->get()->toArray();
    $DataTable = \Lava::DataTable();
    $DataTable->addNumberColumn('PPM')->addNumberColumn('N');
    
    $sectors = [];
    foreach ($coffrets as $coffret) {
      $analisys= json_decode($coffret['vdata'],true);
      $ppm=(int)round($analisys['vresults']['pacum']*600/($analisys['vresults']['t']*($wpm?5:1)));
      (array_key_exists($ppm,$sectors))?++$sectors[$ppm]:$sectors[$ppm]=1;
    }

    foreach ($sectors as $sector => $n) {
      $DataTable->addRow([$sector,$n]);
    }
    
    $xpm = $wpm?'wpmnormal':'ppmnormal';
    return \Lava::ColumnChart($xpm, $DataTable);

  }

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
    $userId = auth()->check() ? auth()->user()->id : 1;

    $vresults = json_decode($request->vresults,true);
    $coffretData = [
      'skill'     => $slug,
      'vresults'  => $vresults
    ];
    $coffret = new Coffret;
    $coffret->userId = $userId;
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
  public function show($slug)
  {

    $skillId = Skill::where('slug',$slug)->first()->skillId;
    $userId = auth()->check() ? auth()->user()->id : 1;
    
    $statistics = ($userId != 1)?$this->PPMevolution($skillId,$userId):null;

    $ppmNormal = $this->PPMnormal($skillId);
    $wpmNormal = $this->PPMnormal($skillId,true);

    // $wpmNormal = $this->WPMnormal($skillId);

    return view("skills.$slug.analytics")->with('statistics', isset($statistics));
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
