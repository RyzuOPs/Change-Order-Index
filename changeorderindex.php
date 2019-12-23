<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class Changeorderindex extends Module
{
    public function __construct()
    {
        $this->name = 'changeorderindex';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Łukasz Ryszkiewicz';
        $this->author_uri = 'https://ryszkiewicz.cloud';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array(
            'min' => '1.7',
            'max' => _PS_VERSION_);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Change Order Index');
        $this->description = $this->l('This module override Order class to change order reference.');
        $this->confirmUninstall = $this->l('Uninstall module?');
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        return parent::install() &&
            Configuration::updateValue('CHANGEORDERINDEX_OVERRIDE_ENABLED', false) &&
            Configuration::updateValue('CHANGEORDERINDEX_PFX', "PFX") &&
            Configuration::updateValue('CHANGEORDERINDEX_PFX_SEPARATOR', false);
    }

    public function uninstall()
    {
        Configuration::deleteByName('CHANGEORDERINDEX_OVERRIDE_ENABLED');
        Configuration::deleteByName('CHANGEORDERINDEX_PFX');
        Configuration::deleteByName('CHANGEORDERINDEX_PFX_SEPARATOR');
        
        return parent::uninstall();
    }

    public function checkOverride()
    {
        return file_exists(_PS_ROOT_DIR_.'/override/classes/order/Order.php');
    }

    public function getContent()
    {
        $output = '';
        
        if (Tools::isSubmit('submit_'.$this->name)) {
            if ($this->postProcess()) {
                $output .= $this->displayConfirmation($this->l('Settings saved'));
            } else {
                $output .= $this->displayWarning($this->l('Something went wrong! Check form values.'));
            }
        }
            
        $vars = array(
            $this->name . '_name' => $this->displayName,
            $this->name . '_version' => $this->version,
            $this->name . '_compliancy' => $this->ps_versions_compliancy['min'],
            
            $this->name.'_enabled' => Module::isEnabled('changeorderindex'),
            $this->name.'_override_enabled' =>  Configuration::get('CHANGEORDERINDEX_OVERRIDE_ENABLED'),
            
            
            
            $this->name.'_preview'=> Order::generateReference(),
            
            $this->name.'_short_desc'=> $this->description,
            $this->name.'_overrideok'=> $this->checkOverride(),
            $this->name.'_logo' => $this->getPathUri()."/logo.png",
            
            
        );
        
        $this->context->smarty->assign($vars);

        $output .= $this->context->smarty->fetch($this->local_path . 'views/templates/admin/header.tpl');
        $output .= $this->displayForm();
        $output .= $this->context->smarty->fetch($this->local_path . 'views/templates/admin/footer.tpl');

        return $output;
    }

    public function displayForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Module settings'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    # Switch override
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable override?'),
                        'name' => 'CHANGEORDERINDEX_OVERRIDE_ENABLED',
                        'is_bool' => true,
                        'desc' => $this->l('Set "Yes" to enable override orders class. 
                            Override will not work if not enabled here even if file exists in /overrides directory.
                            '),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('On')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Off')
                            )
                        ),
                    ),
                    # Preview
                    array(
                        'name' => 'separator',
                        'type' => 'html',
                        'label' => $this->l('Next order reference').'<br>'.$this->l('number will be: '),
                        'html_content' => '                   
                                <div class="row">
                                    <div class="panel" style="width:250px; padding:0 25px 0 25px">
                                        <span style="font-size:36px;">'.Order::generateReference().'</span>
                                    </div>
                                </div>
                            ',
                        'ignore' => true
                    ),
                    # Prefix
                    array(
                        'type' => 'text',
                        'label' => $this->l('Prefix'),
                        'class' => 't',
                        'name' => 'CHANGEORDERINDEX_PFX',
                        'desc' => $this->l('Prefix can be letters or numbers (max 3)'),
                        'size' => '3'
                    ),
                    # Prefix separator
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Use prefix separator?'),
                        'name' => 'CHANGEORDERINDEX_PFX_SEPARATOR',
                        'is_bool' => true,
                        'desc' => $this->l('Set "Yes" to enable "-" separator.'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('On')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Off')
                            )
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save')
                )
            ),
        );

        $lang = new Language((int) Configuration::get('PS_LANG_DEFAULT'));
        $helper = new HelperForm();
        $helper->show_toolbar = true;
        $helper->toolbar_scroll = true;
        $helper->table = $this->table;
        $helper->default_form_language = $lang->id;
        $helper->module = $this;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ?
            Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submit_'.$this->name;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).
            '&configure='.$this->name.
            '&tab_module='.$this->tab.
            '&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->fields_value[
            'CHANGEORDERINDEX_OVERRIDE_ENABLED'
            ] = Configuration::get('CHANGEORDERINDEX_OVERRIDE_ENABLED');
        $helper->fields_value[
            'CHANGEORDERINDEX_PFX'
            ] = Configuration::get('CHANGEORDERINDEX_PFX');
        $helper->fields_value[
            'CHANGEORDERINDEX_PFX_SEPARATOR'
            ] = Configuration::get('CHANGEORDERINDEX_PFX_SEPARATOR');
        
        return $helper->generateForm(array($fields_form));
    }

    protected function postProcess()
    {
        $pfx = Tools::substr(
            Tools::strtoupper(
                preg_replace(
                    "/[^a-zA-Z0-9]+/",
                    "",
                    Tools::getValue('CHANGEORDERINDEX_PFX')
                )
            ),
            0,
            3
        );

        if (Configuration::updateValue(
            'CHANGEORDERINDEX_OVERRIDE_ENABLED',
            (bool)Tools::getValue('CHANGEORDERINDEX_OVERRIDE_ENABLED')
        ) &&
        Configuration::updateValue(
            'CHANGEORDERINDEX_PFX',
            $pfx
        ) &&
        Configuration::updateValue(
            'CHANGEORDERINDEX_PFX_SEPARATOR',
            (bool)Tools::getValue('CHANGEORDERINDEX_PFX_SEPARATOR')
        )
            ) {
            return true;
        } else {
            return false;
        }
    }
}
