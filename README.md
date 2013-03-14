SimpleBootstrapBundle
=====================

## Installation

Add AlazjjSimpleBootstrapBundle in your composer.json:

```js
{
    "repositories": [
        {
            "type": "vcs",
            "url":  "https://github.com/alazjj/SimpleBootstrapBundle.git"
        },
        {
            "type": "package",
            "package": {
                "name": "alazjj/jquery",
                "version": "1.9.1",
                "dist": {
                    "url": "http://code.jquery.com/jquery-1.9.1.min.js",
                    "type": "file"
                }
            }
        },
        {
            "type": "package",
            "package": {
                "name": "alazjj/jquery/form",
                "version": "3.28.0",
                "dist": {
                    "url": "http://malsup.github.com/jquery.form.js",
                    "type": "file"
                }
            }
        },
        {
            "type": "package",
            "package": {
                "name": "alazjj/bootstrap/twitter",
                "version": "2.3.1",
                "dist": {
                    "url": "http://twitter.github.com/bootstrap/assets/bootstrap.zip",
                    "type": "zip"
                }
            }
        },
        {
            "type": "package",
            "package": {
                "name": "alazjj/bootstrap/datepicker",
                "version": "dev-master",
                "dist": {
                    "url": "http://www.eyecon.ro/bootstrap-datepicker/datepicker.zip",
                    "type": "zip"
                }
            }
        },
        {
            "type": "package",
            "package": {
                "name": "alazjj/bootstrap/colorpicker",
                "version": "dev-master",
                "dist": {
                    "url": "http://www.eyecon.ro/bootstrap-colorpicker/colorpicker.zip",
                    "type": "zip"
                }
            }
        }
    ],
    "require": {
        "alazjj/jquery": "1.9.1",
        "alazjj/jquery/form": "3.28.0",
        "alazjj/bootstrap/twitter": "2.3.1",
        "alazjj/bootstrap/datepicker": "dev-master",
        "alazjj/bootstrap/colorpicker": "dev-master"
        "alazjj/SimpleBootstrapBundle": "dev-master",
    }
}
```

Add the post install scripts in your composer.json:
```js
    {
        "scripts": {
            "post-install-cmd": [
                "Alazjj\\SimpleBootstrapBundle\\Composer\\ScriptHandler::installAssets"
            ],
            "post-update-cmd": [
                "Alazjj\\SimpleBootstrapBundle\\Composer\\ScriptHandler::installAssets"
            ]
        }
    }
```


## Configuration

Register the bundle in the kernel :
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

Import or copy the assets configuration :
```yaml
    # app/config/config.yml
    imports:
        - { resource: @AlazjjSimpleBootstrapBundle/Resources/config/assetic.yml }
```

Use AlazjjSimpleBootstrapBundle the template to display forms and fields :
```yaml
    # app/config/config.yml
    twig:
        form:
            resources:
                - 'AlazjjSimpleBootstrapBundle:Form:fields.html.twig'
```

You can now define a layout template which extends
```twig
    # app/Resources/views/layout.html.twig
    {% extends "AlazjjSimpleBootstrapBundle::base.html.twig" %}
    {% block body %}
        // your content goes here
        // ...
    {% endblock body %}
```