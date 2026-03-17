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

<<<<<<< HEAD
/**
 * Privacy provider for local_courseprogresslite.
 *
 * @package   local_courseprogresslite
 * @copyright 2026 Jesus Antonio Jimenez Avina <antoniomexdf@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_courseprogresslite\privacy;

=======
namespace local_courseprogresslite\privacy;

defined('MOODLE_INTERNAL') || die();

>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151
use core_privacy\local\metadata\null_provider;

/**
 * Privacy API provider for local_courseprogresslite.
<<<<<<< HEAD
=======
 *
 * This plugin does not store any personal data.
>>>>>>> 11d3c600c46a4ce34975e255d5b2bb8faceb3151
 */
class provider implements null_provider {
    /**
     * Returns reason why this plugin has no personal data.
     *
     * @return string
     */
    public static function get_reason(): string {
        return 'privacy:metadata';
    }
}
