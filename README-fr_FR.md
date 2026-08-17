# SHIPMENTPACKAGE POUR [DOLIBARR ERP CRM](https://www.dolibarr.org)

## Fonctionnalités

Créez des colis d'expédition finaux à remettre au transporteur.
À partir d'une expédition validée, vous pouvez créer un colis en sélectionnant les articles à y mettre.
Vous pouvez également créer des colis autonomes.

![Screenshot shipmentpackage](img/screenshot_package.png?raw=true "ShipmentPackage"){imgmd}

D'autres modules externes sont disponibles sur [Dolistore.com](https://www.dolistore.com).

## Traductions

Les traductions peuvent être effectuées manuellement en modifiant les fichiers situés dans les répertoires *langs*.

Il existe un [projet Transifex](https://www.transifex.com/z-application/dolibarr-shipmentpackage) pour ce module.


## Installation

### À partir du fichier ZIP et de l'interface graphique

- Si vous obtenez le module sous forme de fichier zip (par exemple en le téléchargeant depuis la place de marché [Dolistore](https://www.dolistore.com)), allez dans le
menu ```Accueil - Configuration - Modules - Déployer un module externe``` et téléchargez le fichier zip.

Remarque : Si cet écran indique qu'il n'y a pas de répertoire custom, vérifiez que votre configuration est correcte :

- Dans le répertoire d'installation de Dolibarr, éditez le fichier ```htdocs/conf/conf.php``` et vérifiez que les lignes suivantes ne sont pas en commentaire :

    ```php
    //$dolibarr_main_url_root_alt ...
    //$dolibarr_main_document_root_alt ...
    ```

- Décommentez-les si nécessaire (supprimez le ```//``` au début) et attribuez une valeur adaptée à votre installation Dolibarr

    Par exemple :

    - UNIX :
        ```php
        $dolibarr_main_url_root_alt = '/custom';
        $dolibarr_main_document_root_alt = '/var/www/Dolibarr/htdocs/custom';
        ```

    - Windows :
        ```php
        $dolibarr_main_url_root_alt = '/custom';
        $dolibarr_main_document_root_alt = 'C:/My Web Sites/Dolibarr/htdocs/custom';
        ```

### À partir d'un dépôt GIT

- Clonez le dépôt dans ```$dolibarr_main_document_root_alt/shipmentpackage```

```sh
cd ....../custom
git clone git@github.com:fappels/dolibarr-shipmentpackage.git shipmentpackage
```

### Dernières étapes

Depuis votre navigateur :

  - Connectez-vous à Dolibarr en tant que super-administrateur
  - Allez dans « Configuration » -> « Modules »
  - Vous devriez maintenant pouvoir trouver et activer le module

## Guide d'utilisation

### Configuration

Allez dans `Accueil - Configuration - Modules - ShipmentPackage` pour configurer le module :

- **Calcul de la valeur du colis** : choisissez si la valeur estimée du colis (utilisée pour l'assurance transport) est calculée à partir du PMP (prix moyen pondéré / valeur d'achat) des produits ou à partir de leur prix de vente.
- **Numérotation** : choisissez un module de numérotation pour les références des colis, soit un masque personnalisable (avancée), soit une numérotation de référence prédéfinie (standard).
- **Modèles de documents** : activez un document standard au format A4/lettre listant le contenu du colis, et/ou une étiquette au format A6 affichant le contenu ainsi qu'un code-barres de suivi.
- **Attributs complémentaires** : ajoutez des champs supplémentaires à l'objet colis depuis l'onglet « Attributs complémentaires ».

### Création des colis

- Depuis une expédition validée, cliquez sur **Créer le colis** pour créer un colis à partir de cette expédition. Cliquer à nouveau sur ce bouton permet de créer d'autres colis à partir de la même expédition.
- Si un colis brouillon existe déjà pour le même client, un bouton **Ajouter au colis** apparaît également, permettant d'ajouter l'expédition à ce colis existant plutôt que d'en créer un nouveau.
- Les colis créés à partir d'une expédition apparaissent dans la section **Objets liés** de l'expédition.
- Vous pouvez également créer un colis autonome depuis le menu `Produits - Colis d'expédition - Nouveau colis`. Dans ce mode, vous sélectionnez les produits et définissez manuellement les quantités à expédier, sans partir d'une expédition.
- Tous les colis existants peuvent être listés depuis le menu `Produits - Colis d'expédition - Liste`.

### Fiche colis

Un colis dispose des propriétés suivantes :

- Lien vers un **projet**, un **mode d'expédition**, ainsi que des indicateurs **marchandise dangereuse** et **hayon nécessaire**.
- Un **type de colis** (par exemple carton, palette), sélectionné dans le dictionnaire « Type de colis ». Avant de pouvoir l'utiliser, définissez les types disponibles dans `Accueil - Configuration - Dictionnaires - Type de colis`.
- **Dimensions** et **poids**. Si un poids est renseigné sur les fiches produits, le poids du colis est calculé automatiquement à partir de son contenu.
- Un **tiers fournisseur** permettant de lier le colis au transporteur/fournisseur d'expédition utilisé.
- Une **référence fournisseur**, c'est-à-dire le numéro de suivi du transporteur, qui est imprimé sous forme de code-barres sur l'étiquette A6.

La fiche colis dispose également des onglets standards de Dolibarr pour les contacts, les notes, les fichiers liés et les événements/agenda.

## Licences

### Code principal

GPLv3 ou (à votre choix) toute version ultérieure. Consultez le fichier COPYING pour plus d'informations.

### Documentation

Tous les textes et fichiers Lisez-moi sont sous licence GFDL.
