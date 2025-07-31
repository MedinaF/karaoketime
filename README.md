# Karaoke Time ! : site de Karaoké réalisé avec Symfony

Ce projet est un site web de Karaoké développée en Symfony permettant aux utilisateurs de noter, commenter et ajouter en favori des chansons de karaoké.

## Les fonctionnalités

Les fonctionnalités prévues pour ce projet sont les suivantes :
- Accéder à une liste de chansons avec artiste, catégorie, commentaires
- S'inscrire et se connecter en tant qu'utilisateur
- Commenter sur les chansons
- Ajouter de chansons en favoris
- Noter les chansons (de 1 à 5 étoiles)
- Filtrer par artiste ou catégorie

---

### Mes entités 

- `User` : Utilisateur de la plateforme
- `Song` : Chanson de karaoké
- `Artist` : Artiste associé à une chanson
- `Category` : Catégorie musicale
- `Comment` : Commentaires des utilisateurs sur les chansons
- `Favorite` : Table des chansons favorites des utilisateurs 
- `Rating` : Note donnée par un utilisateur à une chanson qui pourra servir à donner une moyenne des notes sur la chanson

---


#### Là où j'ai eu des difficultés 
j'ai p



---

##### Ce que j'aurai aimé terminer/ajouter à mon projet : 


---

##  Installation

```bash
symfony new karaoketime --webapp
cd karaoketime
composer require fakerphp/faker
composer require easycorp/easyadmin-bundle
```

## Commandes git

Pour ajouter les modifications sur Git :

git add .

git commit -m "Ajout de nouveaux fichiers"
git commit -m "Ajout IndexController, ReadMe.md,Tailwind "
git commit -m "Créations d'entités et migrations"

git push
