@extends('admin.layouts.app')

@section('content')

<div class="row">
   <div class="col-md-12">
        <div class="text-right">
            <a href="{{ route('settings.index') }}" rel="tooltip" title="Refresh" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">refresh</i>
                Refresh
            </a>
            <a href="{{ route('settings.create') }}" rel="tooltip" title="Add New" class="btn btn-primary btn-simple btn-xs">
                    <i class="material-icons">add</i>
                    Add Settings
            </a>
            <a href="javascript:void(0)" onclick="confirm('Are you sure?') ? $('#form-setting').submit() : false;" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                <i class="material-icons">close</i>
                Remove
            </a>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Settings</h4>


                
                <div class="material-datatables">
                <form action="{{ route('settings.destroy',['setting'=>1]) }}" method="post" enctype="multipart/form-data" id="form-setting">
            
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>

                            <tr>
                                <th>
                                <div class="checkbox">
                                        <label>
                                            <input onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" type="checkbox" name="optionsCheckboxes" >
                                        </label>
                                    </div>
                                
                                </th>

                                <th>Store Name</th>
                                <th>Store Url</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                            <th>
                                
                            </th>
                                <th>Store Name</th>
                                <th>Store Url</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($settings as $setting)
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="" name="selected[]" >
                                        </label>
                                    </div>
                                </td>
                                <td>{{ $setting->store_name }}</td>
                                <td></td>
                                
                                <td class="text-right">
                                    <a href="{{ route('settings.edit',['setting'=>$setting->id]) }}" rel="tooltip" title="Edit" class="btn btn-primary btn-simple btn-xs">
                                        <i class="material-icons">edit</i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                            
                            
                        </tbody>
                    </table>
                    </form>
                </div>
            </div><!-- end content-->
        </div><!--  end card  -->
    </div> <!-- end col-md-12 -->
</div> <!-- end row -->
@endsection

@section('inline-scripts')

@stop





