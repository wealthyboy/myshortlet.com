@extends('layouts.listing')
@section('content')
<div class="container-fluid">












   <h2 class="elements">Account</h2>
   <div class="row justify-content-center">

      @foreach($nav as $key => $n)
      <div class="col-6 col-sm-4 col-md-3 col-lg-2">
         <a href="{{ $n['link'] }}" class="icon-box nounderline">
            <i class="{{ $n['icon'] }}">{{ $n['iconText'] }}</i>
            <h5 class="porto-sicon-title mx-2">{{ $key }}</h5>
         </a>
      </div>
      @endforeach

      <div class="col-6 col-sm-4 col-md-3 col-lg-2">
         <a href="#" class="icon-box nounderline" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt left"></i>
            <h5 class="porto-sicon-title mx-2">Logout</h5>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
               @csrf
            </form>
         </a>
      </div>



   </div>

</div>
@endsection
@section('page-scripts')
@stop