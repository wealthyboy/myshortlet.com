@extends('admin.layouts.app') @section('content')
<div class="row">
    <div class="col-md-12">
        <div class="text-right">
            <a href="{{ route('vouchers.index') }}" rel="tooltip" title="back" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">reply</i>
            </a>
        </div>
    </div>
    <div class="col-md-12">

        <div class="card">
            @include('errors.errors')
            <div class="card-content">
                <h4 class="card-title">Peak Periods</h4>
                <div class="toolbar">
                    <!-- Here you can write extra buttons/actions for the toolbar-->
                </div>
                <div class="material-datatables">
                    <form action="{{ route('peak_periods.store') }}" method="post">
                        @csrf
                        <div class="col-lg-4 col-sm-4">
                           <div class="input-group">
                              <span class="input-group-addon">
                                 <i class="fa fa-dollar"></i>
                              </span>
                              <input name="discount" required value="" placeholder="Discount in (%)" id="input-discount-name" class="form-control" type="number">
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
                                <input class="form-control  pull-right" name="start_date" id="" type="date">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</span>
                                <input class="form-control  pull-right" name="end_date" id="" type="date">
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</span>
                                <input class="form-control  pull-right" name="days_limit" id="" type="text">
                            </div>
                        </div>
                       
                        

                        <div class="clearfix"></div>
                        <input value="search" name="search" type="hidden">
                        <div class="form-group text-right">
                            <button type="submit" id="button-filter" class="btn btn-primary btn-round"><i class=""></i> Submit</button>
                        </div>
                </div>
                </form>

            </div>
            <!-- end content-->
        </div>
        <!--  end card  -->
    </div>
    <!-- end col-md-12 -->
</div>
<!-- end row -->
@endsection @section('page-scripts')
<script src="{{ asset('backend/js/moment.min.js') }}"></script>
<script src="{{ asset('backend/js/bootstrap-datetimepicker.js') }}"></script>
@stop @section('inline-scripts') $(document).ready(function() { s.initFormExtendedDatetimepickers(); }); @stop