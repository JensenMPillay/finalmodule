<?php

// ACCES FICHIER
if (!defined('_PS_VERSION_')) {
    exit();
}

class FinalModule extends Module // Extends Modèle Module
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

    public function install()  // Récupération de toute la fonction install() de Module
    {
        // Test de Vérification avant l'install du module(Parent::Install, Clé Configuration, Position Hook à l'install)
        if (
            !parent::install()
            || !Configuration::updateValue('ANNEE', '1992')
            || !Configuration::updateValue('MOIS', 'JUILLET')
        ) {
            return false;
        }
        return true;
    }

    public function uninstall()  // Récupération de toute la fonction uninstall() de Module
    {
        // Test de Vérification avant l'uninstall du module(Parent::Uninstall, Clé Configuration)
        if (
            !parent::uninstall()
            || !Configuration::deleteByName('ANNEE')
            || !Configuration::deleteByName('MOIS')
        ) {
            return false;
        }
        return true;
    }

    // Fonction getContent() : Possibilité de Configurer le Module (Admin)

    public function getContent()
    {

        return $this->postProcess() . $this->renderForm();
    }

    // Fonction renderForm() : Création Formulaire de Modification

    public function renderForm()
    {
        $fieldForm[0]['form'] = [
            'legend' => [
                'title' => $this->l('Modifier les clés de configuration')
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l("Modifier l'année"),
                    'name' => 'ANNEE',
                    'required' => true
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Modifier le mois'),
                    'name' => 'MOIS',
                    'required' => true
                ],
            ],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-primary',
                'name' => 'save'
            ]
        ];

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        // Lecture de Clé de Sécurité de L'Admin
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        // Préremplissage value de l'input name = "NEW_KEY_SECURITY"
        $helper->fields_value['ANNEE'] = Configuration::get('ANNEE');
        $helper->fields_value['MOIS'] = Configuration::get('MOIS');

        return $helper->generateForm($fieldForm);
    }

    // Méthode PostProcess : Validation renderForm
    public function postProcess()
    {
        // Au Submit
        if (Tools::isSubmit('save')) {
            // Tools:getValue = $_POST || $_GET
            $annee = Tools::getValue('ANNEE');
            $mois = Tools::getValue('MOIS');

            if (empty($annee) || empty($mois)) {
                // Erreur
                return $this->displayError('Fields cannot be empty');
            }
            // Vérification Validation des champs avec Méthode Validate
            // elseif (!Validate::isInt($annee) || !Validate::isInt($mois)) {
            //     // Erreur
            //     return $this->displayError('Fields cannot be empty');} 
            else {
                // Modification
                Configuration::updateValue('ANNEE', $annee);
                Configuration::updateValue('MOIS', $mois);
                // Affichage "Succès"
                return $this->displayConfirmation('Keys have been updated');
            }
        }
    }
}
