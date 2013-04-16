Installation
============

SimpleBootstrap is registered at Packagist. To use it, add the following to your composer.json. The tag 0.1.1 is the lastest stable version :

    {
        "require": {
            "alazjj/simple-bootstrap-bundle": "0.1.1"
        }
    }

If you want to let SimpleBootstrap manage the required assets for you, here is what you need in your composer.json :

    {
        "repositories": [
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
            "alazjj/bootstrap/colorpicker": "dev-master",
            "alazjj/simple-bootstrap-bundle": "0.1.1"
        },
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
    }

The post install and post updates scripts symlink Bootstrap CSS and images into the SimpleBootstrapBundle folder. This procedure is required to enable the CSS rewrite filter.