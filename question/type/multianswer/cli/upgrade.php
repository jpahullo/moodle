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
 * Multi-answer question type upgrade code.
 *
 * @package    qtype
 * @subpackage multianswer
 * @copyright  1999 onwards Martin Dougiamas {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * @author Jordi Pujol-Ahulló <jordi.pujol@urv.cat>
 * @copyright 2016 Servei de Recursos Educatius (http://www.sre.urv.cat)
 */

define('CLI_SCRIPT', true);

require_once(__DIR__ . '/../../../../config.php');

global $CFG, $DB;

require_once($CFG->libdir . '/clilib.php');

cli_logo();
cli_heading("Question type multianswer upgrader");

$columns = $DB->get_columns('question_multianswer');
$sequence = $columns['sequence'];
if ($sequence->type === 'varchar') {
    cli_writeln(" * Upgrading question_multianswer.sequence column to type text...");
    $plugin = new stdClass();
    include(__DIR__ . '/../version.php'); //gets $plugin information
    require_once($CFG->libdir . '/upgradelib.php');
    require_once(__DIR__ . '/../db/upgrade.php');
    $dbman = $DB->get_manager();
    xmldb_qtype_multianswer_upgrade_sequence_to_text($dbman, $plugin->version);
    cli_writeln("   ... done!");
} else {
    cli_writeln(' * All is ok! Good for you!');
}

cli_heading("End question type multianswer upgrader");
