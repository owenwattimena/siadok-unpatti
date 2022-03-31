function ajaxGet(url) {
    // $("body").LoadingOverlay("show");
    return $.ajax({
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        dataType: 'json',
        processData: false,
        contentType: false,
    });
}

function ajaxPost(url, formData) {
    // $("body").LoadingOverlay("show");
    return $.ajax({
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        type: "POST",
        dataType: 'json',
        processData: false,
        contentType: false,
    });
}

