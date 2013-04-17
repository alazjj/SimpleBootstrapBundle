Modals
======

SimpleBootstrap provides jQuery plugins which extend Twitter Bootstrap modals. This plugins offers the following modal extensions :

* **Simple modal** allows you to open a modal and get its content from a remote server.
* **Confirmation modal** is used to validate actions. For example, you can ask the user if he really wants to delete something.
* **Alert modal** allows you to open a modal to inform the user that something happened.

Options of the modals are defined on the clickable element as HTML5 data attributes.

You can discover several uses of the modal plugin in the [DemoSimpleBootstrapBundle](https://github.com/alazjj/DemoSimpleBootstrapBundle).

Basic modal markup
------------------

Here is the basic modal markup :

    <div class="modal fade hide" id="modalContainer">
        <div class="modal-header">
            Header
        </div>
        <div class="modal-body">
            Body
        </div>
        <div class="modal-footer">
            Footer
        </div>
    </div>

Confirmation modal
------------------

A confirmation modal asks the user if he wants to validate the current action. It works only with the click event.

You can use the following options  on the clickable element which opens the popin :

* **data-url** : if the user confirms the action, he will be redirected on this URL
* **data-message** : the message displayed on the modal
* **data-target** : the id of the modal container (use an anchor like #modalContainer).

If you want to use a link to open your modal, you can omit the **data-target** option. In this case, the **href** attribute will be used instead.

    <button class="confirmationPopin"
            data-target="#MyConfirmationModalContainer"
            data-message="Do you want to delete it ?"
            data-url="app.php/delete/10">
       Delete
    </button>

    <div class="modal fade hide" id="MyConfirmationModalContainer">
        <div class="modal-header">
            Header
        </div>
        <div class="modal-body">
            Body
        </div>
        <div class="modal-footer">
            <a data-action="confirm">Yes</a>
            <a>No</a>
        </div>
    </div>

    <script>
        $(function () {
            $('.confirmationPopin').confirmModal();
        });
    </script>

You have several ways to redirect the user after validation :

* You can use a link with a **data-action="confirm"** attribute. The plugin will update the href attribute with the value specified in the data-url attribute.
* You can use a form with a **data-action="confirm"** attribute.  The plugin will update the action attribute  with the value specified in the data-url attribute.
* Instead of using the **data-url** attribute you can put directly a link or a form in the modal template.


Alert modal
-----------

Opens an alert modal to inform the user that something happened.

You can use the following options on the clickable element which opens the popin :

* **data-message** : the message displayed on the modal
* **data-target** : the id of the modal container (use an anchor like #modalContainer).

If you want to use a link to open your modal, you can omit the **data-target** option. In this case, the **href** attribute will be used instead.

    <button class="alertPopin"
            data-target="#MyAlertModalContainer"
            data-message="Hello aRn0D !!">
       Delete
    </button>

    <div class="modal fade hide" id="MyAlertModalContainer">
        <div class="modal-header">
            Header
        </div>

        <div class="modal-body"></div>

        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">
                OK
            </a>
        </div>
    </div>

    <script>
        $(function () {
            $('.alertPopin').alertModal();
        });
    </script>

Simple Modal
------------

Simple modals are used to open a popin and request its content from the server. Typically, this kind of modal can be used to render a form.

You can use the following options on the clickable element which opens the popin :

* **data-url** : url which returns the content of the popin
* **data-target** : the id of the modal container (use an anchor like #modalContainer).

If you want to use a link to open your modal, you can omit the **data-target** option. In this case, the **href** attribute will be used instead.

    <button class="simplePopin"
            data-target="#MySimpleModalContainer"
            data-url="app.php/hello">
       Delete
    </button>

    <div class="modal fade hide" id="MySimpleModalContainer"></div>

    <script>
        $(function () {
            $('.simplePopin').simpleModal();
        });
    </script>

If you have included a form in your modal, you can add a **data-submit="ajax"** attribute on the form. Thus, the plugin  will send your form with ajax. The following HTTP codes allows you to render the popin in different ways :

* Use **200** to update popin container.
* Use **204** to close the popin.
* Use **205** to entirely reload the page.

    <?php
    // TestController.php
    public function testAction()
    {
        if (/* you want to update the popin container */) {
            return new \Symfony\Component\HttpFoundation\Response('', 200);
        }
        elseif (/* you want to close the popin */) {
            return new \Symfony\Component\HttpFoundation\Response('', 204);
        }
        elseif (/* you want to reload the page */) {
            return new \Symfony\Component\HttpFoundation\Response('', 205);
        }
    }

Lazy mode
---------

Instead of creating your modal containers, SimpleBootstrap provides you a way to build them automatically. This is what we call the lazy mode ! To do so, import the **Modal:default.html.twig** template and call the following macros :

    {% import "AlazjjSimpleBootstrapBundle:Modal:default.html.twig" as modal %}
    {{ modal.confirmModal() }}         # confirmation modal with default ID
    {{ modal.alertModal('myModal') }}  # alert modal with myModal as ID
    {{ modal.containerModal() }}       # simple modal with default ID

Each macro renders a specific modal container. Macros accept one argument which is the ID of the modal container. By default, the following IDs are defined :

* **confirmModalContainer** for the confirmation modal
* **alertModalContainer** for the alert modal
* **basicModalContainer** for the simple modal

By default, the jQuery plugins will look for these modal IDs. Thus you can omit to put the **data-target** attribute on the clickable elements which open the popins.