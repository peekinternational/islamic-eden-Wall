<?php

namespace Edenmill\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class ContactController extends Controller
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

    public function contactus(Request $request)
    {

             $this->validate($request,[
            'name' => 'required',
            'email' =>'required',
            'message' =>'required'
        ]);
                         // $inputs['payer_email']='rizwanahmadabbasi05@gmail.com';
                         $inputs=$request->all();
                         $toemail ='rizwanahmadabbasi05@gmail.com';
                        Mail::send('emails.contactus',['contact' =>$inputs],
                        function ($message) use ($toemail)
                        {
                            $message->subject('Islamic Wall - FeedBack');
                            $message->from('nabeelirbab@gmail.com', 'Islamic Wall Design');
                            $message->to($toemail);
                         });
						 
						session()->flash('__response', ['notify'=>' Thankyou for contacting us we will get back to you soon','type'=>'success']);
                         return back();

    }

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
