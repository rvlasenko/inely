<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

\backend\assets\ScheduleAsset::register($this);

$main = "$('ul.panel-tabs li:nth-child(2)').addClass('active')";
$this->registerJs($main, $this::POS_END);

?>

<!-- begin: .tray-left -->
<aside class="tray tray-left tray290" data-tray-mobile="#content > .tray-center">
    <div class="fc-title-clone"></div>

    <div class="section admin-form theme-primary">
        <div class="inline-mp center-block"></div>
    </div>

    <h4 class="pl10 mt25">Events
        <a id="compose-event-btn" href="#calendarEvent" data-effect="mfp-flipInY">
            <span class="fa fa-plus-square"></span>
        </a>
    </h4>
    <hr class="mv15 br-light">
    <div id="external-events" class="bg-dotted">

        <!-- Standard Events -->
        <div class='fc-event fc-event-primary' data-event="primary">
            <div class="fc-event-icon">
                <span class="fa fa-exclamation"></span>
            </div>
            <div class="fc-event-desc"><b>2:30am - </b>Meeting With Mike</div>
        </div>
        <div class='fc-event fc-event-info' data-event="info">
            <div class="fc-event-icon">
                <span class="fa fa-info"></span>
            </div>
            <div class="fc-event-desc"><b>2:30am - </b>Meeting With Mike</div>
        </div>
        <div class='fc-event fc-event-success' data-event="success">
            <div class="fc-event-icon">
                <span class="fa fa-check"></span>
            </div>
            <div class="fc-event-desc"><b>2:30am - </b>Meeting With Mike</div>
        </div>
        <div class='fc-event fc-event-warning' data-event="warning">
            <div class="fc-event-icon">
                <span class="fa fa-question"></span>
            </div>
            <div class="fc-event-desc"><b>2:30am - </b>Meeting With Mike</div>
        </div>

    </div>
    <h4 class="mt30"> Labels </h4>
    <hr class="mv15 br-light">
    <ul class="list-group">
        <li class="list-group-item">
            <span class="badge badge-primary">14</span>
            Entertainment
        </li>
        <li class="list-group-item">
            <span class="badge badge-success">9</span>
            Movies
        </li>
        <li class="list-group-item">
            <span class="badge badge-info">11</span>
            TV Shows
        </li>
        <li class="list-group-item">
            <span class="badge badge-warning">18</span>
            Celebs &amp; Gossip
        </li>

    </ul>
</aside>
<!-- end: .tray-left -->

<!-- begin: .tray-center -->
<div class="tray tray-center" style="height: 642px;">

    <!-- Calendar -->
    <div id="calendar" class="admin-theme fc fc-ltr fc-unthemed"></div>

</div>
<!-- end: .tray-center -->

<div class="admin-form theme-primary popup-basic popup-lg mfp-with-anim mfp-hide" id="calendarEvent">
    <div class="panel">
        <div class="panel-heading">
        <span class="panel-title">
          <i class="fa fa-pencil-square"></i>New Calendar Event
        </span>
        </div>
        <!-- end .form-header section -->

        <form method="post" action="/" id="calendarEventForm">
            <div class="panel-body p25">
                <div class="section-divider mt10 mb40">
                    <span>Event Details</span>
                </div>
                <!-- .section-divider -->

                <div class="section row">
                    <div class="col-md-6">
                        <label for="firstname" class="field prepend-icon">
                            <input type="text" name="firstname" id="firstname" class="gui-input" placeholder="Event Coordinator">
                            <label for="firstname" class="field-icon">
                                <i class="fa fa-user"></i>
                            </label>
                        </label>
                    </div>
                    <!-- end section -->

                    <div class="col-md-6">
                        <label for="eventDate" class="field prepend-icon">
                            <input type="text" id="eventDate" name="eventDate" class="gui-input hasDatepicker" placeholder="Event Date">
                            <label class="field-icon">
                                <i class="fa fa-calendar"></i>
                            </label>
                        </label>
                    </div>
                    <!-- end section -->
                </div>
                <!-- end .section row section -->

                <div class="section">
                    <label for="email" class="field prepend-icon">
                        <input type="email" name="email" id="email" class="gui-input" placeholder="Contact Email">
                        <label for="email" class="field-icon">
                            <i class="fa fa-envelope"></i>
                        </label>
                    </label>
                </div>
                <!-- end section -->

                <div class="section">
                    <div class="smart-widget sm-right smr-140">
                        <label for="username" class="field prepend-icon">
                            <input type="text" name="username" id="username" class="gui-input" placeholder="Event Title">
                            <label for="username" class="field-icon">
                                <i class="fa fa-flag"></i>
                            </label>
                        </label>
                        <label for="username" class="button">company.com</label>
                    </div>
                    <!-- end .smart-widget section -->
                </div>
                <!-- end section -->

                <div class="section">
                    <label class="field prepend-icon">
                        <textarea class="gui-textarea" id="comment" name="comment" placeholder="Event Description"></textarea>
                        <label for="comment" class="field-icon">
                            <i class="fa fa-comments"></i>
                        </label>
              <span class="input-footer hidden">
                <strong>Hint:</strong>Don't be negative or off topic! just be awesome...</span>
                    </label>
                </div>
                <!-- end section -->

            </div>
            <!-- end .form-body section -->
            <div class="panel-footer text-right">
                <button type="submit" class="button btn-primary">Create Event</button>
            </div>
            <!-- end .form-footer section -->
        </form>
    </div>
    <!-- end .admin-form section -->
</div>