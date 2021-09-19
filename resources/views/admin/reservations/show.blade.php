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
                        <td><a href="" target="_blank">{{  Config('app.name') }}</a></td>
                     </tr>
                     <tr>
                        <td><button data-toggle="tooltip" title="Date Added" class="btn btn-info btn-xs"><i class="fa fa-calendar fa-fw"></i></button></td>
                        <td>{{ $user_reservation->created_at }}</td>
                     </tr>
                     <tr>
                        <td><button data-toggle="tooltip" title="Payment Method" class="btn btn-info btn-xs"><i class="fa fa-credit-card fa-fw"></i></button></td>
                        <td>{{ $user_reservation->payment_type }}</td>
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
                  <h3 class="panel-title"><i class="fa fa-user"></i> Customer Details</h3>
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
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-cog"></i> Options</h3>
               </div>
               <table class="table">
                  <tbody>
                     <tr>
                        <td>Invoice</td>
                        <td id="invoice" class="text-right">{{ $user_reservation->invoice  }}</td>
                        <td style="width: 1%;" class="text-center"><button disabled="disabled" class="btn btn-success btn-xs"><i class="fa fa-refresh"></i></button>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-12">
      <div class="card">
         <div class="card-header card-header-icon" data-background-color="rose">
            <i class="material-icons">assignment</i>
         </div>

         <div class="card-content">
            <h4 class="card-title">Address</h4>
         <div class="table-responsive">
            <table class="table table-bordered">
            
            <tr>
               <td valign="top" align="center">
                  <table class="tableTxt" width="252" cellspacing="0" cellpadding="0" border="0" align="left">
                     
                     <tr>
                        <td class="RegularText4TD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="SectionInfoLink" data-color="SectionInfoTXT" style="color: #425065;font-family: sans-serif;font-size: 18px;font-weight: bold;text-align: left;line-height: 23px;" width="179" valign="top" align="left"><a href="#" target="_blank" style="text-decoration: none;color: #67bffd;font-weight: bold;" data-color="SectionInfoLink"></a>Property Address</td>
                     </tr>
                     
                     <tr>
                        <td colspan="3" class="RegularTextTD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="RegularLink" data-color="RegularTXT" style="margin-left: 3px;color: #000;font-family: sans-serif;font-size: 13px;font-weight: lighter;line-height: 23px;"> {{ optional($user_reservation->property)->address }}  <br/>  <div style="font-size: 18px;font-weight: bold;">Check-in - Check-out:</div> {{ $user_reservation->checkin->isoFormat('dddd, MMMM Do YYYY') }} - {{ $user_reservation->checkout->isoFormat('dddd, MMMM Do YYYY') }}  <div style="font-size: 18px;font-weight: bold;">Property Contact:</div>  Email: {{ optional(optional($user_reservation->property)->user)->email }} <br/> Phone number: {{  optional(optional($user_reservation->property)->user)->phone_number }}</td>
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
                        <th class="text-center">Image</th>
                        <th class="th-description">Apartment name</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Amount</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ( $user_reservation->reservations as $reservation )
                     <tr>
                        <td>
                           <div class="img-container">
                              <img src="{{ optional($reservation->property)->image }}" alt="...">
                           </div>
                           <div class="form-group label-floating">
                             <input type="hidden" class="p-v-id" value="{{ $reservation->id }}" />
                              <select  class="form-control mt-3 update_status" name="reservation_status[{{ $reservation->id }}]" id="">
                                 <option value="" >Choose Status</option>
                                 @foreach($statuses as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                 @endforeach
                              </select>
                              <div class="">
                                    <small href=""
                                       >{{ optional($reservation->apartment)->max_adults + optional($reservation->apartment)->max_children }}
                                       Guests,
                                       {{ optional($reservation->apartment)->no_of_rooms }} bedroom</small
                                    >
                              </div>
                           </div>
                        </td>
                        <td class="td-name">
                           <a href="">{{ optional($reservation->apartment)->name ?? optional(optional($reservation->apartment)->property)->name }}</a>
                           <br><small></small>
                        </td>
                        
                      
                        <td class="td-number text-right">
                           {{  $reservation->currency }}{{  optional($reservation->apartment)->converted_price   }}
                        </td>
                        <td class="td-number">
                           {{ $reservation->quantity }}
                        </td>
                        <td class="td-number">
                           <small>{{  $reservation->currency }}</small>{{ optional($reservation->apartment)->converted_price }}
                        </td>
                     </tr>
                     @endforeach                               
                  </tbody>
               </table>
               <table class="table ">
                  <tfoot>
                     <tr>
                        <td colspan="6" class="text-right">Sub-Total</td>
                        <td class="text-right"><small>{{ $user_reservation->currency }}</small>{{ number_format($sub_total)  }}</td>
                     </tr>
                     <tr>
                        <td colspan="6" class="text-right">Coupon</td>
                        <td class="text-right">   &nbsp; {{  $user_reservation->coupon ?  $user_reservation->coupon.'  -%'.$user_reservation->voucher()->amount . 'off'  : '---' }}</td>
                     </tr>
                     
                     <tr>
                        <td colspan="6" class="text-right">Total</td>
                        <td class="text-right">{{ $user_reservation->currency }}{{  $user_reservation->total }}</td>
                     </tr>
                  </tfoot>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
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

