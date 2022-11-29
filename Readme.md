# HSTS

Enable HTTP Strict Transport Security for Thelia
More information : https://en.wikipedia.org/wiki/HTTP_Strict_Transport_Security
## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is HSTS.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/hsts-module:~0.2
```

## Usage

Go to `/admin/configuration/variables`
Configuration variables 
- hsts_enable
- hsts_include_sub_domains
- hsts_max_age
- hsts_preload
