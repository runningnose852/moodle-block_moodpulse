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

/**
 * Edit form for the Mood Pulse block.
 *
 * @package   block_moodpulse
 * @copyright 2026 Wan Ling
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_moodpulse_edit_form extends block_edit_form {

    /**
     * Add block-specific settings to the edit form.
     *
     * @param MoodleQuickForm $mform form object.
     * @return void
     */
    protected function specific_definition($mform) {
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_questiontext', get_string('configquestiontext', 'block_moodpulse'));
        $mform->setDefault('config_questiontext', get_string('question', 'block_moodpulse'));
        $mform->setType('config_questiontext', PARAM_TEXT);
    }
}
