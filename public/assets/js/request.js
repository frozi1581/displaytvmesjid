/**
 * Simple API Request Module
 */

function sendGet(endpoint, query) {
    $.each(query, function(key, value) {
        endpoint += '&' + key + '=' + value;
    });

    window.location.href = endpoint;
}

function sendPost(endpoint, payload) {
	return sendRequest('POST', endpoint, payload);
}

function sendPut(endpoint, payload) {
	return sendRequest('PUT', endpoint, payload);
}

function sendDelete(endpoint, payload) {
	return sendRequest('DELETE', endpoint, payload);
}

function successMessage(title, msg) {
    let toast = {
        title: title,
        message: msg,
        status: TOAST_STATUS.SUCCESS,
        timeout: 5000
    }
    Toast.create(toast);
}

function errorMessage (title, msg) {
    let toast = {
        title: title,
        message: msg,
        status: TOAST_STATUS.DANGER
    }
    Toast.create(toast);
}

function sendRequest(method, endpoint, payload) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
            "X-Requested-With": "XMLHttpRequest"
        },
        url         : endpoint,
		method      : method,
		data        : payload,
		success     : function (data, textStatus, jqXHR) {
            response = objectify(data);

            successMessage('Berhasil', response.message);

            if (response.redirect)
                window.location.href = response.redirect;

            else
                location.reload(true);
        },
		error       : function (jqXHR, textStatus, errorThrown) {
            errMsg = objectify(jqXHR.responseText);
            errorMessage("Error", errMsg.message.replace('.', ' '));
        }
    });
}
