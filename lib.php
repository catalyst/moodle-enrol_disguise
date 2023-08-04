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

use enrol_userdisguise\manager\user as user_manager;
/**
 * Class enrol_userdisguise_plugin
 *
 * @author  Nathan Nguyen <nathannguyen@catalyst-au.net>
 * @copyright  Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class enrol_userdisguise_plugin extends enrol_plugin {

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

function enrol_userdisguise_after_require_login() {
    global $USER, $PAGE, $DB;

    // Check if user disguise is enabled.

    // We will need to use Hook API to do this instead of callback.

    // Check if user disguise is enabled

    if (isloggedin() && !isguestuser() ) {
        debugging('User is logged in, but not as a guest. Disguising user.', DEBUG_DEVELOPER);

        // Context ID.
        try {
            // This will throw error if context is empty when AJAX_SCRIPT is true.
            // $PAGE->context is a magic getter, and it is really annoying to do null check, as isset always return false.
            $context = $PAGE->context;
        } catch (Exception $e) {
            debugging('Context is empty.', DEBUG_DEVELOPER);
            return;
        }

        // Check context level to determine whether the disguise is needed.
        switch ($context->contextlevel) {
            case CONTEXT_SYSTEM:
                $disguiseenabled = false;
                break;
            case CONTEXT_COURSE:
                // Exclude site course.
                if ($context->instanceid == SITEID) {
                    $disguiseenabled = false;
                } else {
                    $disguiseenabled = true;
                }

                // Check if disguise is enabled for this course.

                break;
            case CONTEXT_MODULE:
                // Check if disguise is enabled for this module.

                $disguiseenabled = true;
                break;
            case CONTEXT_BLOCK:
                $disguiseenabled = false;
                break;
            case CONTEXT_USER:
                $disguiseenabled = false;
                break;
            default:
                debugging('Unsupported context.', DEBUG_DEVELOPER);
                return;
        }

        if (!$disguiseenabled) {
            debugging('Disguise is not enabled for this context.', DEBUG_DEVELOPER);
            return;
        }

        // Find a disguised user.
        $disguiseduser = user_manager::get_linked_disguised_user($context->id, $USER->id);

        // Use disguise.
        if (!$disguiseduser) {
            debugging('No disguised user found.', DEBUG_DEVELOPER);
            return;
        }

        // Disguise.
        user_manager::disguise_as($context->id, $USER->id, $disguiseduser->id);

        // Enrolment.

        // Role/Permission.

        // Group.

        // Cohort
    }
}
