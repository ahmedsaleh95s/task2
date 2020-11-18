
$(document).ready(function () {
    $('.login-info-box').fadeOut();
    $('.login-show').addClass('show-log-panel');
});


$('.login-reg-panel input[type="radio"]').on('change', function () {
    if ($('#log-login-show').is(':checked')) {
        $('.register-info-box').fadeOut();
        $('.login-info-box').fadeIn();

        $('.white-panel').addClass('right-log');
        $('.register-show').addClass('show-log-panel');
        $('.login-show').removeClass('show-log-panel');

    }
    else if ($('#log-reg-show').is(':checked')) {
        $('.register-info-box').fadeIn();
        $('.login-info-box').fadeOut();

        $('.white-panel').removeClass('right-log');

        $('.login-show').addClass('show-log-panel');
        $('.register-show').removeClass('show-log-panel');
    }
});

$('.login-btn').click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/api/login",
        data: {
            email: $('#email').val(),
            password: $('#password').val()
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('.success-alert-login').append('<div class="alert alert-success"><strong>Login successfully</strong></div>');
            $(".success-alert-login").fadeOut(3000);
            localStorage.setItem("user", JSON.stringify(data.user));
            localStorage.setItem("token", JSON.stringify(data.token.access_token));
            window.location.replace("/user/all");
        },
        error: function (xhr) {
            var errors = xhr.responseJSON.errors;
            if (xhr.status == 422) {
                $('.white-panel').append('<div class="alert-error-login"><div>* '+ errors.email+'</div><div>* '+ errors.password+'</div></div>')
            }
        }
    });
});

$(".register-btn").click(function (e) { 
    e.preventDefault();
    var formData = new FormData(document.getElementById("form"));
    $.ajax({
        type: "POST",
        url: "/api/rigister",
        data: formData,
        dataType: 'json',
        contentType: false,
        processData : false,
        success: function (data) {
            $('.success-alert-login').append('<div class="alert alert-success"><strong>Registed successfully</strong></div>');
            $(".success-alert-login").fadeOut(3000);
            window.location.replace("/user/login");
        },
        error: function (xhr) {
            var errors = xhr.responseJSON.errors;
            if (xhr.status == 422) {
                $('.white-panel').append('<div class="alert-error-login"><div>* '+ errors.email+'</div><div>* '+ errors.password+'</div></div>')
            }
        }
    });
});