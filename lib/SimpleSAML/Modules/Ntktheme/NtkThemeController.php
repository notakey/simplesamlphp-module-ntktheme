<?php

namespace SimpleSAML\Modules\Ntktheme;

use SimpleSAML\XHTML\TemplateControllerInterface;
use SimpleSAML\Configuration;
use SimpleSAML\Locale\Translate;

class NtkThemeController implements TemplateControllerInterface
{

    /**
     * The configuration to use in this template.
     *
     * @var \SimpleSAML\Configuration
     */
    private $config;

    private $lang;

    private $default_lang;

    public function __construct()
    {
        $this->config = Configuration::getInstance();
        $translator = new Translate($this->config);
        $this->lang = $translator->getLanguage()->getLanguage();
        $this->default_lang = $translator->getLanguage()->getDefaultLanguage();
    }

    /**
     * Implement to modify the twig environment after its initialization (e.g. add filters or extensions).
     *
     * @param \Twig_Environment $twig The current twig environment.
     *
     * @return void
     */
    public function setUpTwig(\Twig_Environment &$twig)
    {

        // TODO
        // Use Translator->getLanguage()->getLanguage() to determine language and use hash values to store language specific values

        if ($this->config->hasValue('favicon')) {
            $twig->addGlobal('favicon', $this->config->getValue('favicon'));
        }

        if ($this->config->hasValue('customcss')) {
            $twig->addGlobal('customcss', $this->config->getValue('customcss'));
        }

        $twig->addGlobal('webapptitle', $this->geti18nValue('webapptitle'));

        $twig->addGlobal('footer_tagline', $this->geti18nValue('footer.tagline'));

        $twig->addGlobal('version', $this->config->getVersion());

        $twig->addGlobal('buildyear', date("Y", time()));
    }

    private function geti18nValue($confKey)
    {
        if ($this->config->hasValue($confKey)) {
            $cfgvar = $this->config->getValue($confKey);
            if (is_array($cfgvar)) {
                if (isset($cfgvar[$this->lang])) {
                    return strval($cfgvar[$this->lang]);
                } else {
                    return strval($cfgvar[$this->default_lang]);
                }
            } else {
                return strval($cfgvar);
            }
        }
    }


    /**
     * Implement to add, delete or modify the data passed to the template.
     *
     * This method will be called right before displaying the template.
     *
     * @param array $data The current data used by the template.
     *
     * @return void
     */
    public function display(&$data)
    {
    }
}
