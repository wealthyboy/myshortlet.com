function resetFile(input) {
  var $el = input.wrap('<form id="clearfiles"></form>');
  document.getElementById("clearfiles").reset();
  input.unwrap();
}

$('#reservationForm').on('submit', function (e) {
  e.preventDefault();

  var checkinDate = new Date($('#checkin').val());
  var checkoutDate = new Date($('#checkout').val());


  if (checkinDate >= checkoutDate) {
    alert('Check-in date must be earlier than check-out date.');
  } else {
    var formData = $(this).serialize();
    $('#add-extension').prop('disabled', true);
    $('#spinner').show();
    $.ajax({
      type: 'GET',
      url: $(this).data('url'),
      data: formData,
      success: function (response) {
        alert('Reservation successfully made.');
        location.reload()
      },
      error: function (xhr, status, error) {
        if (xhr.status === 400) {
          alert('This apartment date is not available for your selected date');
        } else {
          alert('An error occurred while making the reservation.');
        }

        $('#add-extension').prop('disabled', false);


      }
    });
  }
});


$('#bedrooms-update').on('change', function () {
  const selectedValue = parseInt($(this).val());

  console.log(true)
  
  // Loop through current dropdowns and remove extras if selected value is less than the current number
  for (let i = selectedValue + 1; i <= 10; i++) {
    $(`#bedroom_${i}`).closest('.bedroom-group').remove();
  }

  // Add new dropdowns if needed
  for (let i = 1; i <= selectedValue; i++) {
    if ($(`#bedroom_${i}`).length === 0) {
      const dropdown = `
        <div class="form-group col-md-2 bedroom-group mb-5">
            <label for="bedroom_${i}">Bedroom ${i}</label>
            <select name="bedroom_${i}" id="bedroom_${i}" class="form-control bedroom-select">
              <option value="" selected="">Choose bed type</option>
              <option value="Extra-large double bed">Extra-large double bed</option>
              <option value="Single bed">Single bed</option>
              <option value="Large bed">Large bed</option>
            </select>
        </div>
      `;
      $('#bedroom-dropdowns-container').append(dropdown);
    }
  }
});


$('#UpdateForm').on('submit', function (e) {
  e.preventDefault();


  var checkinDate = new Date($('#checkin-update').val());
  var checkoutDate = new Date($('#checkout-update').val());


  if (checkinDate >= checkoutDate) {
    alert('Check-in date must be earlier than check-out date.');
  } else {
    var formData = $(this).serialize();
    $('#add-update').prop('disabled', true);
    $('#spinner-update').show();
    $.ajax({
      type: 'GET',
      url: $(this).data('url'),
      data: formData,
      success: function (response) {
        alert('Updated was successfull .');
       location.reload()
      },
      error: function (xhr, status, error) {
        if (xhr.status === 400) {
          alert('This apartment date is not available for your selected date');
        } else {
          alert('An error occurred while making the reservation.');
        }

        $('#add_update').prop('disabled', false);


      }
    });
  }
});

$('.resend-link').on('click', function (event) {
  event.preventDefault(); // Prevent the default anchor tag behavior

  var url = $(this).data('url'); // Get the URL from the data-url attribute
  let self = $(this)
  //.addClass('disabled'); // Disable the anchor
  $(this).attr('disabled', 'disabled'); // Ad
  self.text('Sending...'); // Re-enable the anchor



  $.ajax({
    url: url,
    type: 'POST', // Or 'POST' depending on your endpoint
    success: function (response) {
      self.removeAttr('disabled'); // Remove disabled attribute from the anchor
      self.html('Send check-in link'); // Re-enable the anchor
      alert('Check-in link sent successfully.');
    },
    error: function (xhr, status, error) {
      alert('An error occurred while sending the check-in link.');
    },
    complete: function () {
      $(this).removeClass('disabled'); // Re-enable the anchor
      $(this).removeAttr('disabled'); // Remove disabled attribute from the anchor
      $(this).text('Send check-in link'); // Re-enable the anchor
    }
  });
});

