$(document).ready(function(){
    $(".up,.down,.top").click(function(){
        var row = $(this).parents("tr:first");
		if ($(this).is(".top") ) {
            $(this).parents('tbody').prepend(row);
        }
        else if ($(this).is(".up") ) {
            row.insertBefore(row.prev());
        } else {
            row.insertAfter(row.next());
        }
    });
	
	$(".delrow ").click(function() {
                   $(this).parents("tr").remove();				 
        });
});