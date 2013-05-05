!function($){

    "use strict"

    var simpleCollectionForm = function (element, options) {
        this.$element = $(element);
        this.$addButton = this.$element.find('[data-collection="add"]');
        this.$container = this.$element.find('[data-collection="container"]');

        this.listen();
    }

    simpleCollectionForm.prototype = {
        constructor : simpleCollectionForm,

        listen: function ()
        {
            this.$addButton.on('click', $.proxy(this.addChild, this));
        },

        addChild: function (){
            var prototype = this.$container.data('prototype');
            prototype = prototype.replace(
                /__name__/g,
                this.$container.children().length
            );

            this.$container.prepend(prototype);
        }
    }


    /* SIMPLECOLLECTIONFORM PLUGIN DEFINITION
     * ========================== */

     $.fn.simpleCollectionForm = function ( option ) {
        return this.each(function () {
            var $this = $(this);
            var data = $this.data('simpleCollectionForm');
            var options = typeof option == 'object' && option;

            if (!data) {
                $this.data(
                    'simpleCollectionForm',
                    (data = new simpleCollectionForm(this, options))
                )
            }

            if (typeof option == 'string') {
                data[option]();
            }
        })
    }

    $.fn.dropdown.simpleCollectionForm = simpleCollectionForm;


    /* APPLY TO STANDARD SIMPLECOLLECTIONFORM ELEMENTS
     * =================================== */

    $(function () {
        $('[data-form-type="collection"]').simpleCollectionForm();
    });
}(window.jQuery);
