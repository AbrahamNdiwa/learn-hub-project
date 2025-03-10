$(document).ready(function () {
    $('#search').on('keyup', function () {
        let query = $(this).val().trim();
        if (query.length > 2) {
            $.ajax({
                url: 'search.php',
                method: 'GET',
                data: { query: query },
                success: function (response) {
                    $('#searchResults').html(response);
                    $('#notesList').hide();
                }
            });
        } else {
            $('#searchResults').html('');
            $('#notesList').show();
        }
    });
});
