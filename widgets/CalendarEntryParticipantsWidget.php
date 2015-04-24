<?php

/**
 * HumHub
 * Copyright © 2014 The HumHub Project
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 */

/**
 * Description of CalendarEntryDateWidget
 *
 * @author luke
 */
class CalendarEntryParticipantsWidget extends HWidget
{

    public $calendarEntry;

    public function run()
    {
        // Count statistics of participants
        $countAttending = CalendarEntryParticipant::model()->countByAttributes(array('calendar_entry_id' => $this->calendarEntry->id, 'participation_state' => CalendarEntryParticipant::PARTICIPATION_STATE_ACCEPTED));
        $countDeclined = CalendarEntryParticipant::model()->countByAttributes(array('calendar_entry_id' => $this->calendarEntry->id, 'participation_state' => CalendarEntryParticipant::PARTICIPATION_STATE_DECLINED));

        // TODO: get participants and *sort* by recommendation -- so integration with recommendation will be needed

        $displayNumber = 4;
        $criteria = new CDbCriteria();
        $criteria->alias = "user";
        $criteria->join = "LEFT JOIN calendar_entry_participant on user.id = calendar_entry_participant.user_id";
        $criteria->condition = "calendar_entry_participant.calendar_entry_id = :entryId AND calendar_entry_participant.participation_state = :state";
        $criteria->limit = $displayNumber;
        $criteria->params = array(':entryId' => $this->calendarEntry->id, ':state' => CalendarEntryParticipant::PARTICIPATION_STATE_ACCEPTED);

        $users = User::model()->findAll($criteria);

        $this->render('participants', array(
            'calendarEntry' => $this->calendarEntry,
            'countAttending' => $countAttending,
            'countDeclined' => $countDeclined,
            'users' => $users,
        ));
    }

}
