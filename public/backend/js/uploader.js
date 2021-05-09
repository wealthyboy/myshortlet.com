function getFile(e,name,model=null,multiple=true){
    let parent = e.parentNode;
    let file = e.parentNode.querySelector(".upload_input");
    let  file_error= e.parentNode.querySelector("#img-error");
    if(file_error !== null){
      file_error.remove()
    }
    parent.querySelector('.upload-text').classList.add('hide')
    let target  = parent.querySelector("#j-details");
    let parent1 = document.createElement('div');
    parent1.setAttribute('class','j-complete j-loading')
    let parent2 = document.createElement('div');
    parent2.setAttribute('class','j-preview loading')
    if (typeof file !== 'undefined'){
      parent1.appendChild(parent2)
      target.appendChild(parent1)
    }
    
    let form = new FormData();
    
    form.append('file',file.files[0])
    $.ajax({
          url: '/admin/upload/image?folder=products',
          type: 'POST',
          data: form,
          cache: false,
          contentType: false,
          processData: false,
          success: function (data) {
            if ( data.path ){
                let rand = Math.floor((Math.random() * 1000000000) + 1)
                let html ='';
                    html += '<div   id="' + rand + '" class="j-complete">'
                   
                    html+= '<div  class="j-preview j-no-multiple">'
                    html+= '<img class="img-thumnail" src="'+ data.path +'" />'
                    html+= '<div id="remove_image" class="remove_image remove-image">'
                    //this will allow for multiple images
                    html+= '<a  class="remove-image" data-model="' + model +'"  data-randid="' + rand +'" data-url="'+ data.path +'"  href="#">Remove</a>'
                    html+= '</div>'
                    html+= '<input type="hidden" class="file_upload_input stored_image_url"  value="'+ data.path +'"  name="'+ name +'">'
                    html+= '</div>'
                    html+= '</div>'
                var divs = document.querySelectorAll(".j-loading"), i;
                      for (i = 0; i < divs.length; ++i) {
                        divs[i].remove()
                      }
                      if (!multiple){
                        file.setAttribute('disabled',true);
                      }
                      target.insertAdjacentHTML('beforeend',html)
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown){
            var divs = document.querySelectorAll(".j-loading"), i;
            for (i = 0; i < divs.length; ++i) {
              divs[i].remove()
            }
          } 
          
    });


    
}