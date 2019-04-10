//Show a confirmation box before deleting an item
function delete_alert(item)
{
    return confirm('Are you sure you want to delete this ' + item + '?');
}

// Get noticebox html content, to display success/fail notices
function get_notice_box(message, alert_type)
{
    return '<div class="container notice-box"><div class="row"><div class="col-xs-12"><div class="alert alert-' + alert_type + '"><button type="button" class="close" data-dismiss="alert">x</button><strong>' + (alert_type == 'success' ? 'Success' : 'Error') + '!</strong> ' + message + '</div></div></div></div>';
}

//autoclose a twitter bootstrap alert box after a specific duration
function autoclose_alert(selector,duration){
    $(selector).fadeTo(duration, 0.5, function(){
        $(selector).alert('close');
    });
}

function get_attached_tag_html(tag)
{
    return '<div class="attached-tag-wrap" id="tag_' + tag.id + '"><div class="attached-tag">' + tag.name + '</div><button type="button" class="remove-tag" data-tid="' + tag.id + '">&times;</button></div>';
}

function get_list_tag_html(tag, entry_id)
{
    var tag_classes = ['btn-primary', 'btn-default', 'btn-warning', 'btn-info'];
    var ran = Math.floor((Math.random() * tag_classes.length ));
    var tag_class = tag_classes[ran];
    return '<div class="tag btn ' + tag_class + '" id="tag_' + tag.id + '" data-tid="' + tag.id + '">' + tag.name + '</div>';
}