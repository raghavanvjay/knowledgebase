/* JS code for Manage_tags page */
$(document).ready(function(){

    $('.tags_box').on('click', '.tag',function(){

        //the csrf-token variable for form post in Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        var tag_id = $(this).data('tid');

        //get the tag and add it to the attached tags box
        if(parseInt(tag_id) > 0)
        {
            url = baseUrl + "/manage/tags/get_tag";
            $.ajax({
                url: url,
                type: "POST",
                data: { id : tag_id },
                success: function(result){
                    //get attached tag html
                    var attached_tag = get_attached_tag_html(result.message);
                    //add it to the box
                    $('.attached-tags-box').append(attached_tag);
                    $('.tags_box #tag_'+tag_id).remove();
                    initialize_tags_attached();
                },
                error: function(x){
                    setTimeout(function(){ location.reload(); }, 4000);
                }
            });

        }
    });

    $('.attached-tags-box').on('click','.remove-tag',function(){
        //the csrf-token variable for form post in Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        var tag_id = $(this).data('tid');

        if(parseInt(tag_id) > 0)
        {
            url = baseUrl + "/manage/tags/get_tag";
            $.ajax({
                url: url,
                type: "POST",
                data: { id : tag_id },
                success: function(result){
                    //get attached tag html
                    var tag = get_list_tag_html(result.message);
                    //add it to the box
                    $('.tags_box').append(tag);
                    $('.attached-tags-box #tag_'+tag_id).remove();
                    initialize_tags_attached();
                },
                error: function(x){
                    setTimeout(function(){ location.reload(); }, 4000);
                }
            });

        }
    });

    initialize_tags_attached();

    //add to attached tags
    //remove from attached tags

});

//initialize/update attached tags
function initialize_tags_attached()
{
    var tags_a = '';
    $('.attached-tags-box .attached-tag-wrap').each(function(){
        var tag = $(this).children('.remove-tag');
        tags_a = tags_a == '' ? tag.data('tid') : tags_a + ',' + tag.data('tid');
    });
    $('#tags_attached').val(tags_a);
}

