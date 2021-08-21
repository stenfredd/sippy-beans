$(document).ready(function() {
    //закрытие попапа
    $('.close').click(function(e) {
        $('#popup').slideToggle(300);
    })
    $('.btn-popup').click(function(e) {
        $('#popup').slideToggle(300);
    })
    //все что  внутри '.popup__inner-context не будет реагировать на клик
    $('#popup').click(function(e) {
        if (!$('.close').is(e.target) && !$('.btn-popup').is(e.target) && !$('.popup__inner-context').is(e.target) && $('.popup__inner-context').has(e.target).length === 0) $('#popup').slideToggle(300);
    })

    //проверка на корректность повторного пароля
    if ($('.form-confirm').is(':visible')) {


        $(".form-confirm").submit(function(e) {
            var password = $("#password").val();
            var confirmPassword = $("#password-confirm").val();
            if (password != confirmPassword) {
                return false;
            }
        });

        function checkPasswordMatch() {
            let password = $("#password").val(),
                confirmPassword = $("#password-confirm").val(),
                invalid = $(".pass-invalid-feedback");
            label = $('label[for="password-confirm"]');
            if (password != confirmPassword) {
                invalid.html("Passwords do not match!");
                invalid.css('display', 'block');
                label.css('color', '#D80202');
                $("#password-confirm").addClass("is-invalid");
            } else {
                invalid.html("");
                label.css('color', 'rgb(29, 29, 29)');
                invalid.css('display', 'none');
                $("#password-confirm").removeClass("is-invalid");
            }

        }

        $("#password-confirm").keyup(checkPasswordMatch);
    }

    //видимость ввода в инпуте пароль
    if ($('.pass-view').is(':visible')) {
        $('.pass-view').click(function() {
            let input = $(this).siblings('input');
            if (input.attr('type') == 'text') {
                input.attr('type', 'password');
                input.closest('.pass-wrap').removeClass('active');
            } else {
                input.attr('type', 'text');
                input.closest('.pass-wrap').addClass('active');
            }
        })

    }

});