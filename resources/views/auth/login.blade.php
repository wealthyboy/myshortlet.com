@extends('layouts.auth')
 
@section('content')
   
 <!--Content-->
    <section class="sec-padding bg--gray mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="ml-1 col-md-6  bg--light mr-1">
                    <div class=" mt-4 mb-4">
                        @include('_partials.login')
                    </div>
                </div>
            </div>
        </div>
    </section>
<!--End Content-->
@endsection
