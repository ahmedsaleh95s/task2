$('.wrapper').click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/api/admin/login",
        data: {
            email: $('#userName').val(),
            password: $('#userPassword').val()
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('.success-alert-login').append('<div class="alert alert-success"><strong>Login successfully</strong></div>');
            $(".success-alert-login").fadeOut(3000);
            localStorage.setItem("admin", JSON.stringify(data.user));
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