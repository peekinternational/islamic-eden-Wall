<?php

namespace Edenmill\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TagsController extends Controller
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
        $this->validate($request, [
                        'name' => 'required'
                                        ]);
        $tag=DB::table('tags')->insert($request->all());

                 session()->flash('__response', ['notify'=>' tags Add Succesfully','type'=>'success']);

                return redirect('/dashboard/tags');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        $tags= DB::table('tags')->get();
      // dd($tags);

    return view('dashboard.tags.showtags',compact('tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $tags= DB::table('tags')->where('id','=',$id)->first();
    return view('dashboard.tags.edittag',compact('tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatetag(Request $request)
    {
//dd($request->all());
        $id = $request->input('id');
             // dd($id );

        DB::table('tags')->where('id','=',$id)->update($request->all());
        session()->flash('__response', ['notify'=>'Tag  update successfully.','type'=>'success']);
    
    
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
        $tags = DB::table('tags')->where('id',$id)->delete();
       
        session()->flash('__response', ['notify'=>'Coupon  deleted successfully.','type'=>'success']);
        return back();
    }
}
