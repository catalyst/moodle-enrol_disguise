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

namespace tests;

defined('MOODLE_INTERNAL') || die();

/**
 * Tests for the enrol_disguise_plugin class.
 *
 * @package enrol_disguise
 * @author  Nathan Nguyen <nathannguyen@catalyst-au.net>
 * @copyright  Catalyst IT
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class lib_test extends \advanced_testcase {

    /**
     * Test that user can add new enrol instance.
     */
    public function test_can_add_instance() {
        $this->resetAfterTest();
        self::setAdminUser();
        $course = self::getDataGenerator()->create_course();
        $enrolplugin = \enrol_get_plugin('disguise');
        $canaddinstance = $enrolplugin->can_add_instance($course->id);

        $this->assertFalse($canaddinstance, "The enrol instance should not be added by user.");
    }

    /**
     * Test that user can hide/show enrol instance.
     */
    public function test_can_hide_show_instance() {
        $this->resetAfterTest();
        self::setAdminUser();
        $course = self::getDataGenerator()->create_course();
        $enrolplugin = \enrol_get_plugin('disguise');
        $canhideshowinstance = $enrolplugin->can_hide_show_instance($course->id);

        $this->assertTrue($canhideshowinstance, "User should be able to hide/show the enrol instance.");
    }

    /**
     * Test that user can delete enrol instance.
     */
    public function test_can_delete_instance() {
        $this->resetAfterTest();
        self::setAdminUser();
        $course = self::getDataGenerator()->create_course();
        $enrolplugin = \enrol_get_plugin('disguise');
        $candeleteinstance = $enrolplugin->can_delete_instance($course->id);

        $this->assertTrue($candeleteinstance, "User should be able to delete the enrol instance.");
    }

    /**
     * Test that there is only one enrol instance.
     */
    public function test_no_duplicate_instance() {
        global $DB;
        $this->resetAfterTest();
        $course = self::getDataGenerator()->create_course();
        $enrolplugin = \enrol_get_plugin('disguise');

        // Add enrol disguise instance.
        $enrolplugin->add_instance($course);
        // Check if there is only one enrol disguise instance.
        $enrolrecords = $DB->count_records('enrol',[
            'enrol' => 'disguise',
            'courseid' => $course->id,
        ]);
        $this->assertEquals(1, $enrolrecords);

        // Add enrol disguise instance again.
        $enrolplugin->add_instance($course);

        // Check if there is only one enrol disguise instance.
        $enrolrecords = $DB->count_records('enrol',[
            'enrol' => 'disguise',
            'courseid' => $course->id,
        ]);
        $this->assertEquals(1, $enrolrecords);

    }
}
