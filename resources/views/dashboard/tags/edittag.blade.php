@extends('dashboard.layouts.default')
@section('css')
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/backend/dist/css/styles.imageuploader.css') }}">
@endsection

@section('content')
<section class="content">
	<div class="box">
		<div class="box-header with-border">
                <h3 class="box-title">Add New TAgs</h3>
                <div class="box-tools pull-right">
                    <a href="" type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Show Products">
                        <i class="fa fa-list"></i></a>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                </div>
        </div>
        <div class=" text-cenetr form-group {{ $errors->has('name') ? ' has-error' : '' }}">
        	
        		<div class="row">
        				<div class="col-sm-6 col-sm-offset-2">
        		  <div class="col-md-6 ">
                    <form action="{{ url('dashboard/update')}}" method="post" role="form">
                    	 {{ csrf_field() }}
                    	<input type="hidden" name="id" value="{{$tags->id}}">

                    
                    	<div class="form-group text-cenetr">
                    		<label for="">tag name</label>
                    		<input type="text" class="form-control" id="" name="name" value="{{$tags->name}}" placeholder="Enter TAgs">
                    	</div>
                    
                    	
                    
                    	<button type="submit" class="btn btn-primary">update</button>
                    </form>
                </div>
               </div>
        		</div>
        
              
            
		</div>
	</div>	
</section>
@stop
@section('footer')