@extends('admin.layouts.app')
@section('content')
<div class="row">
   <div class="col-md-12">
      <div class="text-right">
         <a href="{{ route('admin.abandoned_carts.index') }}" rel="tooltip" title="Refresh" class="btn btn-primary btn-simple btn-xs">
            <i class="material-icons">refresh</i>
            Refresh
         </a>

      </div>
   </div>
   <div class="col-md-12">
      <div class="card">
         <div class="card-content">
            <h4 class="card-title">Abandoned Carts</h4>
            <div class="toolbar">
               <!--        Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
               <form action="{{ route('admin.visits.destroy',['visit'=>1]) }}" method="post" enctype="multipart/form-data" id="form-vouchers">
                  @method('DELETE')
                  @csrf
                  <table id="datatables" class="table table-striped table-shopping table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                     <thead>
                        <tr>
                           <td class="text-left"> Ip Address</td>
                           <td class="text-left"> Name</td>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($carts as $cart )
                        <tr>

                           <td class="">
                              <a href="/admin/abandoned-carts/{{$cart->id}}">
                                 {{$cart->ip_address ?  $cart->ip_address : 'N/A'}}

                              </a>
                           </td>

                           <td class="">
                              <div>
                                 {{$cart->first_name ?  $cart->first_name . ' '. $cart->last_name : 'N/A'}}
                              </div>
                           </td>
                        </tr>
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
<script src="/asset/js/jquery.datatables.js"></script>
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
});
@stop