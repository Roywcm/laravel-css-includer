<?php

namespace Roywulms\LaravelMailCssIncluder;

class ExternalCssPlugin implements \Swift_Events_SendListener
{

    /**
     * @param Swift_Events_SendEvent $evt
     */
    public function beforeSendPerformed(\Swift_Events_SendEvent $evt)
    {
        $message = $evt->getMessage();
        $message->setBody($this->includeExternalStylesheets($message->getBody()), 'text/html');
    }

    /**
     * @param $message
     * @return string
     */
    public function includeExternalStylesheets($message)
    {
        preg_match_all('/<link[^>]+>/mi', $message, $matches);
        $linkElements = $matches[0];
        $count = count($linkElements);

        if ($linkElements) {
            foreach ($linkElements as $i => $linkElement) {
                $cssContent = $this->getCssContent($linkElement);
                $message = str_replace($linkElement, '<style type="text/css">' . $cssContent . '</style>', $message);
            }
        }
        return $message;
    }

    /**
     * @param $linkElement
     * @return string
     */

    public function getCssContent($linkElement)
    {
        // load data from html element
        preg_match_all("/href=['\"]([^'\"]+)['\"]/", $linkElement, $matches);
        $absUrl = $matches[1][0];

        $cssContent = @file_get_contents($absUrl);

        if (!$cssContent) {
            trigger_error('Error loading stylesheet from ' . $absUrl . '--' . getcwd(), E_USER_NOTICE);
        }

        return $cssContent;
    }

    /**
     * Do nothing
     *
     * @param Swift_Events_SendEvent $evt
     */
    public function sendPerformed(\Swift_Events_SendEvent $evt)
    {
        // Do Nothing
    }
}
