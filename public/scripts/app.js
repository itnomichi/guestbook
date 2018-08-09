function fn_signin() {
    var username = $("#username").val();
    var password = $("#password").val();

    $.ajax({
        method: "POST",
        url: "/signin",
        data: {username: username, password: password},
        dataType: "json"
    }).done(function (response) {
        if (response.status == true)
            window.location.href = "/";
        else
            jQuery("#login-error").show();
    }).fail(function(xhr, err) {
        bootbox.alert(xhr.statusText);
    });
}

function fn_cancel() {
    fn_clear_cfm();
    fn_move_cfm(0);
}

function fn_edit(comment_id) {
    fn_move_cfm(comment_id);
    var ed_cm = $("#div-cm-" + comment_id);
    var comment_name = ed_cm.find("input[name=comment_name]").val();
    var comment_body = ed_cm.find("textarea[name=comment_body]").val();
    var cfm = $("#comment-form");
    cfm.find("#fm_comment_id").val(comment_id);
    cfm.find("#fm_comment_body").val(comment_body);
    cfm.find("#fm_comment_name").val(comment_name);
    $("#comment-form").find('textarea').focus();
}

function fn_delete(comment_id) {
    bootbox.confirm({
        message: "Do you want to delete it?", buttons: {
            confirm: {
                label: 'Yes', className: 'btn-success'
            }, cancel: {
                label: 'No', className: 'btn-danger'
            }
        }, callback: function (result) {
            if (result == true) {
                fn_clear_cfm();
                fn_move_cfm(0);
                $.ajax({
                    method: "POST", url: "/delete", data: {comment_id: comment_id}, dataType: "json"
                }).done(function (response) {
                    if (response.status == true) {
                        fn_delete_callback(comment_id);
                    } else {
                        bootbox.alert(response.message);
                    }
                }).fail(function(xhr, err) {
                    bootbox.alert(xhr.statusText);
                });
            }
        }
    });
}

function fn_delete_callback(comment_id) {
    $("#li-cm-" + comment_id).remove();
}

function fn_move_cfm(comment_id) {

    var cfm = $("#comment-form");
    if (comment_id == '0') {
        var cm = $("#add-entry");
        cm.append(cfm);
        $("#add-entry-cancel").hide();
    } else {
        var cm = $("#div-cm-" + comment_id);
        cm.append(cfm);
        $("#add-entry-cancel").show();
    }
}

function fn_save() {
    var cfm = $("#comment-form");
    var fm_comment_id = cfm.find("#fm_comment_id").val();
    var fm_comment_body = cfm.find("#fm_comment_body").val();
    var fm_comment_name = cfm.find("#fm_comment_name").val();

    var url = "/create";
    if (fm_comment_id !== '0') {
        url = "/update";
    }
    $.ajax({
        method: "POST", url: url, data: {
            comment_id: fm_comment_id, comment_body: fm_comment_body, comment_name: fm_comment_name
        }, dataType: "json"
    }).done(function (response) {
        if (response.status == true) {
            if (fm_comment_id == 0) {
                fn_create_callback(response);
            }else{
                fn_update_callback(response);
            }
        } else {
            bootbox.alert(response.message);
        }
    });
}

function fn_update_callback(response) {

    var ed_cm = $("#div-cm-" + response.comment_id);
    ed_cm.find("input[name=comment_name]").val(response.comment_name);
    ed_cm.find("textarea[name=comment_body]").val(response.comment_body);

    ed_cm.find("p.jkn").html(response.fm_comment_name + '-' + response.timestamp);
    ed_cm.find("p.cmbd").html(response.fm_comment_body);

    fn_clear_cfm();
    fn_move_cfm(0);
}

function fn_create_callback(response) {
    var html = fn_make_comment_html(response);
    $("#comments").find('ol').append(html);
    fn_clear_cfm();
    fn_move_cfm(0);
}

function fn_make_comment_html(response){
    var html = '';
    html += '<li class="lkh" id="li-cm-' + response.comment_id + '">';
    html += '<div id="div-cm-' + response.comment_id + '">';
    html += '<input type="hidden" name="comment_name" value="' + response.comment_name + '">';
    html += '<textarea name="comment_body" style="display: none">' + response.comment_body + '</textarea>';
    html += '<p class="jkn">' + response.fm_comment_name + ' - ' + response.timestamp + '</p>';
    html += '<div class="yhk">';
    html += '<p class="cmbd">' + response.fm_comment_body + '</p>';
    if(response.login == true) {
        html += '<p class="thdrpy">';
        html += '[<a href="javascript:void(0)" onclick="fn_edit(' + response.comment_id + ')">Edit</a>]';
        html += '[<a href="javascript:void(0)" onclick="fn_delete(' + response.comment_id + ')">Delete</a>]';
        html += '</p>';
    }
    html += '</div>';
    html += '</div>';
    html += '</li>';
    return html;
}

function fn_clear_cfm() {
    var cfm = $("#comment-form");
    cfm.find("#fm_comment_id").val("0");
    cfm.find("#fm_comment_body").val("");
    cfm.find("#fm_comment_name").val("");
}