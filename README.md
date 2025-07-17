# 🛒 ShopCartFinal

**ShopCartFinal** est une application e-commerce développée en fullstack :
- Backend en **PHP pur** avec Composer et une API REST
- Frontend en **Angular 18**, responsive et déployé avec Nginx

---

## 🚀 Fonctionnalités

- 🧾 Liste des produits et catégories
- 🔍 Détail des produits
- 📡 Communication entre Angular et PHP via `HttpClient`
- 📁 Gestion des images, appels API dynamiques avec `environment.ts`

---

## ⚙️ Stack technique

| Partie        | Techno utilisée        |
|---------------|------------------------|
| Frontend      | Angular 18 + Nginx     |
| Backend       | PHP (sans framework) + Composer |
| Base de données | MySQL                 |
| Serveur       | 2 VM GCP (1 front, 1 back) |

---

## 😵‍💫 Difficultés rencontrées

J'ai rencontré plusieurs difficultés pendant le déploiement, notamment :
- La configuration de la **base de données MySQL** à la main dans le terminal (création, utilisateur, permissions)
- La configuration **des Virtual Hosts et du `.conf` Nginx**
- La gestion du **CORS** et des IP dynamiques dans `environment.ts`
- La mise en place du build Angular et sa liaison avec l'API PHP

---

## 🔗 Accès

- 💻 Frontend Angular : [http://104.155.43.118](http://104.155.43.118)
- 🔙 API PHP : [http://34.76.162.53/](http://34.76.162.53/)

> *⚠️ Pas encore en HTTPS – accès direct via IP*

---

## 📂 Arborescence principale

```bash
shopcartfinal/
├── frontend/                # Angular
│   └── src/
│       └── app/
│           ├── services/
│           ├── components/
│           └── models/
├── backend/                 # PHP API
│   ├── index.php
│   ├── src/
│   ├── Fixtures/
│   └── composer.json
