
$(document).ready(function() {

/**
 * Confirm delete question
 */
    $('body').on('click', '.confirm-delete', function(e) {
        return confirm("Are you sure you want to delete this? It can't be undone.");
    });

    $('body').on('click', '.property-image', function(e) {
        $(this).remove();
    });
    
});
