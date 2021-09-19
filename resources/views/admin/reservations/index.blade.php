@extends('admin.layouts.app')
@section('content')


<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-content">
            <div class="col-md-12">
               <div class="text-left">
                  <h4 class="card-title">reservations</h4>
               </div>
               <div class="text-right">
               </div>
            </div>
            
            <div class="material-datatables">
            <form action="" method="post" enctype="multipart/form-data" id="form-reservations">
                
                <table id="datatables" class="table table-striped table-shopping table-no-breservationed table-hover" cellspacing="0" width="100%" style="width:100%">
                     <thead>
                        <tr>
                           
                           <th>Invoice</th>
                           <th>Customer</th>
                           <th>Check-in</th>
                           <th>Check-out</th>
                           <th>Date Added</th>
                           <th>Total</th>
                           <th class="text-right">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                       @foreach ($reservations as $reservation )
                            <tr>
                            
                            <td class="text-left">{{ $reservation->invoice }}</td>
                            <td>{{ $reservation->user->fullname() }}</td>
                            <td>{{ $reservation->checkin->isoFormat('dddd, MMMM Do YYYY') }}</td>
                            <td>{{ $reservation->checkout->isoFormat('dddd, MMMM Do YYYY') }}</td>
                            <td>{{ $reservation->created_at }}</td>
                            <td class="text-left">{{ $reservation->currency  ?? '₦'}}{{ $reservation->total }}</td>
                            <td class="td-actions text-center">
                              <span><a href="{{ route('admin.reservations.show',['reservation'=>$reservation->id]) }}" rel="tooltip" class="btn btn-success btn-simple" data-original-title="" title="View">
                                 <i class="fa fa-eye"></i>
                              </a></span>
                           </td>
                        @endforeach   
                        
                     </tbody>
                  </table>
                  </form>

               
            </div>
         </div>
         <!-- end content-->
      </div>
      <!--  end card  -->
   </div>
   <!-- end col-md-12 -->
</div>
<!-- end row -->
@endsection
@section('pagespecificscripts')
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

    $('#cat_sub_cat_id').on('change',function(){
       $name = $(this).find(':selected').data('name');
       $(this).attr('name', $name);
    });
    s.initFormExtendedDatetimepickers();
});
@stop
