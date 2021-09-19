@extends('layouts.user')
@section('content')
<div class="container-fluid">
  <div class="row">
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
                              <td colspan="3" class="RegularTextTD" data-link-style="text-decoration:none; color:#67bffd;" data-link-color="RegularLink" data-color="RegularTXT" style="margin-left: 3px;color: #000;font-family: sans-serif;font-size: 13px;font-weight: lighter;line-height: 23px;">
                                 {{ optional($user_reservation->property)->address }}  <br/>  
                                 <div style="font-size: 18px;font-weight: bold;">Check-in - Check-out:</div>
                                 {{ $user_reservation->checkin->isoFormat('dddd, MMMM Do YYYY') }} - {{ $user_reservation->checkout->isoFormat('dddd, MMMM Do YYYY') }}  
                                 <div style="font-size: 18px;font-weight: bold;">Property Contact:</div>
                                 Email: {{ optional(optional($user_reservation->property)->user)->email }} <br/> Phone number: {{  optional(optional($user_reservation->property)->user)->phone_number }}
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
</div>
@endsection
@section('page-scripts')
@stop