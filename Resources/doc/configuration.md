Configuration
=============

Register the bundle
-------------------

Register the bundle in the kernel by editing app/AppKernel.php

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Alazjj\SimpleBootstrapBundle\AlazjjSimpleBootstrapBundle(),
        );
    }

Assetic configuration
---------------------

If you decided to let SimpleBootstrapBundle manage all the required assets, you can use one of the assetic*.yml configuration file for assetic.

* assetic.yml : defines jQuery and Twitter Bootstrap assets
    * CSS rewrite filter is enabled
    * Yui JS compressor is enabled only for production environement
* assetic_no_yui.yml : defines jQuery and Twitter Bootstrap assets
    * CSS rewrite filter is enabled
    * Yui JS is not enabled

Just import an assetic configuration file as follows :

    # app/config/config.yml
    imports:
        - { resource: @AlazjjSimpleBootstrapBundle/Resources/config/assetic.yml }

Forms and fields template
-------------------------

The SimpleBootstrapBundle:Form:fields.html.twig template allows Symfony's forms to match the Bootstrap Twitter markup. It also defines a simple layout for the date picker and color picker form field types.

You can import it in your configuration like this :

    # app/config/config.yml
    twig:
        form:
            resources:
                - 'AlazjjSimpleBootstrapBundle:Form:fields.html.twig'


Base template
-------------

