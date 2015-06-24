<?php
    $this->registerJsFile('plugins/typed/typed.js');
?>

<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
    <div class="error-container">
        <div class="error-main">
            <h1><span id="404"></span></h1>
            <h3><span id="404-txt"></span></h3>
            <h4><span id="404-txt-2"></span></h4>
            <br>
            <div class="row" id="content-404">
                <button class="btn btn-dark" type="button">
                    <a href="../">Возвращаюсь!</a>
                </button>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="copyright">© Copyright Me, 2015</div>
</div>
<script>
    $(function(){
        $("#404").typed({
            strings: ["404"],
            typeSpeed: 200,
            backDelay: 500,
            loop: false,
            contentType: 'html',
            loopCount: false,
            callback: function() {
                $('h1 .typed-cursor').css('-webkit-animation', 'none').animate({opacity: 0}, 400);
                $("#404-txt").typed({
                    strings: ["К сожалению, такой страницы не существует."],
                    typeSpeed: 1,
                    backDelay: 500,
                    loop: false,
                    contentType: 'html',
                    loopCount: false,
                    callback: function() {
                        $('h3 .typed-cursor').css('-webkit-animation', 'none').animate({opacity: 0}, 400);
                        $("#404-txt-2").typed({
                            strings: ["Вероятно она была удалена, либо её здесь никогда не было."],
                            typeSpeed: 1,
                            backDelay: 500,
                            loop: false,
                            contentType: 'html',
                            loopCount: false,
                            callback: function() {
                                $('#content-404').delay(300).slideDown();
                            }
                        });
                    }
                });
            }
        });
    });
</script>