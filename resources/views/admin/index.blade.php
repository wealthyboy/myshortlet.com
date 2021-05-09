@extends('admin.layouts.app')

@section('content')
<div class="row">
   <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-content">
            <p class="category">Number of Products</p>
            <h3 class="card-title">{{ 0 }}</h3>
         </div>
         <div class="card-footer text-right">
				<div class="stats">
					<i class="material-icons text-danger">forward</i> <a href="#">View</a>
				</div>
			</div>
      </div>
   </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-content">
            <p class="category">Number of Customers</p>
            <h3 class="card-title">{{ 0 }}</h3>
         </div>
         <div class="card-footer text-right">
				<div class="stats">
					<i class="material-icons text-danger">forward</i> <a href="{{ route('customers.index') }}">View</a>
				</div>
			</div>
      </div>
    </div>
   
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-content">
            <p class="category"> Today's Sales</p>
            <h3 class="card-title">{{ 0 }}</h3>
         </div>
         <div class="card-footer text-right">
				<div class="stats">
					<i class="material-icons text-danger">forward</i> <a href="#">View</a>
				</div>
			</div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-content">
         <p class="category">Today's Sales Total </p>
            <h3 class="card-title">{{ 0 }}</h3>
         </div>
         <div class="card-footer text-right">
				<div class="stats">
					<i class="material-icons text-danger">forward</i> <a href="#">View</a>
				</div>
			</div>
      </div>
    </div>
  
</div>


@endsection
