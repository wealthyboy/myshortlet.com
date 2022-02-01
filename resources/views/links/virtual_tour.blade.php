@extends('layouts.listing')
@section('content')

<div   style="background-color: #f8f5f4; height: 100vh;">
    <div class="category-header banner-filter" style="">
      <div class="container">
         <div class="row">
            <div class="col-md-9 text-center ml-auto mr-auto">
                <h1 class="title text-white">{{ $link_name }}</h1>
            </div>
         </div>
      </div>
    </div>
    <section class="mt-5 mb-5" id="home">   
        <div class="container">
            <div class="row justifiy-content-center">        
                <div class="col-md-6">
                    <div class=" position-relative ">
                        <iframe height="400" src="https://my.matterport.com/show/?m=wWcGxjuUuSb&utm_source=hit-content-embed" allowfullscreen="" class="w-100"></iframe>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="item position-relative ">
                    <iframe height="400" src="https://my.matterport.com/show/?m=wWcGxjuUuSb&utm_source=hit-content-embed" allowfullscreen="" class="w-100"></iframe>

                    </div>
                </div>
            
            </div> <!-- /row -->
        </div> <!-- /container -->
    </section>


 
@endsection
