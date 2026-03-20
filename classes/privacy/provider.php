<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Privacy provider for block_moodpulse.
 *
 * @package   block_moodpulse
 * @copyright 2026 Wan Ling
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_moodpulse\privacy;

defined('MOODLE_INTERNAL') || die();

/**
 * Privacy provider for the Mood Pulse block.
 */
class provider implements \core_privacy\local\metadata\null_provider {

    /**
     * Returns the reason why this plugin stores no personal data.
     *
     * @return string
     */
    public static function get_reason(): string {
        return 'privacy:metadata';
    }
}
