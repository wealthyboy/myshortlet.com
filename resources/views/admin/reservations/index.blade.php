@extends('admin.layouts.app')

@section('content')

<div class="row">
   <div class="col-md-12">
      <div class="text-right">

         <a href="" rel="tooltip" title="Refresh" class="btn btn-primary btn-simple btn-xs">
            <i class="material-icons">refresh</i>
            Refresh
         </a>

         <a href="/admin/reservations/create?coming_from=checkin" rel="tooltip" title="Add" class="btn btn-primary btn-simple btn-xs">
            <i class="material-icons">add</i>Add Reservation
         </a>

         <a href="javascript:void(0)" onclick="confirm('Are you sure?') ? $('#form-apartments').submit() : false;" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
            <i class="material-icons">close</i>
            Remove
         </a>


      </div>
   </div>

   <div class="col-md-12">
      <div class="card">
         <div class="card-header card-header-icon" data-background-color="rose">
            <i class="material-icons">Filter</i>
         </div>
         <div class="card-content">
            <h4 class="card-title">Filter - <small class="category"></small></h4>

            <form action="{{request()->fullUrl()}}" method="GET">
               <div class="form-row">
                  <div class="form-group col-md-3">
                     <label for="date">From</label>
                     <input type="date" class="form-control" id="from-date" name="from">
                     <input type="hidden" name="coming_from" value="{{ request('coming_from') }}">
                  </div>

                  <div class="form-group col-md-3">
                     <label for="date">To</label>
                     <input type="date" class="form-control" id="to-date" name="to">
                  </div>

                  <div class="form-group col-md-3 ">
                     <label for="date">Apartments </label>

                     <select name="apartment_id" id="" class="form-control">
                        <option value="">Choose one</option>
                        @foreach($apartments as $apartment)
                        <option value="{{$apartment->id}}">{{$apartment->name}}</option>
                        @endforeach

                     </select>
                  </div>


                  <div class="form-group col-md-3">
                     <label for="email">Email</label>
                     <input type="email" class="form-control" id="email" name="email">
                  </div>
                  <div class="form-group col-md-3">
                     <label for="phone">Phone</label>
                     <input type="tel" class="form-control" id="phone" name="phone">
                  </div>

                  <div class="form-group col-md-2">
                     <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
               </div>
            </form>

         </div>
      </div>
   </div>



   <div class="col-md-12">
      <div class="card">

         <div class="card-content">

            <h4 class="card-title">Reservations</h4>
            <div class="toolbar">
               <!-- Here you can write extra buttons/actions for the toolbar              -->
            </div>
            <div class="material-datatables">
               <form action="{{ route('admin.reservations.destroy',['reservation'=>1]) }}" method="post" enctype="multipart/form-data" id="form-apartments">
                  @method('DELETE')
                  @csrf

                  <table id="datatables" class="table table-striped table-shopping table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                     <thead>

                        <tr>
                           <th>
                              <div class="checkbox">
                                 <label>
                                    <input onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" type="checkbox" name="optionsCheckboxes">
                                 </label>
                              </div>
                           </th>
                           <th>Invoice</th>
                           <th>Customer</th>
                           <th>Date Added</th>
                           <th>Total</th>
                           <th class="text-right"></th>
                        </tr>
                     </thead>

                     <tbody>
                        @foreach ($reservations as $reservation )
                        <tr>
                           <td>
                              <div class="checkbox">
                                 <label>
                                    <input type="checkbox" value="{{ $reservation->id }}" name="selected[]">
                                 </label>
                              </div>
                           </td>

                           <td class="text-left">{{ $reservation->invoice }}</td>
                           <td>{{ $reservation->guest_user?->fullname() }}</td>
                           <td>{{ $reservation->created_at }}</td>
                           <td class="text-left">{{ $reservation->currency  ?? '₦'}}{{ number_format($reservation->total) }}</td>

                           <td class="td-actions ">
                              @if(!$reservation->is_cancelled)
                              <span><a href="{{ route('admin.reservations.show',['reservation'=>$reservation->id]) }}" rel="tooltip" class="btn btn-success btn-simple" data-original-title="" title="View">
                                    more details
                                 </a></span>
                              <span>
                                 <a data-url="/admin/reservations/resendLink?id={{ $reservation->id }}" href="#" rel="tooltip" class="btn btn-success  resend-link btn-simple" data-original-title="" title="Link">
                                    Send check-in link
                                 </a>
                              </span>


                              <span>
                                 <a href="/admin/reservations?cancel=1&id={{ $reservation->id }}" rel="tooltip" class="btn btn-danger btn-simple" data-original-title="" title="Cancel">
                                    cancel
                                 </a>
                              </span>


                              @else
                              <span class="btn btn-danger btn-simple">
                                 Cancelled
                              </span>
                              @endif
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </form>
            </div>
            <div class="pull-right">{{ $reservations->links() }}</div>
         </div><!-- end content-->
      </div><!--  end card  -->
   </div> <!-- end col-md-12 -->
</div> <!-- end row -->
@endsection
@section('page-scripts')
<script src="{{ asset('backend/js/products.js') }}"></script>
@stop
@section('inline-scripts')
$(document).ready(function() {

});
@stop