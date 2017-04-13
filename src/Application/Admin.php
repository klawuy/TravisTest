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
use EtdSolutions\User\User;

class Admin extends Web {

    /**
     * Méthode pour autoriser la connexion de l'utilisateur en
     * dernier lieu (après vérification du mot de passe).
     *
     * @param User $user
     *
     * @return bool
     */
    protected function authoriseLogin($user) {

        return $user->authorise('app', 'login');

    }

}