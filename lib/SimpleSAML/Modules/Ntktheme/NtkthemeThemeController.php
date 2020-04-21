<?php

namespace SimpleSAML\Modules\Ntktheme;

use SimpleSAML\XHTML\TemplateControllerInterface;

class NtkthemeThemeController implements TemplateControllerInterface
{
    /**
     * Implement to modify the twig environment after its initialization (e.g. add filters or extensions).
     *
     * @param \Twig_Environment $twig The current twig environment.
     *
     * @return void
     */
    public function setUpTwig(\Twig_Environment &$twig)
    {
        $config = \SimpleSAML_Configuration::getInstance();
        if ($config->hasValue('favicon')) {
            $twig->addGlobal('favicon', $config->getValue('favicon'));
        }

        if ($config->hasValue('customcss')) {
            $twig->addGlobal('customcss', $config->getValue('customcss'));
        }

        if ($config->hasValue('webapptitle')) {
            $twig->addGlobal('webapptitle', $config->getValue('webapptitle'));
        }

        if ($config->hasValue('footer.tagline')) {
            $twig->addGlobal('footer_tagline', $config->getValue('footer.tagline'));
        }

        $twig->addGlobal('version', $config->getVersion());

        if (is_readable('/var/simplesamlphp/BUILDTS')) {
            $twig->addGlobal('buildyear', date("Y", @trim(file_get_contents('/var/simplesamlphp/BUILDTS'))));
        } else {
            $twig->addGlobal('buildyear', date("Y", time()));
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
