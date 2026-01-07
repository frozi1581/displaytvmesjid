function objectify(json) {
    if (typeof json === "string")
        json = JSON.parse(json);

    return json;
}

$('._edit').on('click', function(e) {
    e.preventDefault();

	$("#form").parsley().validate();

	if ($("#form").parsley().isValid()) {
        var data = $("#form").serialize();

        sendPut($('meta[name="endpoint"]').attr('content'), data);
    }
});

$('._delete').on('click', function(e) {
    e.preventDefault();

    sendDelete($(this).attr('href'));
});

$('._post-btn').on('click', function(e) {
    e.preventDefault();

    sendPost($(this).attr('href'));
});

$('.filter-btn').on('click', function(e) {
    e.preventDefault();

    var query = objectify(objectifyForm('.filter-form'));
    endpoint = $('meta[name="endpoint"]').attr('content') + '?search=' + $('#search').val();

    sendGet(endpoint, query);
});

$('#logout-btn').on('click', function(e) {
    e.preventDefault();

    sendPost('/auth/logout');
    window.location.reload();
});

$(document).ready(function () {
    $('.page-link').each(function () {
        url = window.location.search.replace(/page=[0-9]*(&|)/, '')
        this.href += url.replace('?', '&');
    });
});

$('input:required, select:required, textarea:required').siblings().addClass('required');
