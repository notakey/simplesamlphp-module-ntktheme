<?php

declare(strict_types=1);

namespace SimpleSAML\Module\ntktheme;

use SimpleSAML\Configuration;
use SimpleSAML\Locale\Translate;
use SimpleSAML\XHTML\TemplateControllerInterface;
use Twig\Environment;

/**
 * Notakey theme controller.
 *
 * Use as 'theme.controller' => '\SimpleSAML\Module\ntktheme\NtkThemeController' in config.php.
 */
class NtkThemeController implements TemplateControllerInterface
{
    /**
     * The configuration to use in this template.
     */
    private Configuration $config;

    private string $lang;

    private string $default_lang;

    public function __construct()
    {
        $this->config = Configuration::getInstance();
        $translator = new Translate($this->config);
        $this->lang = $translator->getLanguage()->getLanguage();
        $this->default_lang = $translator->getLanguage()->getDefaultLanguage();
    }

    /**
     * Modify the twig environment after its initialization (e.g. add filters or extensions).
     *
     * @param \Twig\Environment $twig The current twig environment.
     */
    public function setUpTwig(Environment &$twig): void
    {
        $twig->addGlobal('favicon', $this->config->getOptionalString('favicon', null));
        $twig->addGlobal('customcss', $this->config->getOptionalString('customcss', null));
        $twig->addGlobal('webapptitle', $this->geti18nValue('webapptitle'));
        $twig->addGlobal('footer_tagline', $this->geti18nValue('footer.tagline'));
        $twig->addGlobal('buildyear', date("Y", time()));
    }

    /**
     * Get a config value that may be a string or an array of per-language strings.
     */
    private function geti18nValue(string $confKey): ?string
    {
        if (!$this->config->hasValue($confKey)) {
            return null;
        }

        $cfgvar = $this->config->getValue($confKey);
        if (is_array($cfgvar)) {
            if (isset($cfgvar[$this->lang])) {
                return strval($cfgvar[$this->lang]);
            }

            if (isset($cfgvar[$this->default_lang])) {
                return strval($cfgvar[$this->default_lang]);
            }

            return null;
        }

        return strval($cfgvar);
    }

    /**
     * Modify the data passed to the template right before it is displayed.
     *
     * @param array $data The current data used by the template.
     */
    public function display(array &$data): void
    {
    }
}
