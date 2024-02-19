@extends('layouts.listing')
@section('content')

<header>
  <div class="page-header min-vh-75 h-28 position-relative" style="background-image: url(https://drive.google.com/thumbnail?id=1DTtgCelVMLA0F2HRS1mJw_U_b5gaksbg&sz=w2000); background-position: top;" loading="lazy">
    <span class="position-absolute top-0 start-0 w-100 h-100  bg-black opacity-50"></span>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto text-white text-center">
          <h1 class="title text-white">{{ $information->title }}</h1>

        </div>
      </div>
    </div>
  </div>
</header>

<div style="background-color: #f8f5f4;">

  <section id="home">
    <div class="container">
      <div class="row justifiy-content-center">
        <div id="content" class="col-md-12  mb-5">
          @if ($message = \Session::get('success'))
          <p><a href="">
              <<< Back </a>
          </p>
          <div class="alert alert-success color--light alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
          </div>
          @elseif ($errors->any() )
          <p><a href="">
              <<< Back </a>
          </p>
          <div class="alert alert-danger">
            <ul>
              @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>

          @else
          <p><?php echo  html_entity_decode($information->description);  ?></p>
          @endif
        </div>
        <div class="margin-top-35"></div>
      </div> <!-- /row -->
    </div> <!-- /container -->
  </section>



  @endsection
  @section('page-scripts')
  @stop
  @section('inline-scripts')

  const form = document.getElementById('contact');

  let input = document.querySelector('input[name="phone"]');

  form.addEventListener("submit", function (e) {
  e.preventDefault();
  if (input.value) {
  return false;
  }
  this.submit()
  return false;

  });




  @stop