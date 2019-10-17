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

    $(document).on('click', '.btn-ajax-post', function () {
        var obj = $(this);
        if ($(obj).data('confirm')) {
            if (!confirm($(obj).data('confirm'))) {
                return false;
            }
        }
        $.post($(obj).attr('href'), function (data) {
            if ($(obj).data('grid-update')) {
                $($(obj).data('grid-update')).yiiGridView('update');
            }
            if ($(obj).data('content-update')) {
                $($(obj).data('content-update')).html($($(obj).data('content-update'), data).html());
            }
        });
        return false;
    });

    $(document).on('changeDate', '.date-update', function () {
        var btn = $(this);
        var url;
        if ($(btn).data('url') !== "") {
            url = $(btn).data('url')
        } else {
            url = $(btn).closest("form").attr('action');
        }
        var params = $(btn).closest("form").serialize();
        $($(btn).data('target')).attr('disabled', 'disabled');
        $.get(url, params, function (data) {
            $($(btn).data('target')).each(function (i, e) {
                switch ($(e).prop('tagName')) {
                    case 'INPUT':
                    case 'TEXTAREA':
                        $(e).val($('#' + $(e).attr('id'), data).val());
                        break;
                    default:
                        $(e).html($('#' + $(e).attr('id'), data).html());
                        break;
                }
                $(e).removeAttr('disabled');
            });
            if ($(btn).data('callback')) {
                var cb = $(btn).data('callback');
                cb();
            }
        });
        return false;
    });

    $(document).on('change', '.input-update', function () {
        var btn = $(this);
        var url;
        if ($(btn).data('url') !== "") {
            url = $(btn).data('url')
        } else {
            url = $(btn).closest("form").attr('action');
        }
        var params = $(btn).closest("form").serialize();
        $($(btn).data('target')).attr('disabled', 'disabled');


        if ($(btn).data('method') === 'get') {
            $.get(url, params, function (data) {
                $($(btn).data('target')).each(function (i, e) {
                    switch ($(e).prop('tagName')) {
                        case 'INPUT':
                        case 'TEXTAREA':
                            $(e).val($('#' + $(e).attr('id'), data).val());
                            break;
                        default:
                            $(e).html($('#' + $(e).attr('id'), data).html());
                            break;
                    }
                    $(e).removeAttr('disabled');
                });
                if ($(btn).data('callback')) {
                    var cb = $(btn).data('callback');
                    cb();
                }
                $(btn).trigger('afterInputUpdate');
            });
        } else {
            $.post(url, params, function (data) {
                $($(btn).data('target')).each(function (i, e) {
                    switch ($(e).prop('tagName')) {
                        case 'INPUT':
                        case 'TEXTAREA':
                            $(e).val($('#' + $(e).attr('id'), data).val());
                            break;
                        default:
                            $(e).html($('#' + $(e).attr('id'), data).html());
                            break;
                    }
                    $(e).removeAttr('disabled');
                });
                if ($(btn).data('callback')) {
                    var cb = $(btn).data('callback');
                    cb();
                }
                $(btn).trigger('afterInputUpdate');
            });
        }
        return false;
    });

    $(document).on('click', '.btn-ajax-modal', function () {
        if ($(this).data('modal-size') === 'large') {
            $('#base-modal .modal-dialog').addClass('modal-lg');
        } else {
            $('#base-modal .modal-dialog').removeClass('modal-lg');
        }
        $.get($(this).attr('href'), function (data) {
            $('#base-modal .modal-content').html(data);
            $('#base-modal').modal('show');
            if (typeof initScript !== 'undefined' && $.isFunction(initScript)) {
                initScript();
            }
        });
        return false;
    });

    $('.onfly-datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
    });

    $.datepicker.setDefaults({
        dateFormat: 'yy-mm-dd'
    });
});

/* Thai initialisation for the jQuery UI date picker plugin. */
/* Written by pipo (pipo@sixhead.com). */
(function (factory) {
    if (typeof define === "function" && define.amd) {

        // AMD. Register as an anonymous module.
        define(["../widgets/datepicker"], factory);
    } else {

        // Browser globals
        factory(jQuery.datepicker);
    }
}(function (datepicker) {

    datepicker.regional.th = {
        closeText: "ปิด",
        prevText: "&#xAB;&#xA0;ย้อน",
        nextText: "ถัดไป&#xA0;&#xBB;",
        currentText: "วันนี้",
        monthNames: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
            "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
        monthNamesShort: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
            "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."],
        dayNames: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"],
        dayNamesShort: ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."],
        dayNamesMin: ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."],
        weekHeader: "Wk",
        dateFormat: "dd/mm/yy",
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ""};
    datepicker.setDefaults(datepicker.regional.th);

    return datepicker.regional.th;

}));