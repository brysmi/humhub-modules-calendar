<?php if ($calendarEntry->participation_mode != CalendarEntry::PARTICIPATION_MODE_NONE) : ?>

    <?php foreach ($users as $user) : ?>
        <?php
        // Check for null user, if there are "zombies" in search index
        if ($user == null)
            continue;
        ?>

        <a href="<?php echo $user->getUrl(); ?>">
            <img class="media-object img-square pull-left"
                 src="<?php echo $user->getProfileImage()->getUrl(); ?>" width="75"
                 height="75" alt="75x75" data-src="holder.js/75x75"
                 style="width: 75px; height: 75px;">
        </a>
        
    <?php endforeach; ?>

    <br />

    <?php
    $title = Yii::t('CalendarModule.widgets_views_participants', "+ :count more", array(':count' => $countAttending-4));
    if ($countAttending > 4) {
        echo HHtml::link($title, $calendarEntry->createContainerUrlTemp('/calendar/entry/userList', array('state' => CalendarEntryParticipant::PARTICIPATION_STATE_ACCEPTED, 'id' => $calendarEntry->id)), array("class" => "tt", "title" => "", "data-toggle" => "modal", "data-target" => '#globalModal', "data-placement" => "top", "data-original-title" => ""));
    } else {
//        echo $title;
    }
    ?>
    <br/>

<?php endif; ?>
