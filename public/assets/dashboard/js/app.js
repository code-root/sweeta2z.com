$('.loder-image').hide();
function deleteImage (id ,route) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
$.ajax({ url: route, data: {image_id:id}, type: "POST", headers: {'X-CSRF-TOKEN': csrfToken},
success: function () { $('#img-'+id).hide(); swal({icon: 'success', title: 'تمت ازاله الصوره بنجاح' }); }, }); }


function uplodeImage (formData , route) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
            url: route,
            data: formData,
            type: "POST",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': csrfToken},
            beforeSend: function() {
                $('.loder-image').show();
                $('.ft-file').hide();
        },
            success: function (data) {
                $('.loder-image').hide();
                $('.ft-file').show();
                $.each(data.images, function (index, image) {
                    var newRow = `<label id="`+image.url+`" class="btn"><p>language `+image.language+` - status :  `+image.status+` </p>
                        <img src="`+image.url+`" class="check img-thumbnail" style="width: 155px;height: 97px;"></label>`;
                    $('.add-image').append(newRow);
                });
                // إعادة تعيين الحقول بعد الرفع
                $('#image').val('');
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
}

function storeForm(formData, url , redirect , nameTbale , type = "POST" , edit = true) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: url, data: formData, type: type,
        enctype: 'multipart/form-data',
         processData: false,
        contentType: false,
         headers: { 'X-CSRF-TOKEN': csrfToken },
          success: function (data) {
            swal({
                icon: 'success',
                 title:nameTbale,
                  showCancelButton: true,
               confirmButtonText: 'إعادة التوجيه',
                cancelButtonText:nameTbale
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = redirect;
                } else {
                    if (!edit){
                        $('#name_ar').val(''); $('#name_en').val('');
                    }
                }
            });
        },
        error: function (xhr, status, error) { console.log(error); }
    });
}
