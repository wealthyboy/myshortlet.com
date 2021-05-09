@extends('admin.layouts.app')

@section('content')


<div class="row">
    <div class="col-md-6">
        @include('errors.errors')
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Add Sizes</h4>
              
                <div class="material-datatables">
                <form  action="{{ route('sizes.update',['size' => $size->id ]) }}" method="post">
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
                                value="{{ $size->name }}"
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
                                value="{{ $size->price }}"
                            />
                        </div>
                        <div class="">
                            <h3 class="info-text">Subjects</h3>
                            <div class="well well-sm" style="height: 200px; background-color: #fff; color: black; overflow: auto;">
                                <ul class="treeview" data-role="treeview">
                                    @foreach($subjects as $subject)
                                        <li data-caption="Documents">
                                            <div class="checkbox">
                                    
                                                <label>
                                                    <input type="checkbox" 
                                                    {{ $subject->check($size->subjects , $subject->id) ? 'checked' : '' }} 
                                                    value="{{ $subject->id }}" name="subject_id[]" >
                                                    {{ $subject->name }}  
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                    
                                </ul>
                            </div>
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





