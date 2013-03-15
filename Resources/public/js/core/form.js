$(function () {
    /**
     * Manage form editable field by field
     */
    $.fn.formEditField = function(options) {
        // Form element
        var $form = $(this).closest('form');

        // Settings
        var settings = $.extend( {
            'allFields' : false
        }, options);


        this.each(function () {
            var $this = $(this);
            // Imput Markup
            var input = $this.data('form-input');
            // Input object
            var $input = $(input);
            // Edit Input
            var $inputAction = $this.find('[data-form-edit="row"]');

            // Update the input form markup
            if(settings.allFields == false) {
                $inputAction.on("click", function() {
                    $this.html($input);
                });
            } else {
                $this.html($input);
            }


            // Submit the value to the serveur if it change.
            $input.on("change", function() {
                $input.attr('disabled', true);

                // Send field data
                $.ajax({
                    url: $form.attr('action'),
                    type: $form.attr('method'),
                    data: $input.serialize()
                })
                .done(function(data) {
                    if(data != undefined) {
                        if(data.status == 'error') {
                            if (data.message == undefined) {
                                data.message = 'Oops! An Error Occurred, You can update this fields';
                            }
                            alert(data.message);
                        }

                        $input.attr('disabled', false)
                    } else {
                        alert('Oops! An Error Occurred, You can update this fields');
                    }
                })
                .fail(function(data) {
                    alert('Oops! An Error Occurred, You can update this fields');
                });
            });
        });

        return $(this);
    };
});