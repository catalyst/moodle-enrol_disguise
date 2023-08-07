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
        return true;
    }

    public function add_instance($course, array $fields = NULL) {
        return parent::add_instance($course, $fields);
    }

    public function add_default_instance($course) {
        $fields = [];
        return $this->add_instance($course, $fields);
    }

    public function restore_instance(restore_enrolments_structure_step $step, stdClass $data, $course, $oldid) {
    }

    public function get_instance_defaults() {
        return array();
    }

    public function can_delete_instance($instance) {
        return true;
    }

    public function can_hide_show_instance($instance) {
        return true;
    }

    public function enrol_user(stdClass $instance, $userid, $roleid = null, $timestart = 0, $timeend = 0,
                               $status = null, $recovergrades = null) {
        return;
    }

    public function unenrol_user(stdClass $instance, $userid) {
        return;
    }

    public function get_enrol_info(stdClass $instance) {
        $instanceinfo = new stdClass();
        return $instanceinfo;
    }

    public function use_standard_editing_ui() {
        return true;
    }

    public function edit_instance_validation($data, $files, $instance, $context) {
        return array();
    }

    public function course_updated($inserted, $course, $data) {

    }

    public function edit_instance_form($instance, MoodleQuickForm $mform, $context) {

    }

}
