@extends('dashboard.layouts.default')
@section('content')
    <section class="content">
        <div class="box">
            {!! Form::open(['action'=>['SettingsController@couponcode'],'method'=>'post','class'=>'form-horizontal','files'=>true,'enctype'=>'multipart/form-data']) !!}
            <div class="box-header with-border">
                <h3 class="box-title">Add Coupon</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-2">
                        
                        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-sm-3 control-label">Promo Code</label>
                            <div class="col-sm-9">
                                {!! Form::text('code',$value= (isset($site['code']['value'])?$site['code']['value']:''), $attributes = ['class'=>'form-control','address'=>'address','placeholder'=>'Enter Code'])  !!}
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-sm-3 control-label">Discount Type</label>
                            <div class="col-sm-9">
                               <select name="type" class="form-control">
                               <option selected>Select Discount Type</option>
                                 <option value="fixed">Fixed</option>
                                 <option value="percent">Percent</option>
                               </select>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-sm-3 control-label">Discount</label>
                            <div class="col-sm-9">
                                {!! Form::text('discount',$value= (isset($site['discount']['value'])?$site['discount']['value']:''), $attributes = ['class'=>'form-control','id'=>'discount','placeholder'=>'Enter Discount'])  !!}
                                @if ($errors->has('discount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('discount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('working_hours') ? ' has-error' : '' }}">
                            <label for="working_hours" class="col-sm-3 control-label">Expiry Date</label>
                            <div class="col-sm-9">
                                {!! Form::date('expiry_date',$value= (isset($site['expiry_date']['value'])?$site['expiry_date']['value']:''), $attributes = ['class'=>'form-control','id'=>'expiry_date','placeholder'=>'Enter Expiry Date'])  !!}
                                @if ($errors->has('expiry_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('expiry_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <hr>
                        
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-2">
                        <span class="pull-right">
                             <button type="submit" class="btn btn-info ">Save</button>
                        </span>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@stop

