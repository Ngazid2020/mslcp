# MSLCP — Documentation Interne

Système de Gestion de Laboratoire d'Analyse Médicale.
Opérateur : **Mme RAHAMATOU SILAI** — cabinet privé MSLCP, Comores.

## Démarrage rapide

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed    # peuple la DB avec rôles, éléments NFS et 50 patients de démo
composer dev                  # démarre serveur + queue + logs + vite en parallèle
```

Comptes de démo créés par le seeder :

| Email | Rôle |
|---|---|
| admin@example.com | administrateur |
| labo1@example.com | laborantin + receptionniste |
| receptionniste1@example.com | receptionniste |

Mot de passe par défaut : `password` (défini dans `UserFactory`).

## Architecture

```
app/
├── Filament/Resources/     # CRUD admin (Filament 3.3)
│   └── ElementsResource/
│       ├── RelationManagers/   # Gestionnaire d'analyses sur un bilan
│       └── Api/                # REST auto-généré (Filament API Service)
├── Http/Controllers/       # Génération PDF uniquement (DOMPDF)
├── Models/                 # 13 modèles Eloquent
│   ├── Bilan.php               # Bilan général — ref LAB-YYYY-MM-NNN
│   ├── BilanHormonal.php       # Sous-type de Bilan (type='hormonal'), même table
│   ├── BilanUrinaire.php       # Bilan urinaire — 20+ colonnes plates
│   ├── Bacteriologie.php       # Bactériologie — ref URI-YYYY-MM-NNN
│   ├── Element.php             # Paramètre d'analyse + plages de référence
│   └── Analyse.php             # Pivot Bilan↔Element (stocke le résultat)
└── Policies/               # Une policy par resource Filament
```

`routes/web.php` — routes PDF uniquement (`pdf.bilan`, `pdf.hormonal`, `pdf.bilanurinaire`).  
`routes/api.php` — API Sanctum + endpoints auto-générés sur `Element`.

## Domaine métier

### 4 types d'analyses

| Type | Modèle | Pivot | Route PDF |
|---|---|---|---|
| Général (NFS, biochimie…) | `Bilan` | `analyses` (Element) | `pdf.bilan` |
| Hormonal (FSH, LH, PRL…) | `BilanHormonal` (= `Bilan` type='hormonal') | `analyses` | `pdf.hormonal` |
| Urinaire (ECBU) | `BilanUrinaire` | — (colonnes plates) | `pdf.bilanurinaire` |
| Bactériologie | `Bacteriologie` | `analyse_bacts` (AnalyseUrinaire) | — |

### Valeurs de référence multi-démographiques

`Element` porte 10 colonnes de bornes :

```
ref_inf_h / ref_sup_h   → adulte homme (≥ 16 ans, sexe M)
ref_inf_f / ref_sup_f   → adulte femme (≥ 16 ans, sexe F)
ref_inf_enf / ref_sup_enf  → enfant (5–15 ans)
ref_inf_nour / ref_sup_nour → nourrisson (1–4 ans)
ref_inf_nne / ref_sup_nne   → nouveau-né (< 1 an)
```

La méthode `Element::getReferenceRange(Patient $patient)` sélectionne les bornes correctes.  
La méthode `Element::isResultOutOfRange($value, Patient $patient)` est utilisée par le tableau
de la relation manager pour colorier les résultats (vert = dans la norme, rouge = hors norme).

### Numérotation des bilans

Auto-générée dans `Bilan::boot()` à la création :
- `LAB-YYYY-MM-NNN` pour les bilans généraux et hormonaux
- `URI-YYYY-MM-NNN` pour la bactériologie

## Permissions (Spatie)

Générer / synchroniser les permissions :
```bash
php artisan permissions:sync -C   # crée les permissions
php artisan permissions:sync -O   # génère les policies
```

Permission spéciale non standard : **`download Bilan`** (séparée du `view`) — contrôle l'accès
aux boutons PDF dans le tableau des bilans.

## Tests

```bash
php artisan test              # tous les tests
php artisan test --filter=Ref # filtre sur BilanRefTest
```

Fichiers de tests significatifs :
- `tests/Feature/BilanRefTest.php` — référence auto-générée
- `tests/Feature/BilanHormonalTest.php` — modèle BilanHormonal + global scope
- `tests/Feature/PdfControllerTest.php` — gestion d'erreur des contrôleurs PDF
- `tests/Unit/ElementReferenceRangeTest.php` — logique hors-normes par profil patient
- `tests/Feature/FilamentBilanResourceTest.php` — rendu de la page liste des bilans

Les tests utilisent `RefreshDatabase`. Les permissions doivent être créées dans `setUp()`
(voir `FilamentBilanResourceTest`), car le seeder ne tourne pas dans les tests.

## Déploiement en production

Copier `.env.production.example` vers `.env` et renseigner :
- `DB_*` — connexion MySQL dédiée
- `SESSION_DRIVER=redis`, `CACHE_STORE=redis`, `QUEUE_CONNECTION=redis` — **obligatoire**, voir le fichier pour la raison
- `APP_KEY` — générer avec `php artisan key:generate`

Checklist :
```bash
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
npm run build
php artisan queue:work --tries=3
```

## Points d'attention

- **BilanUrinaire** : 20+ colonnes plates (architecture différente des bilans généraux).
  Ajouter un paramètre = nouvelle migration. Éviter d'alourdir ce modèle.
- **BilanHormonal** n'a pas de table séparée — c'est un `Bilan` avec `type='hormonal'`.
  `BilanHormonal::find($id)` retourne `null` si le bilan n'est pas de type hormonal.
- Les **factories** utilisent `fake()` (helper global Laravel). Toujours appeler `php artisan migrate --seed`
  après un `migrate:fresh` pour avoir les rôles et permissions recréés.
