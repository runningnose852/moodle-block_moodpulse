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
 * Mood Pulse block.
 *
 * @package   block_moodpulse
 * @copyright 2026 Wan Ling
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_moodpulse extends block_base {

    /**
     * Initialise the block.
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_moodpulse');
    }

    /**
     * Define where the block can be added.
     *
     * @return array
     */
    public function applicable_formats() {
        return [
            'course-view' => true,
            'site-index' => false,
        ];
    }

    /**
     * Whether the block has global config.
     *
     * @return bool
     */
    public function has_config() {
        return false;
    }

    /**
     * Get block content.
     *
     * @return stdClass
     */
    public function get_content() {
        global $USER, $COURSE, $DB, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        $context = context_block::instance($this->instance->id);
        $canvote = has_capability('block/moodpulse:vote', $context);

        $mood = optional_param('mood', '', PARAM_ALPHA);
        $sesskeyparam = optional_param('sesskey', '', PARAM_RAW);

        $allowedmoods = ['happy', 'excited', 'okay', 'confused', 'tired'];
        $moodmap = [
            'happy' => '😊',
            'excited' => '🤩',
            'okay' => '😐',
            'confused' => '😵',
            'tired' => '😴',
        ];

        $startofday = strtotime('today midnight');
        $endofday = strtotime('tomorrow midnight') - 1;

        $existingvote = $DB->get_record_sql(
            "SELECT mood
               FROM {block_moodpulse}
              WHERE userid = ?
                AND courseid = ?
                AND timecreated >= ?
                AND timecreated <= ?",
            [$USER->id, $COURSE->id, $startofday, $endofday]
        );

        if (!empty($mood) &&
            in_array($mood, $allowedmoods, true) &&
            confirm_sesskey($sesskeyparam) &&
            isloggedin() &&
            !isguestuser() &&
            !$existingvote &&
            $canvote) {

            $record = new stdClass();
            $record->userid = $USER->id;
            $record->courseid = $COURSE->id;
            $record->mood = $mood;
            $record->timecreated = time();

            $DB->insert_record('block_moodpulse', $record);

            redirect(new moodle_url('/course/view.php', ['id' => $COURSE->id]));
        }

        $records = $DB->get_records_select(
            'block_moodpulse',
            'courseid = ? AND timecreated >= ? AND timecreated <= ?',
            [$COURSE->id, $startofday, $endofday]
        );

        $counts = array_fill_keys($allowedmoods, 0);
        foreach ($records as $record) {
            if (isset($counts[$record->mood])) {
                $counts[$record->mood]++;
            }
        }

        $totalvotes = count($records);
        $results = [];

        foreach ($moodmap as $key => $emoji) {
            $count = $counts[$key];
            $percent = $totalvotes ? round(($count / $totalvotes) * 100) : 0;

            $results[] = [
                'key' => $key,
                'emoji' => $emoji,
                'label' => get_string($key, 'block_moodpulse'),
                'count' => $count,
                'percent' => $percent,
            ];
        }

        $moods = [];
        $actionurl = (new moodle_url('/course/view.php', ['id' => $COURSE->id]))->out(false);

        foreach ($moodmap as $key => $emoji) {
            $moods[] = [
                'key' => $key,
                'emoji' => $emoji,
                'label' => get_string($key, 'block_moodpulse'),
                'sesskey' => sesskey(),
                'actionurl' => $actionurl,
            ];
        }

        $questiontext = !empty($this->config->questiontext)
            ? format_string($this->config->questiontext)
            : get_string('question', 'block_moodpulse');

        $templatecontext = [
            'editing' => $this->page->user_is_editing(),
            'editinghint' => get_string('editinghint', 'block_moodpulse'),
            'questiontext' => $questiontext,
            'canvote' => $canvote,
            'hasvoted' => !empty($existingvote),
            'thankyou' => get_string('thankyou', 'block_moodpulse'),
            'checkedintoday' => get_string('checkedintoday', 'block_moodpulse', $totalvotes),
            'resultsheading' => get_string('resultsheading', 'block_moodpulse'),
            'novotes' => get_string('novotes', 'block_moodpulse'),
            'hasresults' => $totalvotes > 0,
            'moods' => $moods,
            'results' => $results,
        ];

        $this->content->text = $OUTPUT->render_from_template('block_moodpulse/moodpulse', $templatecontext);

        return $this->content;
    }
}
