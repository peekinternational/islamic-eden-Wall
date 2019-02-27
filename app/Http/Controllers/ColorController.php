<?php

namespace Edenmill\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ColorController extends Controller
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
        //dd($request->all());
        $this->validate($request, [
                        'name' => 'required'
                                        ]);
        $colors=DB::table('color')->insert($request->all());

                 session()->flash('__response', ['notify'=>' color Add Succesfully','type'=>'success']);

                return redirect('/dashboard/colors');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function show(Request $request)
    {

        $colors= DB::table('color')->get();
      //dd($colors);

    return view('dashboard.colors.showcolor',compact('colors'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      public function edit(Request $request,$id)
    {

        $colors= DB::table('color')->where('id','=',$id)->first();
    return view('dashboard.colors.editcolor',compact('colors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function updatecolor(Request $request)
    {
// dd($request->all());
        $id = $request->input('id');
             // dd($id );

        DB::table('color')->where('id','=',$id)->update($request->all());
        session()->flash('__response', ['notify'=>'color  update successfully.','type'=>'success']);
    
    
    return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        $colors = DB::table('color')->where('id',$id)->delete();
       
        session()->flash('__response', ['notify'=>'Color  deleted successfully.','type'=>'success']);
        return back();
    }
}
