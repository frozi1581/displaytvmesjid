/**
 * Form handling functions
 */

function objectifyForm(formID) {
    let result = {};

    $(formID).find('input, textarea, select').each(function() {
        if ($(this).val()) {
            result[this.name] = $(this).val();
        }
    });

    return result;
}
