import Select2 from 'select2';
import 'select2/dist/css/select2.min.css';

// Attach Select2 to jQuery
Select2($);

function initializeSelect2(placeholder = "Choose an option", multiple = false, tags = false, allowClear = true) {
    const selects = document.querySelectorAll("select.select2:not(.select2-hidden-accessible)");

    selects.forEach(select => {
        const $select = $(select);

        $select.select2({
            // Enable tags/create new options
            tags: tags,
            tokenSeparators: [','],

            // ALWAYS show search box
            minimumResultsForSearch: 0,

            // CRITICAL: Use element width
            width: '100%',

            // CRITICAL: Attach dropdown to the same parent as select
            dropdownParent: $select.parent(),

            // Multiple selection
            multiple: multiple,

            // Disable auto width
            dropdownAutoWidth: false,

            // Allow clear button
            allowClear: allowClear,

            // Placeholder
            placeholder: placeholder,

            // Theme
            theme: 'default'
        });

        // After initialization, force dropdown width to match container
        $select.on('select2:open', function () {
            const container = $select.data('select2').$container;
            const dropdown = $select.data('select2').$dropdown;

            if (container && dropdown) {
                const containerWidth = container.outerWidth();
                dropdown.css({
                    'width': containerWidth + 'px',
                    'max-width': containerWidth + 'px',
                    'min-width': containerWidth + 'px'
                });
            }
        });

        // Livewire integration - trigger change event
        $select.on('change', function (e) {
            let event = new Event('change', { bubbles: true });
            select.dispatchEvent(event);
        });
    });
}

window.initializeSelect2 = initializeSelect2;