/*
 * This file is part of the WebApplicationBuilder package.
 *
 * (c) Jacques Adjahoungbo <jtocson@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

require(['jquery.ui'], function() {  
    'use strict';

    $(function() {

        /**
         * Register.
         * 
         * @version 1.0 [17 Mai 2016]
         * @author Jacques ADJAHOUNGBO
         */

            function Register() {

                this.init();
            }

            Register.prototype = {

                init: function() {
                    $('#ben_user_registration_profil').change( function() {
                        $.ajax({
                            type: "GET",
                            data: "data=" + $(this).val(),
                            url: Routing.generate('ben_user_render_form'),
                            success: function(response){
                                if (response !== ''){
                                   $('#rendered').html(response);
                                }
                                else
                                {
                                    $('#rendered').html('<em>No item result</em>');
                                }
                            }
                        });
                      });
                }
            }

            new Register();

    });

});
