@if (session('success'))
    <div class="alert alert-success alert-dismissible ">
        <button type="button" aria-hidden="true"  data-dismiss="alert" style="margin-right: 20px;" class="close">
             <i class="far fa-times"></i>            
        </button> 
        <strong>{{ session('success') }}</strong>
    </div>
@endif