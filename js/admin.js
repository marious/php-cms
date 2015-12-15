$(function() {
    $('.delete').on('click', function(e) {
        var confirmed = confirm('Are you want to delete this item');
        if (!confirmed) {
            e.preventDefault();
        }
    });
});
