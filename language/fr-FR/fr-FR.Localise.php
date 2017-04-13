<?php
/**
 * @package     WebQuin
 *
 * @version     1.0.0
 * @copyright   Copyright (C) 2015 ETD Solutions. Tous droits réservés.
 * @license     http://etd-solutions.com/LICENSE
 * @author      ETD Solutions http://etd-solutions.com
 */

use Joomla\Language\Localise\AbstractLocalise;

/**
 * fr-FR localise class
 */
class Fr_FRLocalise extends AbstractLocalise {

    /**
     * Returns the potential suffixes for a specific number of items
     *
     * @param int $count The number of items.
     *
     * @return array An array of potential suffixes.
     * @since 1.6
     */
    public function getPluralSuffixes($count) {
        if ($count == 0) {
            $return = array('0');
        } elseif ($count == 1) {
            $return = array('1');
        } else {
            $return = array('MORE');
        }
        return $return;
    }

}