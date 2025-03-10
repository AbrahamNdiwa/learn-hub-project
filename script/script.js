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
                    $('#main').hide();
                }
            });
        } else {
            $('#searchResults').html('');
            $('#main').show();
        }
    });

    // Get notes by category
    $('.category-filter').on('click', function () {
        let category = $(this).text().trim();
        $.ajax({
            url: 'search.php',
            method: 'GET',
            data: { category: category },
            success: function (response) {
                $('#searchResults').html(response);
                $('#main').hide();
            }
        });
    });
});
