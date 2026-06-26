<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Informations de contact du laboratoire
    |--------------------------------------------------------------------------
    | Utilisées pour générer le QR code MECARD dans les rapports PDF.
    | Modifier ces valeurs dans .env sans redéploiement du code.
    */

    'contact' => [
        'nom_famille' => env('MSLCP_NOM_FAMILLE', 'SILAI'),
        'prenom'      => env('MSLCP_PRENOM', 'RAHAMATOU'),
        'tel1'        => env('MSLCP_TEL1', '+2693330375'),
        'tel2'        => env('MSLCP_TEL2', '+2694735095'),
        'email'       => env('MSLCP_EMAIL', 'mslcp_silai@yahoo.fr'),
        'entreprise'  => env('MSLCP_ENTREPRISE', 'MSLCP'),
        'titre'       => env('MSLCP_TITRE', 'Parasitologue/MSc Biochimie'),
    ],

];
