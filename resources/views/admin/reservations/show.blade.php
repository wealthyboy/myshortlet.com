@extends('admin.layouts.app')
@section('content')
<div class="row">
   <div class="col-md-12">
      <div class="text-right">

      </div>
   </div>
   <div class="col-md-4">
      <div class="card">
         <div class="card-content">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> reservation Details</h3>
               </div>
               <table class="table">
                  <tbody>
                     <tr>
                        <td style="width: 1%;"><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Store"><i class="fa fa-shopping-cart fa-fw"></i></button></td>
                        <td><a href="" target="_blank">{{ Config('app.name') }}</a></td>
                     </tr>
                     <tr>
                        <td><button data-toggle="tooltip" title="Date Added" class="btn btn-info btn-xs"><i class="fa fa-calendar fa-fw"></i></button></td>
                        <td>{{ $user_reservation->created_at }}</td>
                     </tr>
                     <tr>
                        <td><button data-toggle="tooltip" title="Payment Method" class="btn btn-info btn-xs"><i class="fa fa-credit-card fa-fw"></i></button></td>
                        <td>{{ $user_reservation->payment_type }}</td>
                     </tr>
                     <tr>
                        <td>Invoice</td>
                        <td id="invoice" class="text-right">{{ $user_reservation->invoice  }}</td>
                        <td style="width: 1%;" class="text-center"><button disabled="disabled" class="btn btn-success btn-xs"><i class="fa fa-refresh"></i></button>
                        </td>
                     </tr>

                     <tr>
                        <td><button data-toggle="tooltip" title="Payment Method" class="btn btn-info btn-xs"><i class="fa fa-credit-card fa-fw"></i></button></td>
                        <td>

                           <a href="?delete=true&id={{$user_reservation->id}}" class="href">delete</a>
                        </td>
                     </tr>


                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-4">
      <div class="card">
         <div class="card-content">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-user"></i> Agent Details</h3>
               </div>
               <table class="table">
                  <tbody>
                     <tr>
                        <td style="width: 1%;"><button data-toggle="tooltip" title="Customer" class="btn btn-info btn-xs"><i class="fa fa-user fa-fw"></i></button></td>
                        <td> <a href="" target="_blank">{{ $user_reservation->user->fullname() }}</a></td>
                     </tr>
                     <tr>
                        <td><button data-toggle="tooltip" title="E-Mail" class="btn btn-info btn-xs"><i class="fa fa-envelope-o fa-fw"></i></button></td>
                        <td><a href="">{{ $user_reservation->user->email }}</a></td>
                     </tr>
                     <tr>
                        <td><button data-toggle="tooltip" title="Telephone" class="btn btn-info btn-xs"><i class="fa fa-phone fa-fw"></i></button></td>
                        <td>{{ $user_reservation->user->phone_number }}</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-4">
      <div class="card">
         <div class="card-content">
            <a target="_blank" href="{{$user_reservation->guest_user->image }}">
               <img src="{{$user_reservation->guest_user->image }}" alt="" srcset="">
            </a>

         </div>
      </div>
   </div>
  
   <div class="col-md-12">
      <div class="card">

         <div class="card-content">
            <h4 class="card-title">Modify Reservation - <small class="category"></small></h4>

            <form id="UpdateForm" data-url="{{request()->fullUrl()}}?add_update=1" action="?add_update=1" method="GET">
               <div class="form-row">
                

                  <div class="form-group col-md-3">
                     <label for="date">Check-out</label>
                     <input class="form-control  datepicker pull-right" name="checkout" id="checkout-update" type="text" required>
                  </div>
               

                  <div class="form-group col-md-2">
                     <button id="add-update" type="submit" class="btn btn-primary">
                        Submit
                        <span id="spinner-update" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                     </button>
                  </div>
               </div>

             
            </form>

           

         </div>
        
       
      </div>
      
   </div>

   <div class="col-md-12">

   @if($user_reservation->reservations[0]->extension_date)

   <div class="card">
      <div class="card-content">
            <div  class="">
            <h5 class="card-title">{{ $user_reservation->reservations[0]->extension_date }}</h5>
            </div>
      </div>
   </div>
   @endif

   </div>
   <div class="col-md-12">
      <div class="card">
         <div class="card-header card-header-icon" data-background-color="rose">
            <i class="material-icons">assignment</i>
         </div>

         <div class="card-content">
            <h4 class="card-title">Booking Details</h4>
            <div class="table-responsive">
               <table class="table table-bordered">

                  <tr>
                     <td valign="top" align="center">
                        <table class="tableTxt" width="252" cellspacing="0" cellpadding="0" border="0" align="left">
                           <tr>
                              <td>
                                 <h4>Guests</h4>
                                 <div>
                                    <b>Name:</b> {{$user_reservation->guest_user->name }} {{ $user_reservation->guest_user->last_name}}
                                 </div>
                                 <div>
                                    <b>Email:</b> {{$user_reservation->guest_user->email }}
                                 </div>
                                 <div>
                                    <b>Phone Number:</b> {{$user_reservation->guest_user->phone_number }}
                                 </div>
                              </td>
                           </tr>

                           <tr>
                              <td colspan="3" style="font-size:0;line-height:0;" height="25"></td>
                           </tr>
                        </table>
                     </td>
                  </tr>
               </table>


               <div class="card-content">

                  <h2>Apartment</h2>
                  <table class="table table-shopping">
                     <thead>
                        <tr>
                           <th class="th-description">Apartment name</th>
                           <th class="text-left">Check-in</th>
                           <th class="text-left">Check-out</th>
                           <th class="text-right">Price</th>
                           <th class="text-right">Nights</th>
                           <th class="text-right">Amount</th>
                           <th class="text-right"></th>

                        </tr>
                     </thead>
                     <tbody>
                        @foreach ( $user_reservation->reservations as $reservation )
                        <tr>

                           <td class="td-name">
                              <a href="">{{ optional($reservation->apartment)->name ?? optional($reservation->attribute)->name }}</a>
                              <br><small></small>
                           </td>

                           <td>{{ optional($reservation->checkin)->isoFormat('dddd, MMMM Do YYYY') }}</td>
                           <td class="text-center">{{ optional($reservation->checkout)->isoFormat('dddd, MMMM Do YYYY') }}</td>


                           <td class="td-number text-right">
                              {{ $user_reservation->currency  ?? '₦' }}{{ number_format(optional($reservation->apartment)->converted_price)   }}
                           </td>
                           <td class="td-number">
                              {{ $reservation->checkin->diffInDays($reservation->checkout); }}
                           </td>
                           <td class="td-number">
                              <small>{{ $user_reservation->currency  ?? '₦' }}</small>{{ number_format(optional($reservation->apartment)->converted_price) }}
                           </td>

                           <td class="td-number">
                              <a href="?delete=true&id={{ $user_reservation->id}}">delete</a>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  <table class="table ">
                     <tfoot>
                        <tr>
                           <td colspan="6" class="text-right">Sub-Total</td>
                           <td class="text-right"><small>{{ $reservation->currency  ?? '₦' }}</small>{{ number_format($user_reservation->original_amount)  }}</td>
                        </tr>
                        <tr>
                           <td colspan="6" class="text-right">Coupon</td>
                           <td class="text-right"> &nbsp; {{ $user_reservation->coupon ?  $user_reservation->coupon.'  -%'.$user_reservation->voucher()->amount . 'off'  : '---' }}</td>
                        </tr>

                        <tr>
                           <td colspan="6" class="text-right">Total</td>
                           <td class="text-right">{{ $reservation->currency  ?? '₦'  }}{{ number_format($user_reservation->total) }}</td>
                        </tr>
                     </tfoot>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   @section('page-scripts')
   <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
   <script src="{{ asset('backend/js/products.js') }}"></script>
   <script src="{{ asset('backend/js/uploader.js') }}"></script>
   @stop
   <!-- end row -->
   @endsection
   @section('inline-scripts')




   $(".update_status").on('change',function(e){
   let self = $(this)
   if(self.val() == '') return;

   let value = self.parent().find(".p-v-id").val()
   var payLoad = { reservationed_product_id: value,status: self.val()}
   $.ajax({
   type: "POST",
   url: "/admin/update/reservationed_product/status",
   data: payLoad,
   }).done(function(response){
   console.log(response)
   })
   })
   @stop