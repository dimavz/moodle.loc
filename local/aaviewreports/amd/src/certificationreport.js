define(['jquery', 'jqueryui','local_aaviewreports/chosen'], function ($) {
    return {
        init: function () {
            loadChosen();

            $('body').on('change', '.filter-multiple,.filter-single', function () {
                const filters = getFilters();
                console.log(filters);
                queryFilters(filters);
            });

            $('#clear-filters').click(function (){
                clearFilters();
            });


            $('#apply-filters').click(function (){
                const filters = getFilters();
                console.log(filters);
                queryTable(filters);
            });

            function getFilters(){
                let filters = [];
                let filter;
                const listSelect = $('select');
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

            function sendQuery(data,selector = '#filters_aaviewreports') {
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
                    // console.log(msg);
                    console.log('Данные получены');
                });
                request.fail(function (jqXHR, textStatus) {
                    HideLoader();
                    console.log(jqXHR);
                });
            }

            function queryFilters(filters){
                let data = {
                    dataset: {
                        report: 'general',
                        filters: filters,
                    }
                }
                sendQuery(data);
            }

            function queryTable(filters){
                let data = {
                    datatable: {
                        report: 'general',
                        filters: filters,
                    }
                }
                sendQuery(data,'#table_aaviewreports');
            }

            function clearFilters(){

                let data = {
                    clearfilters: 'clearfilters'
                }
                sendQuery(data);
            }

            function ShowLoader(){
                $('.loader__wrap').css('display','flex');
            }

            function HideLoader(){
                $('.loader__wrap').css('display','none');
            }
        }
    }
});