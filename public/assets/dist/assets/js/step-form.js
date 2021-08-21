$(document).ready(function() {

    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
        // This function will display the specified tab of the form ...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        // ... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn-mobile").style.display = "none";
            document.getElementById("prevBtn").style.display = "none";
            if (window.matchMedia("(max-width: 1024px)").matches) {} else {}
        } else {
            if (window.matchMedia("(max-width: 1024px)").matches) {
                document.getElementById("prevBtn-mobile").style.display = "inline";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }

        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Confirm";
        } else {
            document.getElementById("nextBtn").innerHTML = "Continue";
        }
        // ... and run a function that displays the correct step indicator:
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form... :
        if (currentTab >= x.length) {
            //...the form gets submitted:
            document.getElementById("regForm").submit();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }


    $('#prevBtn').click(function() {
        nextPrev(-1)
    });
    $('#prevBtn-mobile').click(function() {
        nextPrev(-1)
    });
    $('#nextBtn').click(function() {
        nextPrev(1)
    });


    function validateForm() {
        // This function deals with validation of the form fields
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].validationMessage != '') {
                y[i].nextElementSibling.innerHTML = y[i].validationMessage;
                // add an "invalid" class to the field:
                y[i].className += " is-invalid";
                // and set the current valid status to false:
                valid = false;
            }


        }


        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; // return the valid status
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            if (i <= n) {
                x[i].classList.remove('active');
                x[i].classList.add('active');
                //x[i].className += " active";
            } else {
                x[i].classList.remove('active');
            }
        }
    }

    // загрузка фото
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);

        }
    }

    $("#photo").change(function() {
        readURL(this);
    });

    //подсчет символов в инпуте
    $('#about').on('change keyup paste', function() {
        var len = $('#about').val().length;

        $('.about-count').html(len)
    })

    //drag and drop

    let VATDropzone = new Dropzone("#VAT", {
        url: "/file/post",
        maxFiles: 1,
        init: function() {
            $(this.element).html(this.options.dictDefaultMessage);
            //this.on("addedfile", function(file) { $('.prew-text').css('display','none') });
        },
        dictDefaultMessage: '<div class="dz-message">Drag and drop file or click to attach</div>',
    });
    let licence_Dropzone = new Dropzone("#licence", {
        url: "/file/post",
        maxFiles: 1,
        init: function() {
            $(this.element).html(this.options.dictDefaultMessage);
            //this.on("addedfile", function(file) { $('.prew-text').css('display','none') });
        },
        dictDefaultMessage: '<div class="dz-message">Drag and drop file or click to attach</div>',
    });

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