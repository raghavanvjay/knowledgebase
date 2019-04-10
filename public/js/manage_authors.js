/* JS code for Manage_tags page */
$(document).ready(function(){

    //Update an existing tag
    $('.save_author').click(function(){
        //the csrf-token variable for form post in Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        //Get the author name
        var author_id = $(this).data('id');
        var author_name = $('#author_'+author_id).val().trim();
        if(author_name.length > 0)
        {
            url = baseUrl + "/manage/authors/update";
            $.ajax({
                url: url,
                type: "POST",
                data: { name : author_name, id : author_id },
                success: function(result){
                    //set the success message
                    var notice = get_notice_box('Author updated.', 'success');
                    $('.header').after(notice);
                    autoclose_alert('.notice-box .alert',5000);
                },
                error: function(x){
                    //set the error message; validation error messages come here
                    var msg = x.responseJSON.name[0] != undefined ? x.responseJSON.name[0] : 'Failed updating author. Try again.';
                    var notice = get_notice_box(msg, 'danger');
                    $('.header').after(notice);
                    autoclose_alert('.notice-box .alert',5000);

                }
            });
        }
        //Author name empty error
        else
        {
            url = baseUrl + "/manage/authors/get_name";
            $.ajax({
                url: url,
                type: "POST",
                data: { id : author_id },
                success: function(result){
                    $('#author_'+author_id).val(result.message.name);
                },
                error: function(x){
                    setTimeout(function(){ location.reload(); }, 4000);
                }
            });

            var notice = get_notice_box('Author name cannot be empty.', 'danger');
            $('.header').after(notice);
            autoclose_alert('.notice-box .alert',5000);

        }
    });

    //Toggle Author Status
    $('.toggle_author_status').click(function(){
        //the csrf-token variable for form post in Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        //Get the author name
        var author_id = $(this).data('id');
        if(parseInt(author_id) > 0)
        {
            url = baseUrl + "/manage/authors/toggle";
            $.ajax({
                url: url,
                type: "POST",
                data: { id : author_id },
                success: function(result){
                    //set the success message
                    if(result.message.status == 1 )
                    {
                        var status_text = 'Active';
                        var add_class = 'glyphicon-thumbs-down';
                        var remove_class = 'glyphicon-thumbs-up';
                    }
                    else
                    {
                        var status_text = 'Inactive';
                        var add_class = 'glyphicon-thumbs-up';
                        var remove_class = 'glyphicon-thumbs-down';
                    }
                    $('#author_status_' + author_id).val(status_text);
                    $('#author_toggle_' + author_id + ' .glyphicon').addClass(add_class).removeClass(remove_class);
                    var notice = get_notice_box('Author status updated.', 'success');
                    $('.header').after(notice);
                    autoclose_alert('.notice-box .alert',5000);
                },
                error: function(x){
                    //set the error message; validation error messages come here
                    var msg = x.responseJSON.name[0] != undefined ? x.responseJSON.name[0] : 'Failed updating author status. Try again.';
                    var notice = get_notice_box(msg, 'danger');
                    $('.header').after(notice);
                    autoclose_alert('.notice-box .alert',5000);

                }
            });
        }
        else
        {
            var notice = get_notice_box('Author not found.', 'danger');
            $('.header').after(notice);
            autoclose_alert('.notice-box .alert',5000);
        }
    });

});

