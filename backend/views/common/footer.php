<?php $this->registerJs('$(".user-mascot").addClass("horo")') ?>
<?php $this->registerJs('$(".user-level").attr("src", "images/levels/first.png")') ?>
<?php $this->registerJs('$(".user-level").attr("title", "Уровень 1")') ?>

<footer id="content-footer">
    <div class="row">
        <div class="col-md-1 user-mascot horo ml20"></div>
        <div class="col-md-3 mr7e pt15 pull-right">
            <img class="user-level" src="" title="" />
            <div class="skillbar clearfix " data-percent="25%">
                <div class="skillbar-bar hint--right hint--bounce" data-hint="120 XP"></div>
                <div class="skill-bar-percent">ещё 100 XP</div>
            </div>
        </div>
    </div>
</footer>