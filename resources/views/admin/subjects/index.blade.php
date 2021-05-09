@extends('admin.layouts.app')

@section('content')


<div class="row">
    <div class="col-md-6">
        @include('errors.errors')
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Add Subjects</h4>
              
                <div class="material-datatables">
                <form action="{{ route('subjects.store') }}" method="post" enctype="multipart/form-data" id="form-category">
                    @csrf
                        <div class="form-group label-floating">
                            <label class="control-label">
                                Name
                                <small>*</small>
                            </label>
                            <input class="form-control"
                                name="name"
                                type="text"
                                required="true"
                            />
                        </div>

                        <div class="form-group label-floating">
                            <label class="control-label">
                                Price
                                <small>*</small>
                            </label>
                            <input class="form-control"
                                name="price"
                                type="text"
                                required="true"
                            />
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label"></label>
                            <select name="type" required="true" class="form-control">
                                <option  value="" selected="">--Choose Type--</option>
                                <option  value="art">Art</option>
                                <option  value="photo_to_art">Photo to art</option>
                            </select>
                        </div>

                        <div class="form-footer text-right">
                            <button type="submit" class="btn btn-rose btn-round btn-group  btn-fill">Submit</button>
                        </div>
                    </form>
                </div>
            </div><!-- end content-->
        </div><!--  end card  -->
    </div> <!-- end col-md-6 -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Subjects</h4>
                    <div  class="checkbox col-md-6 text-left">
                        <label>
                            <input onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" type="checkbox" name="optionsCheckboxes" > Select All
                        </label>
                    </div>
                    <div  class="col-md-6 text-right">
                        <a href="javascript:void(0)" onclick="confirm('Are you sure?') ? $('#form-categories').submit() : false;" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                            <i class="material-icons">close</i> Delete
                        </a>
                    </div> 
                    <div class="clearfix"></div> 

                    <form action="{{ route('subjects.destroy',['subject'=>1]) }}" method="post" enctype="multipart/form-data" id="form-categories">
                    @csrf
                    @method('DELETE')
                    <div class="material-datatables">
                        @foreach($subjects as $subject)
                            <div class="parent" value="{{ $subject->id }}">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="{{ $subject->id }}" name="selected[]" >
                                    {{ $subject->name }}  
                                    <a href="{{ route('subjects.edit',['subject'=>$subject->id]) }}">
                                    <i class="fa fa-pencil"></i> Edit</a> 
                                </label>
                            </div>   
                        </div>
                        @endforeach  
                    </div>
                </form>
            </div><!-- end content-->
        </div><!--  end card  -->
    </div> <!-- end col-md-6 -->
</div> <!-- end row -->
@endsection

@section('inline-scripts')

$(document).ready(function() {
  
});

@stop





