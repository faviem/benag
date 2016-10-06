/*
 * This file is part of the Benagro package.
 *
 * (c) Jacques Adjahoungbo <tocicason@hotmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

(function (factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
        // Register as an anonymous AMD module:
        define([
            'appbuilder/app'
        ], factory);
    } else {
        // Browser globals:
        factory(window.ApplicationBuilder);
    }
}(function(ApplicationBuilder) {
    'use strict';

    /**
     * Model Offre.
     * 
     * @author Jacques Adjahoungbo <tocicason@hotmail.fr>
     */
    ApplicationBuilder.model.Offre = ApplicationBuilder.Model.extend({
    
        defaults: {
            id: null,
            lieu: null,
            image: null,
            product: null,
            prix: null
        }
    });
    return ApplicationBuilder.model.TemplateSelector;
}));