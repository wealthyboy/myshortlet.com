<!--  You can switch " data-color="purple"   with one of the next bright colors: "green", "orange", "red", "blue"       -->
<div class="wizard-header">
               <h3 class="wizard-title">
                  Upload Property
               </h3>
            </div>
            <div class="wizard-navigation">
               <ul>
                  <li><a href="wizard.html#ProductData" data-toggle="tab">Property Data</a></li>
                  <li><a href="wizard.html#Cancelation" data-toggle="tab">Cancelation/Rules/Facilities </a></li>
                  <li><a href="wizard.html#ProductVariations" data-toggle="tab">Aprtment</a></li>
               </ul>
            </div>
            <div class="tab-content">
               <div class="tab-pane" id="ProductData">
                  @include('admin.apartments.apartment_data')
               </div>
               <div class="tab-pane" id="Cancelation">
                  <div class="row">
                     <div class="col-md-6">
                       <div class="card-content">
                           <div class="form-group">
                              <label class="label-control">Check in iime</label>
                              <input type="text" required="true" name="check_in_time" class="form-control timepicker" value="14:00"/>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                       <div class="card-content">
                           <div class="form-group">
                              <label class="label-control">Check out Time</label>
                              <input name="check_out_time"  required="true" type="text" class="form-control timepicker" value="14:00"/>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-12 mt-3 pr-5 ">
                        <h4 class="card-title">Cancellation</h4>
                        <div class="togglebutton cancel form-inline">
                           <label>
                           <input  name="is_refundable" id="allow_cancellation"  value="1" type="checkbox">
                              Refundable 
                           </label>
                        </div>
                     </div>

                     <div class="col-sm-7  cancellation-message  d-none  {{ isset($apartment) &&  $apartment->allow_cancellation ? '' : ''}} ">
                        <div class="form-group">
                           <label for="cancellation_message">Cancellation Policy</label>
                           <textarea class="form-control" name="cancellation_message" id="cancellation_message" rows="5">{{ isset($apartment) ?   $apartment->is_refundable : '' }}</textarea>
                        </div>
                     </div>

                     <div class="col-md-12 mt-1 pr-5 ">
                       @include('admin.apartments.attributes',['attris'=> $attributes, 'ob' => null])
                     </div>


                     <div class="col-md-12 mt-1 pr-5 ">
                       @include('admin.apartments.attributes',['attris'=> $others,'ob' => null])
                     </div>

                     
                     <div class="col-md-12 mt-1 pr-5 ">
                        <h4 class="">Property Extras</h4>
                        @include('admin.apartments.extras',[
                           'obj' => null, 
                           'name' => 'property_extra_services',
                           'attribute_name' => 'property_extras'
                        ])
                     </div>

                     

                  </div>
               </div>
               <div class="tab-pane" id="ProductVariations">
                  <h4 class="info-text">Apartment</h4>
                  <div class="clearfix"></div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label class="control-label">Apartment Type</label>
                        <select name="type" id="apartment-type" class="form-control"  required="true" title="Please select product type"  title="" data-size="7">
                           <option  value="" selected>Choose One</option>
                           <option  value="multiple" selected>Multiple</option>
                        </select>
                     </div>
                  </div>
                  
                  <div class="clearfix"></div>
                  <div class="row p-attr  new-room  ">
                     <label class="col-md-12  col-xs-12 col-xs-12">
                        <div class="pull-right">
                           <button type="button"  id="add-room" class="btn btn-round  btn-primary">
                           Add Apartment
                           <span class="btn-label btn-label-right">
                              <i class="fa fa-plus"></i>
                           </span>
                           </button>
                        </div>
                     </label>
                  </div>
               </div>
               <div class="wizard-footer">
                  <div class="pull-right">
                     <input type='button' class='btn btn-next btn-fill btn-rose btn-round btn-wd' name='next' value='Next' />
                     <input type='submit' class='btn btn-finish btn-fill btn-rose   btn-round  btn-wd' name='finish' value='Finish' />
                  </div>
                  <div class="pull-left">
                     <input type='button' class='btn btn-previous btn-fill btn-primary  btn-round  btn-wd' name='previous' value='Previous' />
                  </div>
                  <div class="clearfix"></div>
               </div>