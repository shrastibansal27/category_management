@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Category Management System</div>
             <div class="panel-body">
                @if(session()->has('error'))
                <div class="alert alert-warning">
                    <span class="help-block">
                        <strong>{!! session()->get('error') !!}</strong>
                    </span>
                </div>
                @endif
                <div>
                    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#catModal">Add Category</button>
                    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#subcatModal">Add
                    SubCategory</button>
                </div>
                <br>
    <!-- Sub-Category Modal -->
        <div class="modal fade" id="subcatModal" role="dialog">
         <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Sub-Category</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{url('add_subcat')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="categories" class="col-md-4 control-label">Select Category</label>
                        <div class="col-md-6">
                            <select class="form-control" name="category">
                                @if(!empty($category_list))
                                 @foreach($category_list as $cat)
                                <option value="{{$cat['category_name']}}" >{{$cat['category_name']}}</option>
                                @endforeach
                                 @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sub_category" class="col-md-4 control-label">Sub-Category Name</label>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <input type="text"  class="form-control" name="sub_category" id="sub_category">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sub_category_info" class="col-md-4 control-label">Sub-Category Info</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="sub_category_info" id="sub_category_info">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <input type="submit" name="save" value="save">
                        </div>
                    </div>
                </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>

        </div>
        </div>

   <!-- Category Modal -->
<div class="modal fade" id="catModal" role="dialog">
   <div class="modal-dialog">
       <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">New Category</h4>

        </div>
        <div class="modal-body">
        <form class="form-horizontal" method="POST" action="{{action('CategoryController@store')}}">
            {{csrf_field()}}
              <div class="form-group">
                    <label for="category_name" class="col-md-4 control-label">Category Name</label>
                    <div class="col-md-6">
                      <input id="category_name" type="text" class="form-control" name="category_name" value="" required autofocus>
                    </div>
              </div>
              <div class="form-group">
                    <label for="category_image" class="col-md-4 control-label">Category Image</label>
                    <div class="col-md-6">
                        <input type="file" class="form-control" name="category_image" multiple required>
                    </div>
              </div>
               <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <input type="submit" name="save" value="save">
                  </div>
              </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
   </div>
</div>


<!-- view subcategory Modal -->

 <div class="modal fade" id="viewsubCatModal" role="dialog">
         <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sub-Category</h4>
            </div>
            <div class="modal-body subcat">

        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>

        </div>
        </div>
                    @if(!empty($category_list))
                      <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Category Name</th>
                          <th>Category Image</th>
                          <th>Sub-Category</th>
                        </tr>
                      </thead>
                      <tbody>
                         @foreach($category_list as $c)
                        <tr>

                          <td>{{$c['category_name']}}</td>
                          <td>{{$c['category_image']}}</td>
                         <td>
                            <button type="submit" class="btn btn-default feed-id" data-id="{{$c['category_name']}}" data-toggle="modal" data-target="#viewsubCatModal">View</button>
                          </td>

                        </tr>
                        @endforeach

                      </tbody>
                    </table>
                    {!! str_replace('/?', '?', $category_list->render()) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
$(document).ready(function(){

    $(".feed-id").click(function(e){
        e.preventDefault();
        var catname = $(this).attr('data-id');
        var html='';
        $.ajax({type:"GET",url: "{{url('/subcatlist')}}",data:{"token":"{{csrf_token()}}","catname":catname}, success: function(result){

            var modal = $(this)
            for (var i = 0; i < result.length; i++){
            var name = result[i];
            console.log(name);
            html += '<li>'+name+ '</li>'
           // $("#viewsubCatModal" ).find(".modal-body subcat #subcatid").val(name);
            $('#viewsubCatModal').modal().on('show.bs.modal', function (e) {
            //$(".modal-body subcat").html(html);
            modal.find('.modal-body li').val(name)
            });
        }
           $('#viewsubCatModal').modal('show');



        }});
    });
});

</script>

@stop