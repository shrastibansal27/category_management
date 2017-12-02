@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">New Category</div>
                <div class="col-md-12 offset-md-4">
                                <button type="submit" class="btn btn-warning">
                                    Add Sub-Category
                                </button>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('save_category') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('category_name') ? ' has-error' : '' }}">
                            <label for="category_name" class="col-md-4 control-label">Category Name</label>

                            <div class="col-md-6">
                                <input id="category_name" type="text" class="form-control" name="category_name" value="{{ old('category_name') }}" required autofocus>

                                @if ($errors->has('category_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('category_image') ? ' has-error' : '' }}">
                            <label for="category_image" class="col-md-4 control-label">Category Image</label>

                            <div class="col-md-6">
                                <input id="category_image" type="file" class="form-control" name="category_image" multiple required>

                                @if ($errors->has('category_image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category_image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="btn-group">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-danger">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
