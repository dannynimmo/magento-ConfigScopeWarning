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

            if($overrides->websites) {
                $title = $this->__('Websites') . ': ';
                foreach($overrides->websites as $website) {
                    $title .= $website . ', ';
                }
                $title = rtrim($title, ', ');
            }

            if(isset($title)) {
                $title .= '; ';
            } else {
                $title = '';
            }

            if($overrides->stores) {
                $title .= $this->__('Stores') . ': ';
                foreach($overrides->stores as $store) {
                    $title .= $store . ', ';
                }
                $title = rtrim($title, ', ');
            }

            $markup = '<i class="scope-warning" title="' . $title . '">' . $this->__('Scope warning') . '</i>';
            return $markup;
        }
        return '';
    }

}
