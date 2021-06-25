$(document).ready(function () {

        $('.filter-single').select2();
        // $('.filter-multiple').select2();
        $('.filter-multiple').select2({
            placeholder: 'Select an option'
        });

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
    console.log('getDataFromServer')
    const URL = configAjax.wwwroot + '/local/aaviewreports/data_request.php';
    const TYPE = configAjax.settings.type;
    const DATATYPE = configAjax.settings.dataType;

    let data = {
        dataset: {
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
        $('#filters').html();
        $('#filters').html(msg);
        // console.log(msg);
        $('.filter-multiple').select2();
    });
    request.fail(function (jqXHR, textStatus) {
        console.log(jqXHR);
    });
}