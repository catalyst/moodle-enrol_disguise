<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();

/**
 * Class enrol_disguise_plugin
 *
 * @author  Nathan Nguyen <nathannguyen@catalyst-au.net>
 * @copyright  Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class enrol_disguise_plugin extends enrol_plugin {

    public function can_add_instance($courseid) {
        // Do not allow user to add enrolment method to the course.
        return false;
    }

    public function can_hide_show_instance($instance) {
        return true;
    }

    public function can_delete_instance($instance) {
        return true;
    }

    public function add_instance($course, array $fields = NULL) {
        global $DB;
        // Check if there is existing enrol disguise instance.
        $enrolrecords = $DB->get_records('enrol',[
            'enrol' => 'disguise',
            'courseid' => $course->id,
        ]);

        // Prevent duplicate enrol disguise instance.
        if (count($enrolrecords) > 0) {
            $instance = reset($enrolrecords);
            return $instance->id;
        }

        return parent::add_instance($course, $fields);
    }

}
