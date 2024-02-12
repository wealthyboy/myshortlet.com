@extends('layouts.checkout')

@section('content')


<div class="page-contaiter">
    <!--Content-->
    <section style="height: 100vh;" class="sec-padding--lg vh-100">
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4 d">
                    <div class="error-page text-center">
                        <h1>404</h1>
                        <h3>Oops, page not found.</h3>
                        <p class="large">It looks like nothing was found at this location. Click the link below to return home.</p>
                        <a href="/" class="btn">Back to Home</a>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Content-->
</div>
@endsection