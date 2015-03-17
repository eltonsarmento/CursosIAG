$(document).ready(function(){ 
    
    //Opções
    
    var articleWidth = $(".banner-content ul li").outerWidth(),
        speed        = 4000,
        rotate       = setInterval(auto, speed);
    
    //Mostra os Botões
    
    $(".banner-content").hover(function(){
                
        $(".banner-content-nav").fadeIn(500);
        clearInterval(rotate);
        
    }, function(){
        
        $(".banner-content-nav").fadeOut(500);
        rotate = setInterval(auto, speed);
        
    });
    
    //Botão Next
    
    $(".nav-right").click(function(e){
        
        e.preventDefault();
        
        $(".banner-content ul").css({'width':'99999%'}).animate({left:-articleWidth}, 500, function(){
        
            $(".banner-content ul li").last().after($(".banner-content ul li").first());
            
            $(this).css({'left':'0', 'width':'auto'});
            
        });
        
    });
    
    //Botão Prev
    
    $(".banner-content-nav .nav-left").click(function(e){
       
        e.preventDefault();
        
        $(".banner-content ul li").first().before($(".banner-content ul li").last().css({'margin-left':-articleWidth}));
        $(".banner-content ul").css({'width':'99999%'}).animate({left:articleWidth}, 500, function(){
            
            $(".banner-content ul li").first().css({'margin-left':'0'});
            $(this).css({'left':'0', 'width':'auto'});
            
        });

    });
    
    //Rotação automática
    
    function auto(){
        
        $(".nav-right").click();
        
    }
    
});