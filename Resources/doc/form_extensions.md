Form edition with simpleForm
============================
Two new options are available on the symfony form type :
* **is_active** (default true) :
    * **false** : you only print the value of the field
    * **true** : you print the input element (form normal working)
* **is_editable** (default false) : this option print an edit button to edit the field value. The new value will be sent on the change event.

The following fields are correctly supported : choice, text and date field

```php
<?php
namespace Acme\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // You print the value of the field and a button to edit it
        $builder->add('email', 'text', array(
                'is_editable' => true,
                'is_active' => false
            ));
        // You only print the value of the field
        $builder->add('message','text', array(
                'is_editable' => false,
                'is_active' => false
            ));
    }
}
```
### View
You can submit the value of the field by ajax on the change event, you have to put data-form-submission="change" on the form element.

**Form field configuration :**
* is_editable : true,
* is_active : false

```html
<form class="form-horizontal" action="ptah/to/edit" method="POST" data-form-submission="change" id="#form">
    <!-- The button active all fields (print the html render of the input) -->
    <button data-form-edit="form">Edit all fields<button/>

    <!-- This div is used to display error or success message -->
    <div class="alert fade hide" data-form="message"></div>

    {{ form_rest(form) }}
</form>

<script>
    $('#form').simpleForm();
</script>
```

You can enable ajax submission on a form, you have to put data-form-submission="ajax" on the form element.

**Form field configuration :**
* is_editable : false,
* is_active : true or false if you use "Edit all fields" button

```html
<form class="form-horizontal" action="ptah/to/edit" method="POST" data-form-submission="ajax" id="#form">
    <!-- The button active all fields (print the html render of the input) -->
    <button data-form-edit="form">Edit all fields<button/>

    <!-- This div is used to display error or success message -->
    <div class="alert fade hide" data-form="message"></div>

    {{ form_rest(form) }}

    <input type="submit" value="submit"/>
</form>

<script>
    $('#form').simpleForm();
</script>
```

### Controller

You have to deal with the http code to tell what happen to simpleForm. It support the following codes :
* 200 : The form was submited and correctly processed. The server can return a success message, it will be print to the user.
* 202 : The data of the form was not valid, the server return the form html markup (rendered with errors). It will be print to the user again (the user can edit it again).

```php
<?php
public function contactAction()
{
    if (!$form->isValid() && $this->getRequest()->isXmlHttpRequest()) {
        // SimpleForm will print the form
        return new \Symfony\Component\HttpFoundation\JsonResponse('<form>...</form>', 202);
    }
    // SimpleForm will print a beautifull bootstrap alert with the message : 'The datas of the form was saved'
    return new \Symfony\Component\HttpFoundation\JsonResponse('The datas of the form was saved');
}
```



Form Type extensions
====================

Form Type
---------

**Parent type :** form

**Inherited options :** form type options

**Option :**
* **is_active** (type: boolean, default : true) : The html markup of the input is rendered if true or the value is printed instead.
* **is_editable** (type: boolean, default : false) : Print the edition button if the input field is not rendered (is_active = false).
* **controls_attr** (type: array, default : empty array) : Add custom html attribute on the container of the form widget.

Date Type
---------

**Parent type :** date

**Inherited options :** date type options 

**Option :**
* **datepicker** (type: boolean, default : false) : Active datepicker if the widget option is set to single_text.
* **auto_format** (type: boolean, default : false) : Calculate automatically the format option with the locale.
* **week_start** (type: int, default : 1) : Day of the week start : 0 for Sunday - 6 for Saturday.
* **view_mode** (type: int|string, default : 0) : Set the start view mode. Accepts: 'days', 'months', 'years', 0 for days, 1 for months and 2 for years.
* **min_view_mode** (type: int|string, default : 0) : Set a limit for view mode. Accepts: 'days', 'months', 'years', 0 for days, 1 for months and 2 for years.

You have to apply the javascript plugin, you can use .datepicker as default css selector beacause the date form type is render with its css classes.
```js
    $('.datepicker').datepicker();
```
Caution : If you use simpleForm plugin it will automatically apply the datepicker and colorpicker plugin. If you apply them, those both plugins will does not work...


ColorPicker Type
----------------

**Parent type :** text

**Inherited options :** text type options

**Option :**
* **format** (type: string, default : 'hex') : Set the color format. Accepts: 'hex', 'rgb' and 'rgba'

You have to apply the javascript plugin, you can use .colorpicker as default css selector beacause the date form type is render with its css classes
```js
$('.colorpicker').colorpicker();
```
Caution : If you use simpleForm plugin it will automatically apply the datepicker and colorpicker plugin. If you apply them, those both plugins will does not work...


Typeahead Type
----------------

**Parent type :** text

**Inherited options :** text type options

**Option :**
* **source** (type: array) : Data source
* **items** (type: integer, default : 8) : The max number of items to display in the dropdown.
* **minLength** (type: integer, default : 1) : The minimum character length needed before triggering autocomplete suggestions
