<div class="panel panel-default event">
    <style>
    .map-holder{
        margin-left:-15px; margin-right: -15px;
    }

    .event-title{
      max-width: 76%;
      margin-top: -50%;
      margin-left: 122px;
      font-size: 18px;
      margin-bottom: 88px;
    }
    .datetime{ font-size: 16px;
          margin-top: -80px;
  margin-left: 122px;
    }

    .event-details{
        margin-top: 20%;
    }

    .event-details h2{
        padding: 5px 0;
    }

    </style>
    <div class="panel-body">
        <div class="map-holder">
            <img src="/img/comotion_events_hero.png" style="width:100%;"/>
        </div>
        <h1 class="event-title">
            <?php echo CHtml::encode($calendarEntry->title); ?>
            <!--
            <?php if ($calendarEntry->is_public): ?>
                <span class="label label-success"><?php echo Yii::t('CalendarModule.views_entry_view', 'Public'); ?></span>
            <?php endif; ?>
            -->
        </h1>

         <h2 class="datetime">
            <?php $this->widget('application.modules.calendar.widgets.CalendarEntryDateWidget', array('calendarEntry'=>$calendarEntry)); ?>
         </h2>

        <div class="event-details">
            <h2>About</h2>
            <?php $this->beginWidget('CMarkdown'); ?><?php echo nl2br(CHtml::encode($calendarEntry->description)); ?><?php $this->endWidget(); ?>
        </div>

        <hr class=""/>

        <h3>Attending</h3>

        <?php $this->widget('application.modules.calendar.widgets.CalendarEntryParticipantsWidget', array('calendarEntry'=>$calendarEntry)); ?>

        <hr class=""/>

       

        <p class="location"><i class="fa fa-map-marker"></i> <?php echo CHtml::encode($calendarEntry->location); ?></p>

        <hr class=""/>

        

        <div class="">
            <?php if ($userCanRespond && !$userAlreadyResponded): ?>
                <?php echo CHtml::link(Yii::t('CalendarModule.views_entry_view', "Attend"), $this->createContainerUrl('/calendar/entry/respond', array('type' => CalendarEntryParticipant::PARTICIPATION_STATE_ACCEPTED, 'id' => $calendarEntry->id)), array('class' => 'btn btn-primary')); ?>
                <?php echo CHtml::link(Yii::t('CalendarModule.views_entry_view', "Decline"), $this->createContainerUrl('/calendar/entry/respond', array('type' => CalendarEntryParticipant::PARTICIPATION_STATE_DECLINED, 'id' => $calendarEntry->id)), array('class' => 'btn btn-primary')); ?>
            <?php endif; ?>

            <?php if ($userAlreadyResponded): ?>
                <?php
                $participationModes = array();
                $participationModes[CalendarEntryParticipant::PARTICIPATION_STATE_ACCEPTED] = Yii::t('CalendarModule.views_entry_view', "I´m attending");
                $participationModes[CalendarEntryParticipant::PARTICIPATION_STATE_DECLINED] = Yii::t('CalendarModule.views_entry_view', "I´m not attending");
                ?>

                <div class="btn-group">
                    <button type="button" class="btn btn-primary"><?php echo $participationModes[$calendarEntryParticipant->participation_state]; ?></button>
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <?php
                        unset($participationModes[$calendarEntryParticipant->participation_state]);
                        ?>

                        <?php foreach ($participationModes as $participationMode => $title): ?>
                            <li><?php echo CHtml::link($title, $this->createContainerUrl('/calendar/entry/respond', array('type' => $participationMode, 'id' => $calendarEntry->id)), array('class' => '')); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div>
                <br />
                <?php if ($calendarEntry->content->canWrite()) : ?>
                    <?php echo HHtml::link(Yii::t('CalendarModule.views_entry_view', 'Edit this event'), '#', array('class' => 'btn btn-primary btn-sm', 'onclick' => 'openEditModal(' . $calendarEntry->id . ')')); ?>
                <?php endif; ?>
            </div>
            <br />
        </div>



<!--
<?php //echo HHtml::link($calendarEntry->content->user->displayName, $calendarEntry->content->user->getUrl()); ?>
-->

        <!-- <a href="#">Download ICal</a> &middot; -->
        <?php $this->widget('application.modules_core.like.widgets.LikeLinkWidget', array('object' => $calendarEntry)); ?> &middot;
        <?php $this->widget('application.modules_core.comment.widgets.CommentLinkWidget', array('object' => $calendarEntry)); ?>
        <?php $this->widget('application.modules_core.comment.widgets.CommentsWidget', array('object' => $calendarEntry)); ?>


    </div>

</div>

<script>
    function openEditModal(id) {
        var editUrl = '<?php echo Yii::app()->getController()->createContainerUrl('entry/edit', array('id' => '-id-')); ?>';
        editUrl = editUrl.replace('-id-', encodeURIComponent(id));
        $('#globalModal').modal({
            show: 'true',
            remote: editUrl
        });
    }
</script>
