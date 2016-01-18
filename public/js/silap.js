/**
 *
 */
function saveForm ()
{
    $('.app-form').submit(function(e){

        e.preventDefault();

        var $form   = $(this),
            id      =  $form.attr('id'),
            table   = $form.data('table'),
            tableDt = $('#' + table).DataTable();

        $('#' + id + ' .save').addClass('disabled');

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            success: function(r) {
                if (table !== void 0)
                    tableDt.ajax.reload();

                $form.find('input[type=text], input[type=password], input[type=number], input[type=email], textarea').val('');

                $('#' + id + ' .save').removeClass('disabled');
                $('.alert-wrapper > .alert').fadeOut();
                $('.alert-wrapper').html('');
                $('.form-group').removeClass('has-error');

                var html = '<div class="alert alert-success alert-dismissible fade in" role="alert" data-dismiss="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>Success</div>';
                $('#' + id + ' .alert-wrapper').html(html);
                $(".alert.alert-success").fadeTo(2000, 500).slideUp(500, function() {
                    return $(".alert.alert-success").alert('close');
                });
            },
            error: function(r) {
                var errors, html;
                $('#' + id + ' .form-group').removeClass('has-error');
                errors = '<ul>';
                $.each(r.responseJSON, function(key, val) {
                    errors += '<li>' + val + '</li>';
                    return $('#' + id + ' #' + key).parent().addClass('has-error');
                });
                errors += '</ul>';

                html = '<div class="alert alert-danger alert-dismissible fade in" role="alert" data-dismiss="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>' + errors + '</div>';
                $('#' + id + ' .alert-wrapper').html(html);
                $('#' + id + ' .save').removeClass('disabled');
            }
        });
    });
}

function saveAchievement()
{
    $('.achievement-form').submit(function(e){
        e.preventDefault();

        var     $form   = $(this),
            id      = $form.attr('id');

        $('#' + id + ' .save').addClass('disabled');

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            success: function(r) {
                $('#' + id + ' .save').removeClass('disabled');

                $('#' + id + '.alert-wrapper > .alert').fadeOut();
                $('#' + id + '.alert-wrapper').html('');
                $('#' + id + '.form-group').removeClass('has-error');

                var html = '<div class="alert alert-success alert-dismissible fade in" role="alert" data-dismiss="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>Success</div>';
                $('#' + id + ' .alert-wrapper').html(html);
                $('#' + id + ' .alert-wrapper .alert.alert-success').fadeTo(2000, 500).slideUp(500, function() {
                    return $(".alert.alert-success").alert('close');
                });
            },
            error: function(r) {
                var errors, html;
                $('#' + id + ' .form-group').removeClass('has-error');
                errors = '<ul>';
                $.each(r.responseJSON, function(key, val) {
                    errors += '<li>' + val + '</li>';
                    return $('#' + id + ' #' + key).parent().addClass('has-error');
                });
                errors += '</ul>';

                html = '<div class="alert alert-danger alert-dismissible fade in" role="alert" data-dismiss="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>' + errors + '</div>';
                $('#' + id + ' .alert-wrapper').html(html);
                $('#' + id + ' .save').removeClass('disabled');
            }
        });
    });
}
/**
 *
 */
function updateForm ()
{
    $('.app-form-edit').submit(function(e){

        e.preventDefault();

        var $form   = $(this),
            id      = $form.attr('id'),
            table   = $form.data('table'),
            modalId = $form.data('modalId'),
            tableDt = $('#' + table).DataTable();

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            success: function(r) {
                if (table !== void 0)
                    tableDt.ajax.reload();

                $('#' + modalId + ' .modal-body').html('');
                $('#' + modalId).modal('hide');

            },
            error: function(r) {
                var errors, html;
                $('#' + id + ' .form-group').removeClass('has-error');
                errors = '<ul>';
                $.each(r.responseJSON, function(key, val) {
                    errors += '<li>' + val + '</li>';
                    return $('#' + id + ' #' + key).parent().addClass('has-error');
                });
                errors += '</ul>';

                html = '<div class="alert alert-danger alert-dismissible fade in" role="alert" data-dismiss="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>' + errors + '</div>';
                $('#' + id + ' .alert-wrapper').html(html);
                $('#' + id + ' .save').removeClass('disabled');
            }
        });
    });
}

/**
 * Menampilkan modal dialog untuk edit item
 *
 * @param t
 * @returns {*|jQuery}
 */
function showEdit (anchor)
{
    var $this       = $(anchor)
        , modalId   = $this.data('modalId')
        , title     = $this.data('title')
        , url       = $this.data('url');


    $('#' + modalId + '-label').html(title);
    $.get(url, function(r) {
        return $('#' + modalId + ' .modal-body').html(r);
    });
    return $('#' + modalId).modal();
}

/**
 * Show confirm dialog box
 *
 * @param anchor
 * @returns {*}
 */
function confirmDelete (anchor) {

    var $this = $(anchor)
        , _token = $this.data('token')
        , url = $this.data('url')
        , table = $this.data('table')
        , tableDt = $('#' + table).DataTable();

    return bootbox.confirm('Are you sure want to delete this item?', function (answer) {
        if(answer) {
            $.post(url, {
                _method: 'DELETE',
                _token: _token
            }, function (r) {
                if (r === '1' || r === 1 || r === true) {
                    tableDt.ajax.reload();
                }
            });
        }
    });
}


$(function(){
    if(window.location.href == baseUrl + '/profile') {
        console.log('profile');
        localStorage.removeItem('menu-active-id');
    }

    $('.sidebar-menu li > a').click(function(){
        var $this = $(this);
        var href = $this.attr('href');

        if (href != 'javascript:void(0)')
        {
            localStorage.setItem("menu-active-id", $this.parent().attr('id'));
        }
    });


    $('.sidebar-menu .submenu').removeClass('active');
    $('.sidebar-menu .submenu > ul > li').removeClass('active');
    $('.sidebar-menu .submenu.active > a > span.selected').remove();

    $('.sidebar-menu > li').removeClass('active');

    var activeId = localStorage.getItem('menu-active-id');

    if(activeId != undefined) {
        $('.sidebar-menu .submenu #' + activeId).addClass('active');
        $('.sidebar-menu .submenu #' + activeId).parent().parent().addClass('active');

        $('.sidebar-menu #' + activeId).addClass('active');

        // $('.submenu#setting').addClass('active');
        $('.sidebar-menu .active > a').append('<span class="selected"></span>');
    }


});

function formatMoney (n, c, d, t)
{
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
/*
Number.prototype.formatMoney = function(c, d, t){
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};*/

// Execute here

saveForm();
saveAchievement();