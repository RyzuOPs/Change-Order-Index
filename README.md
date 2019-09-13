# Change Order Index - module for Prestashop 1.7

This module override Order class to change order reference to numeric with prefix (option) like:

```
PFX-20256
```

## How it works?

This is simple override of classes/order/Order.php changing the way of generating reference number in orders.

No need to change anything in the files, just install the module and activate override in module settings.
After activating the override, the next order placed in your store will have the format as in the preview available in the module settings.


### Prerequisites

This module is written for Prestashop 1.7.x


### Installing

Download:

* [Change Order Index v.1.0](https://github.com/RyzuOPs/Change-Order-Index) - relase zip.

or clone to /modules directory of your shop:

* [https://github.com/RyzuOPs/Change-Order-Index](https://github.com/RyzuOPs/Change-Order-Index) - clone module from Git repo

```
git clone https://github.com/RyzuOPs/Change-Order-Index
```

