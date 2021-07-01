define(['jquery', 'jqueryui', 'local_aaviewreports/chosen'], function ($) {
    return {
        init: function () {

            loadChosen();

            initChangeFilters();

            $('#clear-filters').click(function () {
                clearFilters();
            });


            $('#apply-filters').click(function (e) {
                const filters = getFilters();
                // console.log(filters);
                queryTable(filters);
                e.preventDefault();
            });

            initLoadTrainee();

            initPagination();

            function initChangeFilters(){
                $('body').on('change', '.filter-multiple,.filter-single', function () {
                    const filters = getFilters();
                    console.log(filters);
                    queryFilters(filters);
                });
            }


            function initPagination() {
                $('.page-item[data-page]').click(function () {
                    const num_page = $(this).attr('data-page');
                    const perpagevalue = getPerPage();
                    let pagination = {page: num_page, perpage: perpagevalue}
                    const filters = getFilters();
                    queryTable(filters, pagination);
                    // console.log("Click по странице = ", num_page);
                    // console.log("Записей на странице = ", perpagevalue);
                });

                $('#menuperpage').change(function (e) {
                    const el_select = e.target;
                    let perpagevalue = $(el_select).val();
                    const num_page = $('.page-item.active').attr('data-page');
                    let pagination = {page: num_page, perpage: perpagevalue}
                    const filters = getFilters();
                    queryTable(filters, pagination);
                    // console.log(perpagevalue)
                    // console.log(num_page)
                })
            }


            function getFilters() {
                let filters = [];
                let filter;
                const listSelect = $('#filters_aaviewreports select');
                let count = 0;
                $.each(listSelect, function (index, elem) {
                    const name = elem.getAttribute('id');
                    const selected = $(elem).val();
                    if (!isEmpty(selected)) {
                        filter = {name: name, selected: selected};
                        filters[count] = filter;
                        count++;
                    }
                });
                return filters;
            }

            function getPerPage() {
                let perpagevalue;
                const select = $('#menuperpage');
                $.each(select, function (index, elem) {
                    if ($(elem).attr('selected')) {
                        return perpagevalue = $(elem).val();
                    }
                    perpagevalue = $(elem).val();
                })
                return perpagevalue;
            }

            function loadChosen() {
                $(" .filter-multiple").chosen({width: "100%"});
                $(" .filter-single").chosen({width: "100%"});
            }

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

            function sendQuery(data, selector = '#filters_aaviewreports') {
                ShowLoader();
                console.log('getDataFromServer');
                const URL = configAjax.wwwroot + '/local/aaviewreports/data_request.php';
                const TYPE = 'POST';
                const DATATYPE = 'html';

                var request = $.ajax({
                    url: URL,
                    type: TYPE,
                    dataType: DATATYPE,
                    data: data,
                });

                request.done(function (response) {
                    $(selector).html();
                    $(selector).html(response);
                    loadChosen();
                    HideLoader();
                    initPagination();
                    console.log('Данные получены');
                    // console.log(response);
                });
                request.fail(function (jqXHR, textStatus) {
                    HideLoader();
                    initPagination();
                    console.log(jqXHR);
                });
            }

            function queryFilters(filters) {
                let data = {
                    data_filters: {
                        report: 'general',
                        filters: filters,
                    }
                }
                sendQuery(data);
            }

            function queryTable(filters, pagination = null) {
                let data = {
                    data_table: {
                        report: 'general',
                        filters: filters,
                        pagination: pagination,
                    }
                }
                sendQuery(data, '#table_aaviewreports');
            }

            function clearFilters() {

                let data = {
                    clear_filters: 'clearfilters'
                }
                sendQuery(data);
            }

            function ShowLoader() {
                $('.loader__wrap').css('display', 'flex');
            }

            function HideLoader() {
                $('.loader__wrap').css('display', 'none');
            }

            function initLoadTrainee() {
                $(document).on('keyup', "#trainee_chosen .chosen-search-input", function () {
                    var buf = $("#trainee_chosen .chosen-search-input").val();
                    console.log(buf)
                    if ($(this).val().length > 2) {
                        load_trainee(buf);
                    } else {
                        $('#trainee').html("<option selected='selected' value=''>All</option>");
                        $('#trainee').trigger("chosen:updated");
                    }
                    $('#trainee_chosen .chosen-search-input').val(buf);
                });
            }

            function load_trainee(buf) {

                const URL = configAjax.wwwroot + '/local/aaviewreports/data_request.php';
                const TYPE = 'POST';
                const DATATYPE = 'json';
                let data = {data_trainee: buf}

                var request = $.ajax({
                    url: URL,
                    type: TYPE,
                    dataType: DATATYPE,
                    data: data,
                });

                request.done(function (response) {
                    // console.log('Запрос успешный')
                    // console.log(response)
                    $("#trainee").html('');
                    $("#trainee").append('<option value="">All</option>');
                    $.each(response.values, function (idx, obj) {
                        //$.each(data, function (idx, obj) {
                        $("#trainee").append('<option value="' + obj.id + '">' + obj.value + '</option>');
                    });
                    $("#trainee").trigger("chosen:updated");
                    $('#trainee_chosen .chosen-search-input').val(buf);
                });
                request.fail(function (jqXHR, textStatus) {
                    // console.log('Запрос неудачный')
                    console.log(jqXHR);
                });
            }
        }
    }
});