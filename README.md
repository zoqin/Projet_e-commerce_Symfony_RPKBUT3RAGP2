# Projet e-commerce Symfony
## Etudiant
Paquet--Kremer Robin
## Groupe
Groupe 3 (Réalisation d'application Groupe 2)
## Sujet
Site web de vente d'items et de batiment du jeux Satisfactory (non exostive)

---
## Installation
- Cloner le repo
- Paramètrer le .env.local selon votre configuration
- Créer la base de donnée et load les fixtures
- Dans PHP.ini bien activer extension=intl pour les fichiers de traduction capable de gérer le pluriel
## Guide d'utilisation 
- Ouvrir un navigateur et accèder à l'adresse que vous avez configurer pour hoster le site
ex: http://localhost/ ou http://localhost:port/, etc
- Vous devriez être redirigé sur http://adresse/{locale} ex: http://localhost/fr/
- Vous pouvez changer de langue depuis le header en cliquant sur FR ou EN c'est un simple switch
- Le reste de la navigation devrait être intuitive
  - Quand vous êtes connectez une sidebar rétractable apparait à gauche
    - Notamment pour la navigation des index du crud (delet, show, edit, create depuis les index respectif)
  - Connexion, Inscription, Déconnexion, Panier -> en haut a droite
### Admin
Les paramètres de connexions n'ont pas était choisi pour la sécurité mais pour le confort d'usage lors du développement
#### Email
admin@admin.com
#### Password
password
### User
Il est plus simple de s'inscrire directement et d'utiliser le compte créer pour tester le "front-end"

---
## Choix technique
### Products ManyToMany Categories
J'ai choisi notamment une relation ManyToMany pour les catégories. 
L'idées c'est de pouvoir avoir plusieurs catégories par produit afin de pouvoir affiner des recherches.
Une features que j'apprécie toujours en tant que client quand implémenté.
### Traduction avec gestions du pluriels
Je trouvais cela intéressant d'expérimenter cette feature même si elle n'était pas demander explicitement.
### Bootstrap
Un autre étudiant m'a conseiller ce toolkit et je voulais me faire la mains avec cette outil.
### Recherche dynamique
J'ai décidé d'utiliser la recherche dynamique comme vitrine, néanmoins je n'ai pas encore pu implémenter de feed "infini" ou de pagination elle ne montre qu'un maximum de 9 produit <br>
Néanmoins mon ancien page vitrine existe encore dans `templates\components\_oldProductPage.html.twig` le filtrage par catégories était un ET et non pas un OU comme la version dynamique et bien sûre il fallait redémarrer la page

---
## Limitations, défauts et exercice non complété
### Traduction
Bien que le système de traduction soit en place la traductions n'est pas complète
### Style visuelle
La majorité de mes efforts étant concentré sur l'apprentisage de symphony le style visuelle est discutable
### Profil utilisateur
Bien que le bouton soit présent je n'ai pas eu le temps d'implémenter cette featue néamoins elle ne sembler pas explicitement demandé bien quelle semble relativement importante et évidente à intégrer, navré
### Panier
Le panier fonctionne très bien mais j'aurai aimé ajouter la capacité de modifier directement la quantité en entré numérique
### Thème
Je me rend bien compte que mon site e-commerce ne témoigne pas grandement de mon thème mais je l'ai bien réalisé individuellement
### Image
Je n'ai généré qu'une image avec un thème satisfactory pour mes produits car le site où j'ai était piocher des URL semble bloquer le rendering sur des sites externes. Néanmoins j'ai bien tester l'URL d'au moins une entité qui ressort correctement. J'ai volontairement utilisé des placeholder pour les autres produits pour tester l'esthétique.
### Exercice manquant
A ma connaissance il ne me manque plus que deux parties du grand 9 pour avoir compléter le projet donc:
- Pas de panier dynamique sans recharger la page
- Pas de gestion CB

---
## Contact
En cas de problèmes ou si mon projet manque de clareté, je suis ouvert à être contacté
### Discord
`zoqin`
### E-mail
`zoqinrobinpk@hotmail.fr` <br>
(je ne regarde quasiment jamais mes mail pour un contact urgent favorisé Discord)

## Remerciement
Merci de nous avoir permis de travailler sur un projet complet cette expérience a était extrêmement enrichissante