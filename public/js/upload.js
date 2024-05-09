
$(".selector").flatpickr();

Dropzone.autoDiscover = false;
// Customize Dropzone's default message
Dropzone.options.myDropzone = {
    dictDefaultMessage: "Click here to upload your ID"
};

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
    var $validator = $('form.form-validate').validate({
        rules: {
            first_name: { required: true, },
            last_name: { required: true, },
            email: { required: true, email: true },
            phone_number: { required: true, },
            apartment_id: { required: true, },
            checkin: { required: true },
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

            console.log(myDropzone.files.length)

            if (myDropzone.files.length === 0) {
                $("div.error").html('Please upload your ID.')
                return
            }

            $("#form").addClass('header-filter')
            form.submit();
        }
    });
})