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
      <div class="row" bis_skin_checked="1">
         <div class="col-lg-3 col-md-6 col-sm-6" bis_skin_checked="1">
            <div class="card card-stats" bis_skin_checked="1">
               <div class="card-header card-header-warning card-header-icon" bis_skin_checked="1">
                  <h4 class="card-category"><a href="?referer=google">Google</a></h4>
                  <h3 class="card-title">{{$sourceCounts['google']}}</h3>
               </div>

            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6" bis_skin_checked="1">
            <div class="card card-stats" bis_skin_checked="1">
               <div class="card-header card-header-rose card-header-icon" bis_skin_checked="1">

                  <h4 class="card-category"><a href="?referer=instagram">Instagram</a></h4>
                  <h3 class="card-title">{{$sourceCounts['instagram']}}</h3>
               </div>

            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6" bis_skin_checked="1">
            <div class="card card-stats" bis_skin_checked="1">
               <div class="card-header card-header-success card-header-icon" bis_skin_checked="1">
                  <h4 class="card-category"><a href="?referer=facebook">Facebook</a></h4>
                  <h3 class="card-title">{{$sourceCounts['facebook']}}</h3>
               </div>

            </div>
         </div>

         <div class="col-lg-3 col-md-6 col-sm-6" bis_skin_checked="1">
            <div class="card card-stats" bis_skin_checked="1">
               <div class="card-header card-header-success card-header-icon" bis_skin_checked="1">
                  <h4 class="card-category"><a href="?referer=others">Others</a></h4>
                  <h3 class="card-title">{{$sourceCounts['others']}}</h3>
               </div>

            </div>
         </div>

      </div>
      <div class="card">
         <div class="card-content">
            <h4 class="card-title">Abandoned Carts</h4>

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