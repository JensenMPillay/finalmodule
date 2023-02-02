<?php

// ACCES FICHIER
if (!defined('_PS_VERSION_')) {
    exit();
}

class MyModule extends Module // Extends Modèle Module
{
    public function __construct()
    {
        // Renseignement Info Module Admin (Modules/Catalogue de modules)
        $this->name = 'finalmodule';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Jensen M';
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_
        ];
        parent::__construct();
        $this->bootstrap = true;
        // 'l' : Méthode de Traduction 
        $this->displayName = $this->l('Final Module');
        $this->description = $this->l('Un Module pour comprendre le fonctionnement des créations de modules sur Prestashop');
    }

    // Positions Hook Admin (Apparences/Position)
    // Utilisation Hook : Méthode registerHook()
    // public function registerHook($hook_name){}
}
