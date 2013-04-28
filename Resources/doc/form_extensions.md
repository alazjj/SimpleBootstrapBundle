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

It is possible to active edition for all fields, you have to put data-form-edit="form" on a button (or other element) but you must use the main.js provided by the bundle.

```html
<form class="form-horizontal" action="ptah/to/edit" method="POST" id="#form">
    <button data-form-edit="form">Edit all fields<button/>
    {{ form_rest(form) }}
    <input type="submit" value="Send" />
</form>
```

```js
    $('#form').simpleForm({'submitFieldOn': 'disable'});
```
You can manualy active edition for all fields too, you have to put HTML element with data-form-edit="form" like attribute. You can choose the datas submition with the submitFieldOn plugin option, two ways :
* **disable** : the form is submited by the user (he click on the submit input)
* **change** : the data is submited when you change the value of the field

### Controller

If the value submited is not valid you must return json response like the folling example :
```php
<?php
public function contactAction()
{
    if (!$form->isValid() && $this->getRequest()->isXmlHttpRequest()) {
        return new \Symfony\Component\HttpFoundation\JsonResponse(array(
            'status' => 'error',
            'message' => 'Oops! An Error Occurred'
        ));
    }
}
```
If any errors occured, the status must be "error" and the massage is displayed to the user to warm him. You only have to return JsonResponse (instead of using flashes) if the request is an ajax request.




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
