<section   class="fadeInRight animated">

   <h2>Cancellation</h2>
   @if(isset($apartment) && isset($update))
      <form  class="form-row" method="POST"  action="{{ route('properties.update',['property'=>$apartment->id,'type'=>$type, 'step' => 'three','update' => 1,'token' => request()->token,  'back_one' => request()->back_one ])  }}">
   @else
      <form  method="POST"  action="{{ route('properties.store',['type'=>$type,'step' => 'three','token' => request()->token, 'back_two' => request()->back_two]) }}">
   @endif

   @csrf
   @if(isset($apartment)   && isset($update) )
      @method('PATCH')
   @endif

   <div class="row">
      <div class="col-sm-6">
         <ul class="list-group list-group-no-border">
            <li class="list-group-item px-0 pt-0 pb-2">
               <div class="custom-control cancel custom-checkbox">
                  <input
                     type="checkbox"
                     class="custom-control-input"
                     name="allow_cancellation"
                     id="allow_cancellation"
                     value="1"
                     {{ isset($apartment) &&  $apartment->allow_cancellation ? 'checked' : ''}}
                     />
                  <label class="custom-control-label" for="allow_cancellation">Allow Cancellation </label>
               </div>
            </li>
         </ul>
      </div>
      <div class="col-sm-7  cancellation-message    {{ isset($apartment) &&  $apartment->allow_cancellation ? '' : 'd-none'}} ">
         <div class="form-group">
            <label for="cancellation_message">Cancellation Policy</label>
            <textarea class="form-control" name="cancellation_message" id="cancellation_message" rows="5">{{ isset($apartment) ?   $apartment->cancellation_message : '' }}</textarea>
         </div>
      </div>
 
      <div class="col-md-12">
         <div class="form-row">
            <div class=" col-md-6">
               @if(isset($apartment) && isset($update))

               <a href="{{ route('properties.edit',['property'=>$apartment->id, 'type' => $type, 'step' => 'one', 'token' => request()->token , 'update' => request()->update , 'back_one' => request()->user()->id]) }}" class="btn btn-lg text-secondary btn-accent">
                 <i class="far fa-long-arrow-left ml-1"></i>
                 Prev
               </a>

               @else
               <a href="{{ route('properties.create',['type' => $type, 'step' => 'one','token' => request()->token,  'update' => request()->update,  'back_one' => request()->user()->id ]) }}" class="btn btn-lg text-secondary btn-accent">
                  <i class="far fa-long-arrow-left ml-1"></i>
                  Prev
               </a>


               @endif
            </div>
            <div class=" col-md-6 text-right">
               <button
                  type="submit"
                  class="btn btn-lg text-secondary btn-accent"
                  >
               Next
               <i class="far fa-long-arrow-right ml-1"></i>
               </button>
            </div>
         </div>
      </div>
   </div>
</form>
</section>