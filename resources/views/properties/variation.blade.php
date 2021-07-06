<div class="row p-attr border p-3  mb-1  variation-panel">
	<div class="col-md-12 col-xs-12 text-right  col-sm-12 "> <a href="#" title="remove panel" class="remove-panel"><i class="fa fa-trash-o"></i> Remove</a> | <a href="#" title="open/close panel" class="open-close-panel"><i class="fa fa-plus"></i> Expand</a> </div>
	<section id="variation-panel" data-id="{{ $counter }}" class=" v-panel hide">
		<div class="row">
			<div class="col-lg-12">
				<div class="form-group">
					<label for="">Apartment Title </label>
					<input type="text" name="apartment_name[{{ $counter }}]" class="form-control" id="" placeholder="" /> </div>
			</div>
			<div class="col-lg-3">
				<div class="form-group">
					<label for="bedrooms">Bedrooms</label>
					<select name="bedrooms[{{ $counter }}]" name="bedrooms" id="bedrooms" class="form-control">
						<option selected>Choose...</option> @for ($i = 0; $i
						< 10; $i++) <option value="{{ $i }}"> {{ $i }}</option> @endfor </select>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="form-group">
					<label for="adults">Adults</label>
					<select name="adults[{{ $counter }}]" id="adults" class="form-control">
						<option selected>Choose...</option> @for ($i = 0; $i
						< 10; $i++) <option value="{{ $i }}"> {{ $i }}</option> @endfor </select>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="form-group">
					<label for="children">Children</label>
					<select name="children[{{ $counter }}]" id="children" class="form-control">
						<option selected>Choose...</option> @for ($i = 0; $i
						< 10; $i++) <option value="{{ $i }}"> {{ $i }}</option> @endfor </select>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="form-group">
					<label for="">Price</label>
					<input name="price[{{ $counter }}]" type="number" class="form-control" id="" placeholder="" /> </div>
			</div>
			<div class="col-md-12">
				<h4>Bedroom</h4>
				<div class="d-flex flex-grow-1">
					<div class="custom-control custom-radio mr-3">
						<input type="radio" class="custom-control-input" id="customControlValidation2" name="radio-stacked" required />
						<label class="custom-control-label" for="customControlValidation2">1 queen bed</label>
					</div>
					<div class="custom-control custom-radio mb-3">
						<input type="radio" class="custom-control-input" id="customControlValidation3" name="radio-stacked" required />
						<label class="custom-control-label" for="customControlValidation3">1 double bed</label>
						<div class="invalid-feedback"> More example invalid feedback text </div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div id="j-drop" class="j-drop">
					<input accept="image/*" required="true" onchange="getFile(this,'apartment_images[{{ $counter=8 }}]')" class="upload_input" data-msg="Upload  your image" type="file" name="img" />
					<div class="upload-text">
						<a class="" href="#"> <img class="" src="/backend/img/upload_icon.png" /> <b>Click to upload image</b> </a>
					</div>
					<div id="j-details" class="j-details">
						<div id="" class="j-complete">
							<div class="j-preview">
								<div id="remove_image" class="remove_image remove-image"> <a class="remove-image" data-mode="edit" data-randid="" data-id="" data-url="" href="#">Remove</a> </div>
								<input type="hidden" class="file_upload_input stored_image_url" value="" name="image" /> </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<h2>Rules</h2>
		<div class="row">
			<div class="col-sm-6 col-lg-3">
				<ul class="list-group list-group-no-border"> @foreach($rules as $rule)
					<li class="list-group-item px-0 pt-0 pb-2">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" name="attribute_id[]" id="{{ $rule->name }}" />
							<label class="custom-control-label" for="{{ $rule->name }}">{{ $rule->name }}</label>
						</div>
					</li> @endforeach </ul>
			</div>
		</div>
		<h2>Extra Services</h2>
		<div class="row">
			<div class="col-sm-6 col-lg-3">
				<ul class="list-group list-group-no-border"> @foreach($extra_services as $extra_service)
					<li class="list-group-item px-0 pt-0 pb-2">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" name="attribute_id[]" id="{{ $extra_service->name }}" />
							<label class="custom-control-label" for="{{ $extra_service->name }}">{{ $extra_service->name }}</label>
						</div>
					</li> @endforeach </ul>
			</div>
		</div>
	</section>
</div>