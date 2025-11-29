function handleFiles(input, name) {
    [...input.files].forEach(file => uploadSingleFile(file, input, name));
}

/* -----------------------------
   SORT IMAGES + UPDATE ORDER
------------------------------ */
document.addEventListener('DOMContentLoaded', function () {

    const el = document.getElementById('j-details');
    if (!el) {
        console.error("No #j-details found!");
        return;
    }

    new Sortable(el, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        onEnd: function () {
            updateImageOrder();
        }
    });

});


function updateImageOrder() {
    $('#j-details .j-complete').each(function (index) {
        const id = $(this).attr('id');

        // remove old order input
        $(this).find('.image-order-input').remove();

        // add new order input
        $(this).append(
            `<input type="hidden" class="image-order-input" name="image_order[${id}]" value="${index + 1}">`
        );
    });
}

/* -----------------------------
   UPLOAD SINGLE FILE
------------------------------ */
function uploadSingleFile(oneFile, inputEl, name) {

    // 1. PREP DOM
    const parent = inputEl.parentNode;
    const fileErr = parent.querySelector('#img-error');
    if (fileErr) fileErr.remove();

    parent.querySelector('.upload-text').classList.add('hide');
    const target = parent.querySelector('#j-details');

    // loading placeholder
    const holder = document.createElement('div');
    holder.className = 'j-complete j-loading';
    holder.innerHTML = '<div class="j-preview loading"></div>';
    target.appendChild(holder);

    // 2. SEND FILE
    const form = new FormData();
    form.append('file', oneFile);

    $.ajax({
        url: '/admin/upload/image?folder=apartments',
        type: 'POST',
        data: form,
        cache: false,
        contentType: false,
        processData: false,

        success: data => {
            if (data.path) {
                const rand = Math.floor(Math.random() * 1e9) + 1;

                const html = `
                <div id="${rand}" class="j-complete j-sort">
                    <div class="j-preview j-no-multiple">
                        <img class="img-thumnail" src="${data.path}">
                        <div id="remove_image" class="remove_image remove-image">
                            <a class="remove-image"
                               data-randid="${rand}"
                               data-url="${data.path}" href="#">Remove</a>
                        </div>

                        <!-- ⭐ Caption for new upload -->
                        <input type="text"
                               class="image-caption-input"
                               name="captions[]"
                               placeholder="Enter caption"
                               style="margin-top:8px; width:100%; padding:6px; border:1px solid #ccc;">

                        <!-- hidden image URL -->
                        <input type="hidden"
                               class="stored_image_url"
                               name="${name}"
                               value="${data.path}">
                    </div>
                </div>
                `;

                holder.remove();
                target.insertAdjacentHTML('beforeend', html);

                updateImageOrder(); // refresh order
            }
        },

        error: () => holder.remove()
    });
}
