define(['jquery', 'jqueryui', 'local_aaviewreports/chosen'], function ($) {
    return {
        init: function () {
            loadChosen();

            $('body').on('change', '.filter-multiple,.filter-single', function () {
                const filters = getFilters();
                console.log(filters);
                queryFilters(filters);
            });

            $('#clear-filters').click(function () {
                clearFilters();
            });


            $('#apply-filters').click(function () {
                const filters = getFilters();
                console.log(filters);
                queryTable(filters);
            });

            initPagination();

            function initPagination(){
                $('.page-item[data-page]').click(function () {
                    const num_page = $(this).attr('data-page');
                    console.log("Click по странице = ", num_page);
                    const perpagevalue = getPerPage();
                    let pagination = {page: num_page, perpage: perpagevalue}
                    const filters = getFilters();
                    queryTable(filters,pagination);
                });
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
                });
                request.fail(function (jqXHR, textStatus) {
                    HideLoader();
                    initPagination();
                    console.log(jqXHR);
                });
            }

            function queryFilters(filters) {
                let data = {
                    dataset: {
                        report: 'general',
                        filters: filters,
                    }
                }
                sendQuery(data);
            }

            function queryTable(filters,pagination = null) {
                let data = {
                    datatable: {
                        report: 'general',
                        filters: filters,
                        pagination:pagination,
                    }
                }
                sendQuery(data, '#table_aaviewreports');
            }

            function clearFilters() {

                let data = {
                    clearfilters: 'clearfilters'
                }
                sendQuery(data);
            }

            function ShowLoader() {
                $('.loader__wrap').css('display', 'flex');
            }

            function HideLoader() {
                $('.loader__wrap').css('display', 'none');
            }
        }
    }
});