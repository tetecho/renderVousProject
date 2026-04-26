# Cabinet Medical - Gestion des Rendez-vous

Projet realise dans le cadre du **CC2 OFPPT (DD 2eme annee, 2025/2026)** pour gerer les prises de rendez-vous d'un cabinet medical.

## 1) Fonctionnalites principales

- Authentification complete (login/register/logout)
- Gestion des roles:
  - `admin`: voit tout et gere tout (CRUD complet)
  - `patient`: voit ses rendez-vous uniquement
  - `medecin`: voit ses rendez-vous uniquement
- Gestion des rendez-vous:
  - creation, lecture, modification, suppression
  - annulation directe
  - confirmation directe (admin) sans passer par la page edit
  - regle de conflit 1h (patient et medecin)
- Interface Blade avec layout coherent (header/sidebar/footer)
- Modales pour actions critiques (ajout/suppression)
- Internationalisation: **fr, en, es, ar** (switch langue via UI)
- API REST pour lister et creer des rendez-vous (JSON)
- Envoi d'email de confirmation au patient quand un rendez-vous passe a `confirme`

---

## 2) Prerequis

- PHP >= 8.3
- Composer
- MySQL (ou autre SGBD compatible Laravel)
- Node.js + npm (pour Vite/Tailwind)

---

## 3) Installation et lancement

```bash
git clone <URL_DU_REPO>
cd renderVousProject
composer install
cp .env.example .env
php artisan key:generate
```

Configurer ensuite la base dans `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=render_vous
DB_USERNAME=root
DB_PASSWORD=
```

Executer migration + seed:

```bash
php artisan migrate:fresh --seed
```

Installer les assets frontend:

```bash
npm install
npm run dev
```

Lancer l'application:

```bash
php artisan serve
```

---

## 4) Comptes de connexion par defaut

Apres `php artisan migrate:fresh --seed`:

- **Admin**
  - Email: `admin@cabinet.test`
  - Mot de passe: `123456789`
- **Patient**
  - Email: `patient@cabinet.test`
  - Mot de passe: `123456789`
- **Medecin**
  - Email: `medecin@cabinet.test`
  - Mot de passe: `123456789`

Le seeding cree aussi des utilisateurs supplementaires (minimum 10 users au total), 5 services et 20 rendez-vous.

---

## 5) Documentation API

Base URL locale:

```text
http://127.0.0.1:8000/api
```

### A. Lister les rendez-vous

- **Method:** `GET`
- **Endpoint:** `/api/rendezvous`
- **Description:** retourne la liste des rendez-vous avec relations `patient`, `medecin`, `service`.

Exemple:

```bash
curl -X GET http://127.0.0.1:8000/api/rendezvous
```

---

### B. Creer un rendez-vous

- **Method:** `POST`
- **Endpoint:** `/api/rendezvous`
- **Body JSON requis:**
  - `patient_id` (doit etre un user role `patient`)
  - `medecin_id` (doit etre un user role `medecin`)
  - `service_id` (id existant)
  - `date_heure` (date future)

Exemple:

```bash
curl -X POST http://127.0.0.1:8000/api/rendezvous \
  -H "Content-Type: application/json" \
  -d '{
    "patient_id": 2,
    "medecin_id": 3,
    "service_id": 1,
    "date_heure": "2026-05-15 10:00:00"
  }'
```

Reponses:

- `201 Created`: rendez-vous cree (statut force a `en_attente`)
- `422 Unprocessable Entity` si:
  - validation invalide
  - conflit de creneau 1h cote medecin
  - conflit de creneau 1h cote patient

---

## 6) Mailing (confirmation)

Un email est envoye au **patient** quand le rendez-vous devient `confirme`:

- depuis la modification du rendez-vous (page edit)
- depuis l'action directe **Confirmer** (menu admin)

Pour tester en local, vous pouvez utiliser:

- `MAIL_MAILER=log` (verifier `storage/logs/laravel.log`)
- ou Mailpit / SMTP selon votre configuration `.env`

---

## 7) Changement de langue

Locales disponibles: `fr`, `en`, `es`, `ar`.

Route de switch:

```text
/locale/{locale}
```

Exemples:

- `/locale/fr`
- `/locale/en`
- `/locale/es`
- `/locale/ar`

---

## 8) Commandes utiles

```bash
php artisan migrate:fresh --seed
php artisan route:list
php artisan config:clear
php artisan cache:clear
```

