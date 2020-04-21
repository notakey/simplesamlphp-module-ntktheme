<?php

/**
 * Support the htmlinject hook, which allows modules to change header, pre and post body on all pages.
 */
$this->data['htmlinject'] = array(
    'htmlContentPre' => array(),
    'htmlContentPost' => array(),
    'htmlContentHead' => array(),
);


$jquery = array();
if (array_key_exists('jquery', $this->data)) $jquery = $this->data['jquery'];

if (array_key_exists('pageid', $this->data)) {
    $hookinfo = array(
        'pre' => &$this->data['htmlinject']['htmlContentPre'],
        'post' => &$this->data['htmlinject']['htmlContentPost'],
        'head' => &$this->data['htmlinject']['htmlContentHead'],
        'jquery' => &$jquery,
        'page' => $this->data['pageid']
    );

    SimpleSAML\Module::callHooks('htmlinject', $hookinfo);
}
// - o - o - o - o - o - o - o - o - o - o - o - o -

/**
 * Do not allow to frame simpleSAMLphp pages from another location.
 * This prevents clickjacking attacks in modern browsers.
 *
 * If you don't want any framing at all you can even change this to
 * 'DENY', or comment it out if you actually want to allow foreign
 * sites to put simpleSAMLphp in a frame. The latter is however
 * probably not a good security practice.
 */
