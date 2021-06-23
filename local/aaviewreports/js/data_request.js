$(document).ready(function () {

    $('select').change(function () {
        let filters = [];
        let filter;
        const listSelect = $('select');
        let count = 0;
        $.each(listSelect, function (index, elem) {
            const name = elem.getAttribute('id');
            const selected = $(elem).val();
            if (!isEmpty(selected)) {
                filter = {name: name, selected: selected}
                filters[count] = filter;
                count++;
            }
        });
        getQuery(filters);
        console.log(filters);
    });
});

function isEmpty(data) {
    if (typeof data === 'undefined') {
        return true;
    }
    if (data === null) {
        return true;
    }
    if (Array.isArray(data)) {
        if (data.length == 0) {
            return true;
        }
    }
    return false;
}

function getQuery(filters) {
    const URL = config_ajax.wwwroot + '/local/aaviewreports/data_request.php';
    const TYPE = config_ajax.settings.type;
    const DATATYPE = config_ajax.settings.dataType;

    let data = {
        dataset:{
            report: 'general',
            filters: filters,
        }
    }
    var request = $.ajax({
        url: URL,
        type: TYPE,
        dataType: DATATYPE,
        data: data,
    });

    request.done(function (msg) {
        $('.aaviewreport__wrap').html();
        $('.aaviewreport__wrap').html(msg);
        // $('.filter-single').select2();
        // $('.filter-multiple').select2();
        console.log(msg);
    });
    request.fail(function (jqXHR, textStatus) {
        console.log(jqXHR);
    });
}