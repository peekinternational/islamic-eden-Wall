@extends('dashboard.layouts.default')
@section('content')
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Tags</h3>
                <div class="box-tools pull-right">
                  <a href="" type="button" class="btn btn-box-tool"  data-toggle="tooltip" title="New coupon">
                        <i class="fa fa-plus"></i>
                    </a>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                @include('dashboard.partials.formErrorMessage')
                <table class="table table-bordered">
                    <tbody><tr>
                    	<th>Sr.</th>
                        <th>Tag name</th>
                        <th>Action</th>
                        
                    </tr>
                    @foreach($tags as $tag)
                   
                        <tr>
                        	<td style="width: 10px" >{{ $tag->id }}</td>
                            <td >{{ $tag->name }}</td>
                           
							 <td style="width: 15%;"><span class="btn-edit">

                                    <a href="{{ url('dashboard/edittag/'.$tag->id) }}" class="btn btn-xs btn-warning" data-toggle="tooltip"  data-original-title="Edit"><i class="fa fa-edit"></i> </a>

                                    {!! Form::open(['action'=>['TagsController@destroy',$tag->id],'method'=>'delete','style'=>'display:inline;']) !!}
                                   <input type="hidden" class="delete_permanent" name="delete_permanent" value="0">
                                    <button type="submit" class="btn btn-xs btn-danger btn-delete-user" data-toggle="tooltip"  data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                    {!! Form::close() !!}
                            </span></td>
                            
                        </tr>
                    @endforeach
                    @if($tags->isEmpty())
                        <tr>
                            <td colspan="13">
                                <p class="alert alert-warning text-center">
                                    No orders found.
                                </p>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->
		<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    </section>
@stop
@section('footer')

@stop
