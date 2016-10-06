define([
    'jquery',
    'underscore',
    'backbone',
    'twig_benagro',
    'app'
], function ($, _, Backbone, Twig) {

    /**
     * A PRODUCT selector.
     * 
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */
    App.view.TemplateSelector = App.View.extend({
        tagName: 'li',
        className: 'template',
        constructor: function (options) {
            App.View.prototype.constructor.call(this, options);
        },
        initialize: function (config) {
            var templateId = 'template-selector';
            this.container = config.container;

            this.template = Twig.twig({ref: templateId});
            if (this.template === null) {
                this.template = Twig.twig({
                    id: templateId,
                    data: '<div data-id="{{ id }}" class="project_container" data-row={{ datarow }} data-col={{ datacol }}>\
                        {% if image is string %}\
                            <div class="thumbnailnew"><div class="templatethumbnail">\
                            <div class="caption"> <h3 class="productprojectdashboard"> {{ product }}</h3><p class="imgpreviewdashboard"><img src="{{ image }}" style="max-width:239px; max-height:322px"></p></div></div>\
                        {% else %}\
                            <div class="thumbnailnew"><div class="templatethumbnail">\
                            <div class="caption"> <h3 class="productprojectdashboard"> {{ product }}</h3><p class="imgpreviewdashboard"></p></div></div></div>\
                        {% endif %}\
                        </li>'
                });
            }
            
            //  Exécuter la methode render à  chaque évènement sur l'objet
            _.bindAll(this, 'render');
            //  on exécute la fonction render à  chaque fois qu'on a un changement sur le model
            this.model.on('change', this.render, this);            
        },
        render: function () {
            this.$el.data('type', this.model.get('product'));
            this.$el.data('img-label', this.model.get('product'));
            this.$el.data('img-src', this.model.get('image'));
            this.$el.data('datarow', this.model.get('datarow'));
            this.$el.data('datacol', this.model.get('datacol'));
            
            var renderedContent = this.template.render(this.model.toJSON()).trim();
            this.$el.html(renderedContent);
            return this;
        },
        hide: function () {
            this.$el.addClass('hide');
        },
        events: {
            'click .project_container': 'onClick'
        },
        onClick: function (e) {      
            e.preventDefault();
            this.container.selectItem(this, this.$el);
        }
    });

    return App.view.TemplateSelector;
});
