Configuration
=============

Register the bundle
-------------------

Register the bundle in the kernel by editing `app/AppKernel.php`
```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Alazjj\SimpleBootstrapBundle\AlazjjSimpleBootstrapBundle(),
    );
}
```
Assetic configuration
---------------------

If you decided to let SimpleBootstrapBundle manage all the required assets, you can use one of the `assetic*.yml` configuration file for assetic.

* `assetic.yml` : defines jQuery and Twitter Bootstrap assets
    * CSS rewrite filter is enabled
    * Yui JS compressor is enabled only for production environement
* `assetic_no_yui.yml` : defines jQuery and Twitter Bootstrap assets
    * CSS rewrite filter is enabled
    * Yui JS is not enabled

Just import an assetic configuration file as follows :
```yaml
# app/config/config.yml
imports:
    - { resource: @AlazjjSimpleBootstrapBundle/Resources/config/assetic.yml }
```

Forms and fields template
-------------------------

The `SimpleBootstrapBundle:Form:fields.html.twig` template allows Symfony's forms to match the Bootstrap Twitter markup. It also defines a simple layout for the date picker and color picker form field types.

You can import it in your configuration like this :
```yaml
# app/config/config.yml
twig:
    form:
        resources:
            - 'AlazjjSimpleBootstrapBundle:Form:fields.html.twig'
```

Base template
-------------

If you decided to let SimpleBootstrapBundle manage all the required assets, you can use the 'AlazjjSimpleBootstrapBundle::base.html.twig' template.
This is a very minimal template which defines a body block, modals containers and includes all the required assets plus SimpleBootstrapBundle extensions.

Otherwise, you will have to include the following assets manually in your project :
* @AlazjjSimpleBootstrapBundle/Resources/public/css/*
* @AlazjjSimpleBootstrapBundle/Resources/public/js/core/*
* @AlazjjSimpleBootstrapBundle/Resources/public/js/main.js