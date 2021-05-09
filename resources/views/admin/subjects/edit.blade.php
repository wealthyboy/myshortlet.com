@extends('admin.layouts.app')

@section('content')


<div class="row">
    <div class="col-md-6">
        @include('errors.errors')
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Add Subjects</h4>
              
                <div class="material-datatables">
                <form  action="{{ route('subjects.update',['subject' => $subject->id ]) }}" method="post">
                    @csrf
                    
                   @method('PATCH')
                        <div class="form-group label-floating">
                            <label class="control-label">
                                Name
                                <small>*</small>
                            </label>
                            <input class="form-control"
                                name="name"
                                type="text"
                                required="true"
                                value="{{ $subject->name }}"
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
                                value="{{ $subject->price }}"
                            />
                        </div>
                        
                        

                        
                        <div class="form-group">
                            <label class="control-label"></label>
                            <select name="type" required="true" class="form-control">
                                <option  value="" selected="">--Choose Type--</option>
                                <option {{ $subject->type == 'art' ? 'selected' :  '' }}  value="art">Art</option>
                                <option  {{ $subject->type == 'photo_to_art' ? 'selected' :  '' }} value="photo_to_art">Photo to art</option>
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
    
</div> <!-- end row -->
@endsection

@section('inline-scripts')

$(document).ready(function() {
  
});

@stop





