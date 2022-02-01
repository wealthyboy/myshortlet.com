<div class="modal fade" id="loadModal" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="fal fa-times"></i>
          </button>
        </div>

         <div class="modal-body">
            <div class="text-center  loading-spinner">
               @include('_partials.spinner',['bgcolor' => '#333'])
            </div>
            @include('_partials.login_modal')
            @include('_partials.register_modal')

         </div>
      </div>
    </div>
  </div>