
$(".selector").flatpickr({
    minDate: "today",  // Disable past dates
    dateFormat: "Y-m-d",  // Set the desired date format
});

Dropzone.autoDiscover = false;
// Customize Dropzone's default message
Dropzone.options.myDropzone = {
    dictDefaultMessage: "Click here to upload your ID"
};

let form_button = $("#login_form_button");

let overlay = $("#overlay");

let myDropzone;

jQuery(window).on('load', function () {
    var d = $("div#my-dropzone")

    if (d.length) {

        myDropzone = new Dropzone("div#my-dropzone", {
            url: "/file/uploads",
            paramName: "file",
            maxFilesize: 10,
            timeout: 180000,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            uploadMultiple: true,
            maxFiles: 1,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function () {
                this.on("addedfile", function (file) { $("div.error").html('') });
            }
        })
    }

    // Custom validation method to check if check-in date is before checkout date
    $.validator.addMethod("checkInBeforeCheckOut", function (value, element) {
        var checkin = $('#checkin').val();
        var checkout = $('#checkout').val();

        // Parse the dates
        var checkinDate = new Date(checkin);
        var checkoutDate = new Date(checkout);

        // Check if checkin date is before checkout date
        return this.optional(element) || checkinDate < checkoutDate;
    }, "");


    var $validator = $('form.form-validate').validate({
        rules: {
            first_name: { required: true, },
            last_name: { required: true, },
            email: { required: true, email: true },
            phone_number: { required: true, },
            apartment_id: { required: true, },
            checkin: {
                required: true,
                checkInBeforeCheckOut: true
            },
            checkout: { required: true }
        },
        messages: {
            email: { required: "Please enter your email", email: "Please enter a valid email" },
            apartment_id: { required: "Please select an  apartment" },
            checkin: { required: "Select a check-in date" },
            checkout: { required: "Select a check-out date" },
        },
        submitHandler: function (form) {
            if (myDropzone) {
                myDropzone.on("uploadprogress", function (file) {
                    $("div.error").html('Please allow your image to finish uploading')
                    return false;
                });
            }

            if (myDropzone.files.length === 0) {
                $("div.error").html('Please upload your ID.')
                return
            }

            $("#form").addClass('header-filter')

            form_button.text("Loading...")

            overlay.removeClass('d-none')
            overlay.addClass('d-flex')


            // AJAX call
            $.ajax({
                url: '/check-in',
                type: 'POST',
                data: $(form).serialize(), // Serialize the form data
                success: function (response) {
                    $(form).hide()
                    $("#alert-success").removeClass('d-none')
                    overlay.addClass('d-none')
                    overlay.removeClass('d-flex')

                },
                error: function (xhr, status, error) {
                    form_button.text("Submit")
                    let m = JSON.parse(xhr.responseText);
                    overlay.addClass('d-none')
                    overlay.removeClass('d-flex')

                    if (typeof m != 'undefined' && typeof m.message !== 'undefined') {
                        alert("This apartment is not available for your selected date.");
                    }
                }
            });
        }
    });
})