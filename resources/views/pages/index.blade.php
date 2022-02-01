@extends('layouts.listing')
@section('content')

<div  style="background-color: #f8f5f4;">
   <div class="category-header header-filter" style="background-image: url({{  isset($category) && $category->image != null ? $category->image : 'https://royalbnbproperties.com/uploads/R3DxvKHrMoDy8ib2uoeo4X3yWMzjejiMoIiUMPoz.jpg'}});">
      <div class="container">
         <div class="row">
            <div class="col-md-9 text-center ml-auto mr-auto">
                <h1 class="title text-white">{{ $information->title }}</h1>
            </div>
         </div>
      </div>
   </div>
<section id="home">   
    <div class="container">
        <div class="row justifiy-content-center">        
          <div id="content" class="col-md-12  mb-5">  
              @if ($message = \Session::get('success'))
                  <p><a href=""> <<< Back </a></p>
                  <div class="alert alert-success color--light alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>	
                      <strong>{{ $message }}</strong>
                  </div>
                @elseif ($errors->any() )
                  <p><a href=""> <<< Back </a></p>
                  <div class="alert alert-danger">
                      <ul>
                          @foreach($errors->all()  as $error)
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

  let input  = document.querySelector('input[name="phone"]');

  form.addEventListener("submit", function (e) { 
    e.preventDefault();
    if (input.value) {
        return false;
    }
    this.submit()
    return false;

  });

  

   
@stop
