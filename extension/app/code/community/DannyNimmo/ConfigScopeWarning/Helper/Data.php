<?php

class DannyNimmo_ConfigScopeWarning_Helper_Data extends Mage_Core_Helper_Abstract
{

    private $read;
    private $configPath;

    public function __construct() {
        $this->read = Mage::getSingleton('core/resource')->getConnection('core_read');
    }

    private function getOverrides() {
        $overrides = new stdClass();
        $overrides->websites = array();
        $overrides->stores = array();

        $query = $this->read->select()
            ->from($this->read->getTableName('core_config_data'), array('scope', 'scope_id'))
            ->where('path = ?', $this->configPath)
            ->where('scope != "default"');
        $overrides_data = $this->read->fetchAll($query);

        foreach($overrides_data as $override) {
            switch($override['scope']) {
                case 'websites':
                    $overrides->websites[] = Mage::app()->getWebsite($override['scope_id'])->getName();
                    break;
                case 'stores':
                    $overrides->stores[] = Mage::app()->getStore($override['scope_id'])->getName();
                    break;
            }
        }

        if(!count($overrides->websites) && !count($overrides->stores)) {
            $overrides = null;
        }

        return $overrides;
    }

    public function setConfigPath($configPath) {
        $this->configPath = $configPath;
        return $this;
    }

    public function getScopeWarning() {
        $overrides = $this->getOverrides();
        if($overrides) {

            $message = '<h6>'. $this->__('Config Overridden') . '</h6>';

            $message .= '<dl>';
            if($overrides->websites) {
                $message .= '<dt>' . $this->__('Websites') . '</dt>';
                foreach($overrides->websites as $website) {
                    $message .= '<dd>' . $website . '</dd>';
                }
            }
            if($overrides->stores) {
                $message .= '<dt>' . $this->__('Stores') . '</dt>';
                foreach($overrides->stores as $store) {
                    $message .= '<dd>' . $store . '</dd>';
                }
            }
            $message .= '</dl>';

            $markup = '<div class="scope-warning"><div class="scope-warning-message">'.$message.'</div></div>';
            return $markup;
        }
        return '';
    }

}
