	$(document).ready(function($){

        $('.bar-scroll').hide();
 
        $(window).scroll(function(){
            
            if ($(this).scrollTop() > 1) {
                
                $('.btn-top').slideDown(200);
                
            } else {
                
                $('.btn-top').slideUp(200);
                
            }
            
        }); 
 
        $('.btn-top').click(function(){

            $("html, body").animate({ scrollTop: 0 }, 400);
            return false;

        });        

        $('.tabs').tabs();
        $('.qtd-cursos').spinner();
        

    });
    $(function(){

        $(".checkout").hide();

        jQuery("#moip").click(function(){          
            
            if(jQuery(this).is(":checked")){

                $(".payment-selected").show();
                $(".payment-selected span").text("Moip Selecionado!");
                $(".checkout").show();
            
            }           
            
        });

        jQuery("#pagseguro").click(function(){          
            
            if(jQuery(this).is(":checked")){

                $(".checkout").hide();

                $(".payment-selected").show();
                $(".payment-selected span").text("Pagseguro Selecionado!");
            
            }           

        });

        var countChecked = function() {

            var n = $( "#check:checked" ).length;

            if( n == 0 ){

                $( ".info-confirm button#cadastro" ).hide();
                $( ".button-disable" ).show();

            }else if ( n == 1 ){

                $( ".button-disable" ).hide();
                $( ".info-confirm button#cadastro" ).show();

            }
            

        };

        countChecked();
         
        $( "input[type=checkbox]" ).on( "click", countChecked );
      

    });

    $(window).scroll(function(){
             
            $('.single-menu nav ul li a').smoothScroll();

            if ($(this).scrollTop() > 270){
                    
                $('.bar-scroll').show();
                $('.bar-scroll').css({position: 'fixed', top: '0px'});
                    
            }else{
                    
                $('.bar-scroll').hide();
                $('.bar-scroll').css({position: 'static'});
                    
            }
                
        });