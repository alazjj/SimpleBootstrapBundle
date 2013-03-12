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
                "name": "alazjj/bootstrap/twitter",
                "version": "2.3.1",
                "dist": {
                    "url": "http://twitter.github.com/bootstrap/assets/bootstrap.zip",
                    "type": "zip"
                }
            }
        }
    ],
    "require": {
        "alazjj/SimpleBootstrapBundle": "dev-master",
        "alazjj/jquery": "1.9.1",
        "alazjj/bootstrap/twitter": "2.3.1"
    }
}
```