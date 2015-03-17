$(document).ready(function(){

    $("#filter").keyup(function(){

    var filter = $(this).val(), count = 0;
     
    $(".search-live li").each(function(){
         
        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
            $(this).fadeOut(200);
         
        } else {

            $(this).fadeIn(200);
            count++;

        }

    });

    var numberItems = count;

    $("#filter-count").text(count);

    });

});