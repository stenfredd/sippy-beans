<div class="popup" id="popup">
    <div class="popup__inner">
        <div class="popup__inner-context entrance-text text-center">
            <h3>Thanks!</h3>
            <p>Password recovery instruction have been sent to email <span class="popup-email">zouhierfathallah@gmail.com</span>
            </p>
            <button class="btn btn-orange btn-inline btn-lg mt-4 btn-popup">Ok</button>
            <div class="close">
                <div class="close__inner">
                    <span class="close__l"></span>
                    <span class="close__r"></span>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $('.close').click(function (e) {
        $('#popup').slideToggle(300);
    })
    $('.btn-popup').click(function (e) {
        $('#popup').slideToggle(300);
    })
    //все что  внутри '.popup__inner-context не будет реагировать на клик
    $('#popup').click(function (e) {
        if (!$('.close').is(e.target) && !$('.btn-popup').is(e.target) && !$('.popup__inner-context').is(e.target) && $('.popup__inner-context').has(e.target).length === 0) $('#popup').slideToggle(300);
    })
</script>