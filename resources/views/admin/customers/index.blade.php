@extends('admin.layouts.app')

@section('content')

<div class="row">
    

        <div class="col-md-12">
           <div class="card">
               <div class="card-header card-header-icon" data-background-color="rose">
                   <i class="material-icons">Filter</i>
               </div>
               <div class="card-content">
                   <h4 class="card-title">Filter - <small class="category"></small></h4>
                   <form action="{{ '' }}" method="get">
                       <div class="row">
                           <div class="col-md-10">
                                <div class="form-group label-floating ">
                                    <label class="control-label">Search Users</label>
                                    <input required   type="text" value="" name="q" class="form-control" >
                                </div>
                           </div>
                       </div>
                       <input name="search" type="submit" value="search" class="btn btn-rose  btn-round pull-right">
                       <div class="clearfix"></div>
                   </form>
               </div>
           </div>
        </div>

        <div class="col-md-12">
            <div class="card">
            <div class="text-right">
           
                <a href="javascript:void(0)" onclick="confirm('Are you sure?') ? $('#form-customers').submit() : false;" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                    <i class="material-icons">close</i>
                    delete
                </a>

            </div>
        
       
        
                <div class="card-content">

                    <h4 class="card-title">Merchants/Buyers</h4>
                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div class="material-datatables">
                    <form action="{{ route('customers.destroy',['customer' => 1]) }}" method="post" enctype="multipart/form-data" id="form-customers">
                       @csrf
 
                        @method('DELETE')
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

                                    <th>Full name</th>

                                    <th>Email</th>
                                    <th>Phone</th>

                                    <th class="disabled-sorting text-right">Date</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                            @foreach($users as $user)

                                <tr>
                                   <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="{{ $user->id }}" name="selected[]" >
                                            </label>
                                        </div>
                                    </td>
                                    <td><a href="{{ route('customers.show',['customer' =>  $user->id] ) }}">{{ $user->fullname() }}</a></td>
                                    <td class="text-left">{{ $user->email }}</td>
                                    <td class="text-right">{{ $user->phone_number }}</td>
                                    <td class="text-right">
                                       {{ $user->created_at }}
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
@section('pagespecificscripts')
<script src="/assets/js/jquery.datatables.js"></script>
@stop


@section('inline-scripts')
$(document).ready(function() {
		$('#datatables').DataTable({
			"pagingType": "full_numbers",
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			responsive: true,
			language: {
			search: "_INPUT_",
			searchPlaceholder: "Search records",
			}

		});


		
		$('.card .material-datatables label').addClass('form-group');
	});
@stop





