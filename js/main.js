$(document).ready(function () {

    $(document).on('changeDate', '.fake-th-date-picker', function (e) {
        console.log('select date : ' + e);
        var today = new Date(e.date);
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        var today = yyyy + '-' + mm + '-' + dd;
        $($(this).data('target')).val(today);
        return false;
    });

    $(document).on('keypress', '.input-numeric', function (e) {
        console.log('a');
        if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    $(document).on('change', '.input-update', function () {
        var btn = $(this);
        var query = $(btn).closest("form").serialize();
        var url;
        if ($(btn).data('url') !== "") {
            url = $(btn).data('url')
        } else {
            url = $(btn).closest("form").attr('action');
        }
        $($(btn).data('target')).attr('disabled', 'disabled');
        
        if ($(btn).data('method') === 'get') {
            $.get(url, query, function (data) {
                $($(btn).data('target')).each(function (i, e) {
                    $(e).html($('#' + $(e).attr('id'), data).html());
                    $(e).removeAttr('disabled');
                });

                if ($(btn).data('callback')) {
                    var cb = eval($(btn).data('callback'));
                    cb();
                }
            });
        } else {
            $.post(url, query, function (data) {
                $($(btn).data('target')).each(function (i, e) {
                    $(e).html($('#' + $(e).attr('id'), data).html());
                    $(e).removeAttr('disabled');
                });

                if ($(btn).data('callback')) {
                    var cb = eval($(btn).data('callback'));
                    cb();
                }
            });
        }
        return false;
    });

    $(document).on('click', '.btn-ajax-modal', function () {
        $.get($(this).attr('href'), function (data) {
            $('#base-modal .modal-content').html(data);
            $('#base-modal').modal('show');
        });
        return false;
    });

    try {
        $('.onfly-datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
        });
    } catch (e) {

    }

    $("#ui-datepicker-div").css("z-index", "9999");
});