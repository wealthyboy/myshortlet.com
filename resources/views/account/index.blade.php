@extends('layouts.auth')

@section('content')


<div class="container-fluid ">
   <h2 class="bold-2">Account</h2>
   <div style="height: 65vh; overflow: hidden;">

      <div class="row">

         @foreach($nav as $key => $n)
         <div class="col-6 col-sm-4 col-md-3 text-center  col-lg-2">
            <a href="{{ $n['link'] }}" class="icon-box nounderline">
               <i class="{{ $n['icon'] }}">{{ $n['iconText'] }}</i>
               <h5 class="porto-sicon-title mx-2 bold-2 text-black">{{ $key }}</h5>
            </a>
         </div>
         @endforeach

         <div class="col-6 col-sm-4 col-md-3 text-center col-lg-2">
            <a href="#" class="icon-box nounderline" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
               <i class="fas fa-sign-out-alt left"></i>
               <h5 class="porto-sicon-title mx-2 bold-2 text-black">Logout</h5>

               <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
               </form>
            </a>
         </div>
      </div>




   </div>

</div>
@endsection
@section('page-scripts')
@stop