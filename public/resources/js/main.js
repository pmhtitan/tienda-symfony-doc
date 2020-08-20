 $( document ).ready(function() {

            $( ".btnAjax" ).click(function() {

               /*  var urlsite = "{{ path('ajax_request') }}"; */
                var urlsite =$('#path-ajax').attr("data-path");
                var valorQuantity  = $('#quantity_input').val();

                        $.ajax({
                            type: 'post',
                            url: urlsite,
                            data: { quantity: valorQuantity }
                        })
                            .done(function( msg ) {
                          
                        });
            });
        });