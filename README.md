Mood Pulse

Mood Pulse is a Moodle block that allows students to quickly share their current mood during a course session using simple emoji buttons. The block aggregates responses and displays the overall class mood in real time.

Teachers can customise the prompt question and monitor the distribution of responses to better understand student engagement and wellbeing.

Features

- Students can vote once per day within a course.
- Emoji-based mood selection for quick interaction.
- Aggregated class mood results displayed in the block.
- Progress bar visualisation of mood distribution.
- Teacher-configurable question prompt.
- Role-based permission control using Moodle capabilities.
- Modern UI using Mustache templates and CSS styling.

Usage

Turn editing on in a course.
Add the Mood Pulse block.
Students select a mood using the emoji buttons.
The block displays the aggregated results for the class.
Teachers can customise the question by opening Configure Mood Pulse block.

Data stored

The plugin stores the following information:
User ID
Course ID
Selected mood
Timestamp of the vote
This data is used only to calculate mood distribution within the course.

Installing via uploaded ZIP file

Log in to your Moodle site as an admin.

Go to Site administration → Plugins → Install plugins.

Upload the ZIP file containing the plugin.

Follow the installation prompts and complete the upgrade.

Installing manually

Copy the plugin directory into:

{your/moodle/dirroot}/blocks/moodpulse

Then visit:

Site administration → Notifications

to complete the installation.

Alternatively, run:

php admin/cli/upgrade.php
Requirements

Moodle 5.0 or later

License

2026 Wan Ling runningcalligraphy@gmail.com

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY, without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

See the GNU General Public License for more details:
https://www.gnu.org/licenses/
