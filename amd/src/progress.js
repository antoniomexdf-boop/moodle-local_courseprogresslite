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
 * Course progress lite widget renderer.
 *
 * @module     local_courseprogresslite/progress
 * @copyright  2026 Jesus Antonio Jimenez Avina <antoniomexdf@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['core/templates'], function(Templates) {

    /**
     * Get a string configuration value.
     *
     * @param {Object} config Widget configuration.
     * @param {string} key Configuration key.
     * @returns {string} The configuration string value or empty string.
     */
    function getConfigString(config, key) {
        return config && config[key] ? config[key] : '';
    }

    /**
     * Get whether a numeric config flag is enabled.
     *
     * @param {Object} config Widget configuration.
     * @param {string} key Configuration key.
     * @param {boolean} fallback Default value when key is absent.
     * @returns {boolean} True when the flag value equals 1.
     */
    function getConfigFlag(config, key, fallback) {
        if (!config || typeof config[key] === 'undefined') {
            return fallback;
        }

        return Number(config[key]) === 1;
    }

    /**
     * Get the normalized percentage value.
     *
     * @param {Object} config Widget configuration.
     * @returns {number} Value clamped between 0 and 100.
     */
    function getNormalizedValue(config) {
        var rawvalue = config && Number.isFinite(Number(config.value)) ? Number(config.value) : 0;

        return Math.max(0, Math.min(100, rawvalue));
    }

    /**
     * Build the template context for the widget.
     *
     * @param {Object} config Raw widget configuration object.
     * @returns {Object} Complete Mustache context ready for template rendering.
     */
    function buildContext(config) {
        var value = getNormalizedValue(config);

        return {
            label: getConfigString(config, 'label'),
            value: value,
            percentage: value + '%',
            maxlabel: getConfigString(config, 'maxlabel') || '100%',
            progressbarlabel: getConfigString(config, 'progressbarlabel'),
            showpercentage: getConfigFlag(config, 'showpercentage', true),
            showactivitysummary: getConfigFlag(config, 'showactivitysummary', false),
            activitysummary: getConfigString(config, 'activitysummary'),
            remainingactivities: getConfigString(config, 'remainingactivities')
        };
    }

    /**
     * Get or create the root widget container.
     *
     * @returns {HTMLElement} The existing or newly created container element.
     */
    function getOrCreateContainer() {
        var container = document.getElementById('local-courseprogresslite');
        if (container) {
            return container;
        }

        container = document.createElement('div');
        container.id = 'local-courseprogresslite';
        container.className = 'local-courseprogresslite';
        container.setAttribute('aria-live', 'polite');
        document.body.insertBefore(container, document.body.firstChild);
        return container;
    }

    /**
     * Move the widget container into the main course content area.
     *
     * @param {HTMLElement} container The widget root element to relocate.
     * @returns {void}
     */
    function moveToCourseContent(container) {
        var selectors = [
            '#region-main',
            '#page-content .container-fluid',
            '#page-content',
            '.course-content'
        ];

        for (var i = 0; i < selectors.length; i++) {
            var target = document.querySelector(selectors[i]);
            if (target) {
                target.insertBefore(container, target.firstChild);
                return;
            }
        }
    }

    /**
     * Initialize and render the progress widget.
     *
     * @param {Object} config Raw widget configuration object.
     * @returns {(Promise<HTMLElement>|undefined)} Promise resolving to the container element, or undefined if already initialized.
     */
    function init(config) {
        var container = getOrCreateContainer();
        if (container.dataset.initialized === '1') {
            return undefined;
        }

        container.dataset.initialized = '1';
        moveToCourseContent(container);

        return Templates.renderForPromise('local_courseprogresslite/progress_widget', buildContext(config))
            .then(function(rendered) {
                return Templates.replaceNodeContents(container, rendered.html, rendered.js);
            })
            .then(function() {
                return container;
            })
            .catch(function(error) {
                container.dataset.initialized = '';
                throw error;
            });
    }

    return {
        init: init
    };
});
