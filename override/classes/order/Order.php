<?php

class Order extends OrderCore
{
    public static function generateReference()
    {
        if (Module::isEnabled('changeorderindex') && (Configuration::get('CHANGEORDERINDEX_OVERRIDE_ENABLED'))) {
            $pfx = Configuration::get('CHANGEORDERINDEX_PFX');
            $pfx_separator = (bool)Configuration::get('CHANGEORDERINDEX_PFX_SEPARATOR');
            $q="SELECT AUTO_INCREMENT
				FROM information_schema.TABLES
				WHERE TABLE_SCHEMA = \"" . _DB_NAME_ . "\"
				AND TABLE_NAME = \"" . _DB_PREFIX_ . "orders\"";
            $refNo = (int) Db::getInstance()->getValue($q);
            if ($pfx != NULL) {
                if ($pfx_separator) {
                    $pfx = $pfx . "-";
                } 
                $refNo = $pfx . $refNo;
            }
                        
            return $refNo;

        } else {

            return parent::generateReference();

        }
    }
}
