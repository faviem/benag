/*
 * This file is part of the Benagro package.
 *
 * (c) Jacques Adjahoungbo <jtocson@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

/**
 * show product page
 *
 * @version 1.0 [7 Octobre 2016]
 * @author Jacques Adjahoungbo <jtocson@gmail.com>
 */

define(
    [
    'jquery',
    'bootstrap'
],
    function($) {
        'use strict';
        $(function(){
            
            /**
             * @module       Tabs
             * @description  Bootstrap tabs
             */

            $('#myTabs a').click(function (e) {
                e.preventDefault()
                $(this).tab('show')
            })

            $('#myTabs2 a').click(function (e) {
                e.preventDefault()
                $(this).tab('show')
            })

            /* Order*/
            $('#order').click( function(e) {
                e.preventDefault;
                //$('#order-dialog').modal();
            });

            $('body').on('submit', '.ajaxForm', function (e) {
                e.preventDefault();
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize()
                })
                .done(function (data) {            
                    if (data.sucess) {  
                        window.location.href = data.targetUrl;
                    }        
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    switch (jqXHR.status) {
                        case 401:
                            window.location.replace(Routing.generate('fos_user_security_login'));
                            break;
                        case 403: // (Invalid CSRF token for example)
                        // Reload page from server
                        window.location.reload(true);                        
                    } 
                });
            });            
        });
    }
);



