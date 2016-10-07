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
 * New product page
 *
 * @version 1.0 [17 Mai 2016]
 * @author Jacques Adjahoungbo <jtocson@gmail.com>
 */

define(
    [
    'jquery'
],
    function($) {
        'use strict';

        $(function(){

            $("#vente_province").change(function(){
                var data = {
                    province_id: $(this).val()
                };

                $.ajax({
                    type: 'post',
                    url: Routing.generate('vente_select_cities'),
                    data: data,
                    success: function(data) {
                        var $city_selector = $('#vente_city');
                        $city_selector.html('<option>Ville</option>');

                        for (var i=0, total = data.length; i < total; i++) {
                            $city_selector.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                        }
                    }
                });
            });
        });
    }
);

