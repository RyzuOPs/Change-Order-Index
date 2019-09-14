# Change Order Index - module for Prestashop 1.7

This module override Order class to change order reference to numeric (from order id) with optionally prefix and separator like:

```
PFX-20256
```

### How it works?

This is simple override of classes/order/Order.php changing the way of generating reference number in orders.

No need to change anything in the files, just install the module and activate override in module settings.
After activating the override, the next order placed in your store will have the format as in the preview available in the module settings.


### Prerequisites

This module is written for Prestashop 1.7.x




## Installing

### Download relase or clone

Download:
* [Change Order Index v.1.0](https://github.com/RyzuOPs/ChangeOrderIndex/changeorderindex-v1.0.zip) - relase zip.

or clone to /modules directory of your shop:
```
git clone https://github.com/RyzuOPs/Change-Order-Index
```
### Install 

#### Install through module manager

You can install module through manager in the backoffice:

1. Login to backoffice
2. Go to:
```
Improve -> Module Manager -> Upload a module

```
3. Configure module

#### Install through Prestashop console

``
./bin/console prestashop:module install changeorderindex
``

## Configure

Override is disabled by default after installation. 
To override work properly turn it on in the module settings.

You can use prefix and separator.





