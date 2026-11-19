# Thème WordPress Dave Procode

Thème enfant de [Kadence](https://www.kadencewp.com/kadence-theme/) pour le site [daveprocode.com](https://daveprocode.com).

## Installation

1. Installez et activez le thème gratuit **Kadence** (Apparence > Thèmes > Ajouter).
2. Téléchargez le zip de la dernière version (bouton **Code > Download ZIP**, ou l'archive de la dernière branche `version-X.Y.Z`).
3. Apparence > Thèmes > Ajouter > Téléverser un thème, puis activez **Dave Procode**.

## Mises à jour

Le thème lit le fichier [`update.json`](update.json) de ce dépôt. Quand une nouvelle version est publiée,
elle apparaît dans **Tableau de bord > Mises à jour** : un clic sur « Mettre à jour » suffit.
Les pages, réglages Yoast SEO, coordonnées et messages du site ne sont jamais modifiés par une mise à jour.

## Publier une nouvelle version

1. Augmentez la version dans `style.css` et dans `functions.php` (`DP_VERSION`), puis publiez le code.
2. Créez la branche `version-X.Y.Z` à partir de `main` et publiez-la.
3. Mettez à jour `update.json` (`version`, et `package` = `…/archive/refs/heads/version-X.Y.Z.zip`).

WordPress télécharge l'archive de cette branche ; le thème remet automatiquement le dossier au bon nom pendant l'installation.

## Crédits

- Photos : [Pexels](https://www.pexels.com/fr-fr/licence/) (licence gratuite, usage commercial).
- Icônes : [Lucide](https://lucide.dev) (ISC) et [Simple Icons](https://simpleicons.org) (CC0).
- Polices : Archivo et Carlito (SIL Open Font License).