$(document).on("click", ".remove-image", function (e) {
  e.preventDefault();
  e.stopPropagation();
  let self = $(this);
  let randid = self.data("randid");
  self.text("Deleting....");

  let parent = self.parents(".j-drop");
  let upload_text = parent.find(".upload-text");
  let file = parent.find(".upload_input");
  let mode = self.data("mode");
  let image_id = self.data("id");
  let model = self.data("model");

  let type = self.data("type");
  let payload = {
    image_url: self.data("url"),
    type: type,
    image_id: image_id,
    model: model,
  };

  $.ajax({
    url: "/admin/delete/image?folder=apartments",
    type: "POST",
    data: payload,
    success: function (data) {
      $("#" + randid).remove();
      if (parent.find(".j-complete").length == 0) {
        upload_text.removeClass("hide");
        resetFile(file);
        file.attr("disabled", false);
        if (typeof mode !== "undefined") {
          file.attr("required", true);
        }
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) { },
  });
});

jQuery(function () {
  localStorage.setItem("allow_variation", true);
  $(document).on("change", ".bedrooms", function (e) {
    console.log(true);
    let self = $(this);
    let value = self.val();
    let bed = self.parentsUntil(".v-panel").find(".bed");
    if (value == "") return;

    for (var i = 1; i <= 5; i++) {
      bed.find(".bedroom-" + i).addClass("d-none");
    }

    for (var i = 1; i <= value; i++) {
      bed.find(".bedroom-" + i).removeClass("d-none");
    }
  });

  $(".cancel :checkbox").on("change", function (e) {
    $(".cancellation-message").toggleClass("d-none");
  });

  /***
   * Add more variations
   */
  $("#product-attribute-add").on("click", function (e) {
    var values = [];
    $(".product-attributes").each(function () {
      values.push($(this).val());
    });
    var payLoad = { attribute_ids: values };
    $.ajax({
      type: "POST",
      url: "/admin/load-attributes",
      data: payLoad,
    }).done(function (response) {
      $(".p-attr")
        .last()
        .after(response);
      s.initFormExtendedDatetimepickers();
    });
  });

  /**
   * Add more rooms
   */
  $("#add-room").on("click", function (e) {
    $.ajax({
      type: "GET",
      url: "/admin/properties/apartment",
    }).done(function (response) {
      $(".new-room")
        .last()
        .after(response);
      s.initFormExtendedDatetimepickers();
    });
  });

  $("#add-apartment").on("click", function (e) {
    $.ajax({
      type: "GET",
      url: "/add/apartment",
    }).done(function (response) {
      $(".new-apartment")
        .last()
        .after(response);
    });
  });

  $(document).on("click", ".radio-button", function () {
    //console.log(true);
    let self = $(this);
    let p = self.parent().parent();
    console.log(p);

    p.find(".bed-qty").val("");
  });

  $('[data-toggle="collapse"]').on("click", function (e) {
    console.log(true);
  });

  $(document).on("click", ".open-close-panel", function (e) {
    e.preventDefault();
    $(this)
      .parent()
      .next()
      .toggleClass("hide");
    if ($(this).html() == '<i class="fa fa-plus"></i> Expand') {
      $(this).html('<i class="fa fa-minus"></i> Hide');
      return;
    }

    if ($(this).html() == '<i class="fa fa-minus"></i> Hide') {
      $(this).html('<i class="fa fa-plus"></i> Expand');
      return;
    }
  });

  $(document).on("click", ".remove-panel", function (e) {
    e.preventDefault();
    $(this)
      .parent()
      .parent(".variation-panel")
      .remove();
  });

  $(document).on("click", ".extra_services", function (e) {
    let gParent = $(this).parentsUntil("div.mt-2");
    gParent.find(".extra-services-input").prop("disabled", false);
  });

  $(document).on("click", ".delete-panel", function (e) {
    alert()
    e.preventDefault();
    $(this).text("Taking it out....");
    let self = $(this)
    $.ajax({
      type: "delete",
      url: $(this).attr("href"),
    })
      .done(function (response) {
        self.parent().parent().remove()
      })
      .catch(function () {
        $(this).text("Something went wrong.");
      });
  });

  $(".search_products").on("input", function (e) {
    var $self = $(this),
      payLoad = { product_name: $self.val() };
    $.ajax({
      type: "GET",
      url: "/admin/related/products",
      data: payLoad,
    }).done(function (response) {
      $("#related_products")
        .html("")
        .append(response);
    });
  });

  $(document).on("click", ".add_product", function (e) {
    e.preventDefault();
    $(this)
      .parentsUntil("tbody")
      .clone()
      .appendTo(".related_products");
    $(this)
      .parentsUntil("tbody")
      .remove();
    $("tbody.related_products")
      .children(".p")
      .remove();
    $("tbody.related_products td")
      .children("input.d-none")
      .removeClass("hide");
  });

  $(document).on("click", ".remove_related_product", function (e) {
    e.preventDefault();
    $(this)
      .parentsUntil("tbody")
      .remove();
    e.preventDefault();
    $(this)
      .parent()
      .parent(".variation-panel")
      .remove();
    $.ajax({
      type: "delete",
      url: $(this).attr("href"),
    }).done(function (response) { });
  });

  $("#apartment-type").on("change", function () {
    $self = $(this);
    console.log($self.val());
    if ($self.val() === "single") {
      $(".simple-apartment").removeClass("hide");
      $(".variation-panel").addClass("hide");
      $(".new-room").addClass("hide");
    } else {
      $(".simple-apartment").addClass("hide");
      $(".new-room").removeClass("hide");
      $(".variation-panel").removeClass("hide");
    }
  });

  /**
   * Initialize form wizard
   */

  s.initMaterialWizard();

  /***
   * Initialize datetime picker
   */

  s.initFormExtendedDatetimepickers();

  console.log(s.initMaterialWizard());

  setTimeout(function () {
    $(".card.wizard-card").addClass("active");
  }, 600);
});
