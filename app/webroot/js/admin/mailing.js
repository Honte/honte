$(document).ready(function () {
    var $button = $('[href=#select-all]');
    var $table = $button.closest('table');
    var $items = $table.find('input[type=checkbox]');
    var totalItems = $items.size();

    function areAnySelected() {
        return $items.filter(':checked').size() < totalItems;
    }

    function updateButton() {
        $button.text(areAnySelected() ? 'zaznacz' : 'odznacz');
    }

    function toggleSelection() {
        if (areAnySelected()) {
            $items.attr('checked', true);
        } else {
            $items.attr('checked', false);
        }

        updateButton();
    }

    $button.bind('click', toggleSelection);
    $items.live('click', updateButton);

    updateButton();
});