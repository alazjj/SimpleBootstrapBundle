$(function () {
    /**
     * Symfony environment (do not forget to put data-env attribute on the body element)
     */
    var env = $('body').data('env');


    /**
     * Open a popup and ask to the server the content.
     *
     * Put two others attributes on the clickable element:
     * - data-url : url which return content of the popup up
     * - href or data-target : modal element id, you must used
     *   it as an anchor or a button (bootstrap mechanism )
     *
     * If you want enable ajax submit, put a attribute
     * data-submit="ajax" on your form returned in the response.
     */
    $.fn.simpleModal = function(){
        var $this = $(this);
        // Url which return content of the popup up
        var url = $(this).data('url');

        /**
         * Open the modal and put the body var into modal body
         * (element with .modal-body css class)
         */
        function openModalWithBody ($modal, body) {
            var $modalContent =  $modal.find('div.modal-body');
            if ($modalContent.lenght == 1) {
                $modalContent.html(body);
            } else {
                $modal.html(body)
            }
            $modal.modal('show');
        }

        /**
         * Open the "error modal". It is the current modal with
         * error retuened (by the server) as body
         */
        function openModalWithError ($modal, jqXHR) {
            if(env != 'dev') {
                openModalWithBody($modal, jqXHR.responseText);
            } else {
                // TODO : get the content of the symfony response.
                alert('Impossible to display the popup, Error code ' + jqXHR.status + ' Error message : ' + jqXHR.statusText)
            }
        }

        this.each(function () {
            var $modal;

            // Get the popup container
            if ($this.is('a')) {
                $modal = $($this.attr('href'));
            } else {
                $modal = $($(this).data('target'));
            }

            if ($modal.length == 0) {
                 alert("Oops! An Error Occurred, the popup container was not found...");
                return false;
            }
            $this.on("click", function() {
                // Get the content of the popup
                $.get(url, function(response) {
                    if(response == "" || response == undefined) {
                        response = "Oops! An Error Occurred, The response from the server is empty...";
                        openModalWithBody($modal, response);
                        return false;
                    } else {
                        // Display the modal with its content
                        $modal.html(response);
                        $modal.modal('show');

                        // Form element in the response
                        var $form = $('form[data-submit="ajax"]');
                        // Form Input submit
                        var $submitButton = $('input[type=submit]');

                        if ($form.length == 1) {
                            $form.on("submit", function(even) {
                                even.preventDefault();

                                // Disable the submit button
                                $submitButton.attr('disabled', false);

                                // Ajax Submition
                                $form.ajaxSubmit({
                                    statusCode: {
                                        // You have to use 204 (http status code) if you want send
                                        // a request and close the modal.
                                        204: function(){
                                            $modal.modal('hide');
                                        },
                                        // If you want to reload the page use 205
                                        205: function(){
                                            location.reload();
                                        }
                                    },
                                    // The request is successful (code), you display the modal.
                                    success: function(responseText, textStatus, jqXHR) {
                                        if(jqXHR.status == 200) {
                                            $modal.html(responseText);
                                        }
                                    },
                                    // The request failed
                                    error: function(jqXHR) {
                                        openModalWithError ($modal, jqXHR);
                                    }
                                });
                            });
                        }
                    }
                }).fail(function(jqXHR) {
                    openModalWithError ($modal, jqXHR);
                });
            });

        });

        return $this;
    };

//    $.fn.confirmModal = function() {
//        this.each(function () {
//            var $this = $(this);
//            // Confirm popup content
//            var body = $(this).data('body');
//
//
//            // Get the popup container
//            if ($this.is('a')) {
//                $modal = $($this.attr('href'));
//            } else {
//                $modal = $($(this).data('target'));
//            }
//
//            if ($modal.length == 0) {
//                 alert("Oops! An Error Occurred, the popup container was not found...");
//                return false;
//            }
//
//            openModalWithBody($modal, body);
//        }
//    }
});