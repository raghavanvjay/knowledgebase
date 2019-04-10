/* JS code for Manage_tags page */
$(document).ready(function(){

    //Add a new tag
    $('#add_tag').click(function(){
        //the csrf-token variable for form post in Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        //Get the tag name
        var tag_name = $('#new_tag').val().trim();
        if(tag_name.length > 0)
        {
            url = baseUrl + "/manage/tags/create";
            $.ajax({
                url: url,
                type: "POST",
                data: { name : tag_name },
                success: function(result){
                    var tag_name = result.message.name;
                    var tag_id = result.message.id;
                    //on success, display the new box as the first item in the listing
                    var new_box = '<div class="col-md-4 edit-tag-box" id="tag_box_' + tag_id + '"><div class="input-group"><span class="input-group-btn"><button title="Delete" class="btn btn-secondary del_tag" type="button" data-id="' + tag_id + '" name="del_tag"><span class="glyphicon glyphicon-remove"></span></button></span><input type="text" class="form-control" placeholder="Tag Name" name="tag_' + tag_id + '" id="tag_' + tag_id + '" value="' + tag_name + '"><span class="input-group-btn"><button title = "Save" class="btn btn-secondary save_tag" type="button" data-id="' + tag_id + '" name="save_tag"><span class="glyphicon glyphicon-floppy-disk"></span></button></span></div></div>';
                    $('#tag-boxes-wrap').prepend(new_box);
                    //display the success message
                    var notice = get_notice_box('New tag added.', 'success');
                    $('.header').after(notice);
                    autoclose_alert('.notice-box .alert',5000);
                },
                error: function(x){
                    //Display the error message; validation error messages come here
                    var msg = x.responseJSON.name[0] != undefined ? x.responseJSON.name[0] : 'Failed adding new tag. Try again.';
                    var notice = get_notice_box(msg, 'danger');
                    $('.header').after(notice);
                    autoclose_alert('.notice-box .alert',5000);
                }
            });
        }
        //Tag name empty error
        else
        {
            var notice = get_notice_box('Tag cannot be empty.', 'danger');
            $('.header').after(notice);
            autoclose_alert('.notice-box .alert',5000);
        }

    });

    //Update an existing tag
    $('.save_tag').click(function(){
        //the csrf-token variable for form post in Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        //Get the tag name
        var tag_id = $(this).data('id');
        var tag_name = $('#tag_'+tag_id).val().trim();
        if(tag_name.length > 0)
        {
            url = baseUrl + "/manage/tags/update";
            $.ajax({
                url: url,
                type: "POST",
                data: { name : tag_name, id : tag_id },
                success: function(result){
                    //set the success message
                    var notice = get_notice_box('Tag updated.', 'success');
                    $('.header').after(notice);
                    autoclose_alert('.notice-box .alert',5000);
                },
                error: function(x){
                    //set the error message; validation error messages come here
                    var msg = x.responseJSON.name[0] != undefined ? x.responseJSON.name[0] : 'Failed updating tag. Try again.';
                    var notice = get_notice_box(msg, 'danger');
                    $('.header').after(notice);
                    autoclose_alert('.notice-box .alert',5000);

                }
            });
        }
        //Tag name empty error
        else
        {
            url = baseUrl + "/manage/tags/get_tag";
            $.ajax({
                url: url,
                type: "POST",
                data: { id : tag_id },
                success: function(result){
                    $('#tag_'+tag_id).val(result.message.name);
                },
                error: function(x){
                    setTimeout(function(){ location.reload(); }, 4000);
                }
            });

            var notice = get_notice_box('Tag cannot be empty.', 'danger');
            $('.header').after(notice);
            autoclose_alert('.notice-box .alert',5000);

        }
    });

    //Deleting an existing tag
    $('.del_tag').click(function(){
        if(delete_alert('Tag'))
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            //Get the tag name
            var tag_id = $(this).data('id');
            if(parseInt(tag_id) > 0)
            {
                url = baseUrl + "/manage/tags/delete";
                $.ajax({
                    url: url,
                    type: "POST",
                    data: { id : tag_id },
                    success: function(result){
                        //set the success message
                        var notice = get_notice_box('Tag deleted.', 'success');
                        $('#tag_box_' + tag_id).remove();
                        $('.header').after(notice);
                        autoclose_alert('.notice-box .alert',5000);
                    },
                    error: function(x){
                        //set the error message; validation error messages come here
                        var msg = x.responseJSON.name[0] != undefined ? x.responseJSON.name[0] : 'Failed adding new tag. Try again.';
                        var notice = get_notice_box(msg, 'danger');
                        $('.header').after(notice);
                        autoclose_alert('.notice-box .alert',5000);
                    }
                });
            }
            else
            {
                var notice = get_notice_box('Tag not found.', 'danger');
                $('.header').after(notice);
                autoclose_alert('.notice-box .alert',5000);
            }
        }
        else
        {
            var notice = get_notice_box('Tag deletion aborted.', 'danger');
            $('.header').after(notice);
            autoclose_alert('.notice-box .alert',5000);
        }
    });
});

