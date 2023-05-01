@extends('../layouts/layout')
@section('content')
    @include('../products/indexcontent')
    <script>
        $(document).ready(function() {
            function fetch_data(page, query) {
                $.ajax({
                    url: "/fetchdata?page=" + page + '&query=' + query,
                    //url:"/fetchdata"+'?query='+query,
                    success: function(products) {
                        $('#ajax').html('');
                        $('#ajax').html(products);
                    }
                })
            };
            $(document).on('keyup', '#searchField', function() {
                let keyupTimer;
                clearTimeout(keyupTimer);
                keyupTimer = setTimeout(function() {
                    var query = $('#searchField').val();
                    var page = $('#hidden_page').val();
                    fetch_data(page, query);
                }, 800);

            });
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                $('#hidden_page').val(page);

                var query = $('#searchField').val();

                $('li').removeClass('active');
                $(this).parent().addClass('active');
                fetch_data(page, query);
            });
            $(document).on('click', '.shoppingCart', function() {
                let id = $(this).attr('id');
                $('#' + id + 'amount').show();
                $('#' + id + 'unit').show();
                $('#' + id + 'comment').show();
                $('#' + id + 'submit').show();
                $('#' + id + 'back').show();
                $(this).hide();
                $('#' + id + 'back').click(function() {
                    $('#' + id + 'amount').hide();
                    $('#' + id + 'unit').hide();
                    $('#' + id + 'submit').hide();
                    $('#' + id + 'comment').hide();
                    $(this).hide();
                    $('#' + id).show();
                })
            });
        });
    </script>
@endsection
