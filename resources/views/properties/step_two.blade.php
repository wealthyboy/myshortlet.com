<section>

   <h2>Common Facilities</h2>
   <form  method="POST"  action="{{ route('properties.store',['type'=>$type,'step' => 'three','apartment_id' => request()->apartment_id]) }}">
       @csrf
   <div class="row">
      <div class="col-sm-6 col-lg-3">
         <ul class="list-group list-group-no-border">
            @foreach($facilities as $facility)
               <li class="list-group-item px-0 pt-0 pb-2">
                  <div class="custom-control custom-checkbox">
                     <input
                        type="checkbox"
                        class="custom-control-input"
                        name="facility_id[]"
                        id="{{ $facility->name }}"
                        value="{{ $facility->id }}"
                        />
                     <label class="custom-control-label" for="{{ $facility->name }}">{{ $facility->name }}</label>
                  </div>
               </li>
            @endforeach
         </ul>
      </div>
      <div class="col-md-12">
         <div class="form-row">
            <div class=" col-md-6">
               <a href="{{ route('properties.create',['type' => $type, 'step' => 'one','apartment_id' => request()->apartment_id]) }}" class="btn btn-lg text-secondary btn-accent">
                  <i class="far fa-long-arrow-left ml-1"></i>
                  Prev
               </a>
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