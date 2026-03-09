define([], function() {
    function getOrCreateContainer() {
        var container = document.getElementById('local-courseprogress');
        if (container) {
            return container;
        }

        container = document.createElement('div');
        container.id = 'local-courseprogress';
        container.className = 'local-courseprogress';
        container.setAttribute('aria-live', 'polite');
        document.body.insertBefore(container, document.body.firstChild);
        return container;
    }

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

    function init(config) {
        var container = getOrCreateContainer();
        if (container.dataset.initialized === '1') {
            return;
        }

        container.dataset.initialized = '1';
        moveToCourseContent(container);

        var label = config && config.label ? config.label : 'Progress bar';
        var value = config && Number.isFinite(Number(config.value)) ? Number(config.value) : 0;
        var maxlabel = config && config.maxlabel ? config.maxlabel : '100%';
        var showpercentage = !config || Number(config.showpercentage) === 1;
        value = Math.max(0, Math.min(100, value));

        container.innerHTML =
            '<div class="local-courseprogress__title">' + label + '</div>' +
            '<div class="local-courseprogress__track" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="' + value + '">' +
                '<span class="local-courseprogress__fill" style="width: ' + value + '%;"></span>' +
            '</div>' +
            '<div class="local-courseprogress__meta">' +
                '<div class="local-courseprogress__value">' + (showpercentage ? value + '%' : '') + '</div>' +
                '<div class="local-courseprogress__max">' + maxlabel + '</div>' +
            '</div>';
    }

    return {
        init: init
    };
});