header('X-Frame-Options: SAMEORIGIN');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0" />
    <script type="text/javascript" src="/<?php echo $this->data['baseurlpath']; ?>/resources/script.js?ver=<?php echo urlencode($this->configuration->getVersion()); ?>"></script>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0" />
        <script type="text/javascript" src="/<?php echo $this->data['baseurlpath']; ?>/resources/script.js"></script>

        <meta name="robots" content="noindex, nofollow" />
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title><?php if (array_key_exists('header', $this->data)) {
                    echo $this->data['header'];
                } else {
                    echo 'simpleSAMLphp';
                } ?></title>

        <link rel="stylesheet" type="text/css" href="/<?php echo $this->data['baseurlpath']; ?>module/notakey/resources/default.css?ver=<?php echo urlencode($this->configuration->getVersion()); ?>" />

        <?php if ($this->configuration->hasValue('customcss')) { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo $this->configuration->getValue('customcss'); ?>?ver=<?php echo urlencode($this->configuration->getVersion()); ?>" />
        <?php } ?>

        <?php if ($this->configuration->hasValue('favicon')) { ?>
            <link rel="icon" href="<?php echo $this->configuration->getValue('favicon'); ?>" sizes="32x32">
            <link rel="icon" href="<?php echo $this->configuration->getValue('favicon'); ?>" sizes="192x192" />
            <link rel="apple-touch-icon-precomposed" href="<?php echo $this->configuration->getValue('favicon'); ?>">
        <?php } else { ?>
            <link rel="icon" href="/<?php echo $this->data['baseurlpath']; ?>module/notakey/resources/favicon.png" sizes="32x32">
            <link rel="icon" href="/<?php echo $this->data['baseurlpath']; ?>module/notakey/resources/favicon.png" sizes="192x192" />
            <link rel="apple-touch-icon-precomposed" href="/<?php echo $this->data['baseurlpath']; ?>module/notakey/resources/favicon.png">
        <?php
        }
        $jquery['css'] = true;
        if (!empty($jquery)) {
            $version = '1.8';
            if (array_key_exists('version', $jquery))
                $version = $jquery['version'];

            if ($version == '1.8') {
                if (isset($jquery['core']) && $jquery['core'])
                    echo ('<script type="text/javascript" src="/' . $this->data['baseurlpath'] . 'resources/jquery-1.8.js"></script>' . "\n");

                if (isset($jquery['ui']) && $jquery['ui'])
                    echo ('<script type="text/javascript" src="/' . $this->data['baseurlpath'] . 'resources/jquery-ui-1.8.js"></script>' . "\n");

                if (isset($jquery['css']) && $jquery['css'])
                    echo ('<link rel="stylesheet" media="screen" type="text/css" href="/' . $this->data['baseurlpath'] .
                        'resources/uitheme1.8/jquery-ui.css" />' . "\n");
            }
        }

        if (isset($this->data['clipboard.js'])) {
            echo '<script type="text/javascript" src="/' . $this->data['baseurlpath'] .
                'resources/clipboard.min.js"></script>' . "\n";
        }

        if (!empty($this->data['htmlinject']['htmlContentHead'])) {
            foreach ($this->data['htmlinject']['htmlContentHead'] as $c) {
                echo $c;
            }
        }

        if ($this->isLanguageRTL()) {
        ?>
            <link rel="stylesheet" type="text/css" href="/<?php echo $this->data['baseurlpath']; ?>resources/default-rtl.css" />
        <?php
        }
        ?>
        <?php
        if (array_key_exists('head', $this->data)) {
            echo '<!-- head -->' . $this->data['head'] . '<!-- /head -->';
        }
        ?>
    </head>
    <?php
    $onLoad = '';
    if (array_key_exists('autofocus', $this->data)) {
        $onLoad .= 'SimpleSAML_focus(\'' . $this->data['autofocus'] . '\');';
    }
    if (isset($this->data['onLoad'])) {
        $onLoad .= $this->data['onLoad'];
    }

    if ($onLoad !== '') {
        $onLoad = ' onload="' . $onLoad . '"';
    }
    ?>
    <body<?php echo $onLoad; ?> data-languages="[]">

        <nav class="navbar navbar-toggleable-md navbar-dark">
            <?php

            $includeLanguageBar = TRUE;
            if (!empty($_POST))
                $includeLanguageBar = FALSE;
            if (isset($this->data['hideLanguageBar']) && $this->data['hideLanguageBar'] === TRUE)
                $includeLanguageBar = FALSE;

            if ($includeLanguageBar) {

                $languages = $this->getLanguageList();
                if (count($languages) > 1) {
                    echo '<div id="languagebar">';
                    $langnames = array(
                        'no' => 'Bokmål', // Norwegian Bokmål
                        'nn' => 'Nynorsk', // Norwegian Nynorsk
                        'se' => 'Sámegiella', // Northern Sami
                        'da' => 'Dansk', // Danish
                        'en' => 'English',
                        'de' => 'Deutsch', // German
                        'sv' => 'Svenska', // Swedish
                        'fi' => 'Suomeksi', // Finnish
                        'es' => 'Español', // Spanish
                        'fr' => 'Français', // French
                        'it' => 'Italiano', // Italian
                        'nl' => 'Nederlands', // Dutch
                        'lb' => 'Lëtzebuergesch', // Luxembourgish
                        'cs' => 'Čeština', // Czech
                        'sl' => 'Slovenščina', // Slovensk
                        'lt' => 'Lietuvių kalba', // Lithuanian
                        'hr' => 'Hrvatski', // Croatian
                        'hu' => 'Magyar', // Hungarian
                        'pl' => 'Język polski', // Polish
                        'pt' => 'Português', // Portuguese
                        'pt-br' => 'Português brasileiro', // Portuguese
                        'ru' => 'русский язык', // Russian
                        'et' => 'eesti keel', // Estonian
                        'tr' => 'Türkçe', // Turkish
                        'el' => 'ελληνικά', // Greek
                        'ja' => '日本語', // Japanese
                        'zh' => '简体中文', // Chinese (simplified)
                        'zh-tw' => '繁體中文', // Chinese (traditional)
                        'ar' => 'العربية', // Arabic
                        'he' => 'עִבְרִית', // Hebrew
                        'id' => 'Bahasa Indonesia', // Indonesian
                        'sr' => 'Srpski', // Serbian
                        'lv' => 'Latviešu', // Latvian
                        'ro' => 'Românește', // Romanian
                        'eu' => 'Euskara', // Basque
                        'af' => 'Afrikaans', // Afrikaans
                    );

                    $textarray = array();
                    foreach ($languages as $lang => $current) {
                        $lang = strtolower($lang);
                        if ($current) {
                            $textarray[] = $langnames[$lang];
                        } else {
                            $textarray[] = '<a href="' . htmlspecialchars(\SimpleSAML\Utils\HTTP::addURLParameters(\SimpleSAML\Utils\HTTP::getSelfURL(), array($this->getTranslator()->getLanguage()->getLanguageParameterName() => $lang))) . '">' .
                                $langnames[$lang] . '</a>';
                        }
                    }
                    echo join(' | ', $textarray);
                    echo '</div>';
                }
            }


            ?>
            <!-- Brand -->
            <a class="navbar-brand mr-auto" href="/<?php echo $this->data['baseurlpath']; ?>">
                <img id="brandLogo" src="/<?php echo $this->data['baseurlpath']; ?>module/notakey/resources/notakey-white-nobg.svg" height="30" alt="Notakey">
            </a>
        </nav>

        <div class="container-fluid">
            <div class="jumbotron jumbotron-fluid row">
                <div class="container">
                    <h1 class="display-3"><?php echo ($this->configuration->hasValue('webapptitle') ? $this->configuration->getValue('webapptitle') : 'SSO Login'); ?></h1>
                </div>
            </div>
            <!--
		<xmp>
		<?php // print_r($this);
        ?>
		</xmp>
		-->
            <div class="container">
                <h1 class="section-header" id="main-section-header"></h1>
                <hr>
                <?php

                if (!empty($this->data['htmlinject']['htmlContentPre'])) {
                    foreach ($this->data['htmlinject']['htmlContentPre'] as $c) {
                        echo $c;
                    }
                }
