# Changelog

Toutes les modifications notables de MSLCP sont documentées ici.
Format : [Keep a Changelog](https://keepachangelog.com/fr/1.0.0/).
Versioning : [Semantic Versioning](https://semver.org/lang/fr/).

---

## [Unreleased]

### Ajouté
- Modèle `BilanHormonal` avec global scope (`type = 'hormonal'`) pour distinguer
  les bilans hormonaux des bilans généraux au niveau du modèle
- Méthodes `Element::getReferenceRange()` et `Element::isResultOutOfRange()` pour
  comparer un résultat aux plages de référence selon le profil démographique du patient
- Alertes visuelles hors-normes dans la relation manager des éléments (badge vert/rouge)
- Colonne `unite` visible dans le tableau des analyses d'un bilan
- Gestion d'erreur (try/catch) dans `BilanPdfController` et `BacteriologiePdfController` :
  404 si enregistrement introuvable, 422 si patient manquant, 500 loggué pour les autres erreurs
- Fichier `.env.production.example` documentant la configuration Redis pour la production
- Fichier `lang/fr/validation.php` — messages de validation en français
- `CLAUDE.md` — documentation interne de l'architecture et des conventions
- Tests PHPUnit couvrant : référence auto-générée, BilanHormonal scope, plages de référence,
  gestion d'erreur des contrôleurs PDF, accès Filament avec permissions
- Données de démo dans `DatabaseSeeder` : 10 prescripteurs, catégories NFS avec éléments
  (hémoglobine, hématocrite, GR, VGM, TCMH, CCMH, leucocytes, formule, plaquettes, bilans
  prostatiques et hormonaux) avec plages de référence complètes, 5 bilans avec analyses

### Corrigé
- `PatientFactory` : champ `Age` renommé en `age` (cohérence avec la colonne DB)
- `PrescripteurFactory` : factory vide complétée avec nom, adresse, tel, email
- `DatabaseSeeder` : `$userReceptionniste` maintenant assigné au rôle receptionniste ;
  variable `$elements = []` inutilisée supprimée du foreach des catégories
- Test `FilamentBilanResourceTest` : rôle corrigé (`administrateur` non `admin`) ;
  `WithFaker` inutilisé supprimé ; `$user->guard(['web'])->login($user)` incorrect supprimé

---

## [0.1.0] — 2026-06-01

### Ajouté
- Interface d'administration Filament 3.3
- Gestion des patients, prescripteurs, bilans généraux, bilans urinaires, bactériologie
- Paramètres d'analyse (`Element`) avec plages de référence multi-démographiques
- Génération PDF DOMPDF avec QR code MECARD (bilan général, hormonal, urinaire)
- RBAC via Spatie Laravel Permissions (administrateur, laborantin, receptionniste)
- Permission personnalisée `download Bilan` pour contrôler l'accès aux PDF
- Numérotation automatique `LAB-YYYY-MM-NNN` et `URI-YYYY-MM-NNN`
- API REST auto-générée sur `Element` via Filament API Service
- Widget dashboard "Bilans par mois" (Filament Apex Charts)
- Import Excel des éléments
- Authentification API via Laravel Sanctum
