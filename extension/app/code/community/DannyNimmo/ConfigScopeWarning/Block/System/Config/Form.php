<?php

class DannyNimmo_ConfigScopeWarning_Block_System_Config_Form extends Mage_Adminhtml_Block_System_Config_Form
{

    private $configScopeWarningHelper;

    public function __construct() {
        parent::__construct();
        $this->configScopeWarningHelper = Mage::helper('dannynimmo_configscopewarning');
    }

    protected function _prepareLayout() {
        $this->getLayout()->getBlock('head')->addCss('dannynimmo_configscopewarning/main.css');
        return parent::_prepareLayout();
    }

    public function getScopeLabel($element) {
        $configPath = $this->getSectionCode().'/'.$element->getParent()->getParent()->getName().'/'.$element->getName();
        $this->configScopeWarningHelper = Mage::helper('dannynimmo_configscopewarning')->setConfigPath($configPath);

        $scopeLabel = parent::getScopeLabel($element);
        $warning    = $this->configScopeWarningHelper->getScopeWarning();
        return $scopeLabel . $warning;
    }

}
