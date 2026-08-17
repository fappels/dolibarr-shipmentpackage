# SHIPMENTPACKAGE FOR [DOLIBARR ERP CRM](https://www.dolibarr.org)

## Features

Create final shipping packages to handover to transporter.
From a validated shipment you can create a package by selecting the items to put in package.
You can also create stand-alone packages.

![Screenshot shipmentpackage](img/screenshot_package.png?raw=true "ShipmentPackage"){imgmd}

Other external modules are available on [Dolistore.com](https://www.dolistore.com).

## Translations

Translations can be completed manually by editing files into directories *langs*.

There is a [Transifex project](https://www.transifex.com/z-application/dolibarr-shipmentpackage) for this module.


## Installation

### From the ZIP file and GUI interface

- If you get the module in a zip file (like when downloading it from the market place [Dolistore](https://www.dolistore.com)), go into
menu ```Home - Setup - Modules - Deploy external module``` and upload the zip file.

Note: If this screen tell you there is no custom directory, check your setup is correct:

- In your Dolibarr installation directory, edit the ```htdocs/conf/conf.php``` file and check that following lines are not commented:

    ```php
    //$dolibarr_main_url_root_alt ...
    //$dolibarr_main_document_root_alt ...
    ```

- Uncomment them if necessary (delete the leading ```//```) and assign a sensible value according to your Dolibarr installation

    For example :

    - UNIX:
        ```php
        $dolibarr_main_url_root_alt = '/custom';
        $dolibarr_main_document_root_alt = '/var/www/Dolibarr/htdocs/custom';
        ```

    - Windows:
        ```php
        $dolibarr_main_url_root_alt = '/custom';
        $dolibarr_main_document_root_alt = 'C:/My Web Sites/Dolibarr/htdocs/custom';
        ```

### From a GIT repository

- Clone the repository in ```$dolibarr_main_document_root_alt/shipmentpackage```

```sh
cd ....../custom
git clone git@github.com:fappels/dolibarr-shipmentpackage.git shipmentpackage
```

### Final steps

From your browser:

  - Log into Dolibarr as a super-administrator
  - Go to "Setup" -> "Modules"
  - You should now be able to find and enable the module

## User guide

### Setup

Go to `Home - Setup - Modules - ShipmentPackage` to configure the module:

- **Package value calculation**: choose whether the estimated package value (used for transport insurance) is calculated from the products' WAP (weighted average price / buy value) or from their sell price.
- **Numbering**: choose a numbering module for package references, either a templated mask (advanced) or a predefined ref numbering (standard).
- **Document templates**: enable a standard A4/letter document listing the package content, and/or an A6 label format showing the content plus a tracking barcode.
- **Complementary attributes**: add extra fields to the package object from the "Complementary attributes" tab.

### Creating packages

- From a validated shipment card, click **Create Package** to create a package from that shipment. Clicking the button again lets you create additional packages from the same shipment.
- If a draft package already exists for the same customer, an **Add to Package** button also appears, letting you add the shipment to that existing package instead of creating a new one.
- Packages created from a shipment appear in the shipment's **Linked objects** section.
- You can also create a standalone package from the `Products - Shipment Packages - New Package` menu. In this mode you select the products and manually set the quantities to ship, without starting from a shipment.
- All existing packages can be listed from the `Products - Shipment Packages - List` menu.

### Package card

A package has the following properties:

- Link to a **project**, **shipping method**, and flags for **dangerous goods** and **tail lift required**.
- A **type of parcel** (e.g. box, pallet), selected from the "Package parcel type" dictionary. Before it can be used, define the available types in `Home - Setup - Dictionaries - Package parcel type`.
- **Dimensions** and **weight**. If a weight is set on the product cards, the package weight is calculated automatically from its content.
- A **supplier third-party** to link the package to the shipping/transport supplier used.
- A **vendor ref**, i.e. the shipping supplier's tracking number, which is printed as a barcode on the A6 label.

The package card also has the standard Dolibarr tabs for contacts, notes, linked files, and events/agenda.

## Licenses

### Main code

GPLv3 or (at your option) any later version. See file COPYING for more information.

### Documentation

All texts and readmes are licensed under GFDL.
