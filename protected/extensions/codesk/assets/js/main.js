$(document).ready(function () {
    $(document).on('click', '.codesk-btn-ajax', function () {
        var btn = $(this);
        $.ajax({
            type: $(btn).data('method') ? $(btn).data('method') : 'get',
            url: $(btn).attr('href'),
            cache: false,
            data: $(btn).data('form') ? $($(btn).data('form')).serialize() : {},
            success: function () {
                if ($(btn).data('target-modal')) {
                    $($(btn).data('target-modal')).modal("hide");
                }
                if ($(btn).data('target-grid')) {
                    $($(btn).data('target-grid')).yiiGridView("update");
                }
                $(btn).trigger('completed');
            }
        });
        return false;
    });
});