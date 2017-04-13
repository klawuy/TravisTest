<?php
/**
 * @package     EtdBniFeedback
 *
 * @version     1.0.0
 * @copyright   Copyright (C) 2016 ETD Solutions. Tous droits réservés.
 * @license     http://etd-solutions.com/LICENSE
 * @author      ETD Solutions http://etd-solutions.com
 */

namespace EtdSolutions\EtdBniFeedback\Application;

use EtdSolutions\Application\Web;

class Front extends Web {

    /**
     * @var string Le layout pour afficher les erreurs.
     */
    protected $errorLayout = 'error_front';

}