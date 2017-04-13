<?php
/**
 * @package     EtdBniFeedback
 *
 * @version     1.0.0
 * @copyright   Copyright (C) 2016 ETD Solutions. Tous droits réservés.
 * @license     http://etd-solutions.com/LICENSE
 * @author      ETD Solutions http://etd-solutions.com
 */

namespace EtdSolutions\EtdBniFeedback\Renderer;

use EtdSolutions\Acl\Acl;
use EtdSolutions\User\User;
use EtdSolutions\Utility\DateUtility;
use EtdSolutions\Utility\LocaleUtility;
use EtdSolutions\Utility\PriceUtility;
use EtdSolutions\Utility\RequireJSUtility;
use Joomla\Application\AbstractApplication;
use EtdSolutions\Language\LanguageFactory;
use Joomla\Database\DatabaseDriver;
use Joomla\DI\Container;
use Joomla\Language\Text;
use Joomla\Utilities\ArrayHelper;

class TwigExtension extends \Twig_Extension {

    /**
     * L'objet application
     *
     * @var    AbstractApplication
     */
    private $app;

    /**
     * Le container DI
     *
     * @var    Container
     */
    private $container;

    private $users = [];

    /**
     * Constructeur
     *
     * @param AbstractApplication $app       L'objet application.
     * @param Container           $container Le container DI.
     */
    public function __construct(AbstractApplication $app, Container $container) {

        $this->app       = $app;
        $this->container = $container;
    }

    /**
     * Retourne le nom de l'extension
     *
     * @return  string  Le nom de l'extension
     */
    public function getName() {

        return 'etd-bnifeedback';
    }

    /**
     * Retourne une liste de fonctions à ajouter à la liste existante.
     *
     * @return  \Twig_SimpleFunction[]  Un tableau d'instances de \Twig_SimpleFunction.
     */
    public function getFunctions() {

        return [
            new \Twig_SimpleFunction('getUserAvatar', [$this, 'getUserAvatar'], ["is_safe" => ["html"]])
        ];

    }

    /**
     * Renvoi le code HTML de l'avatar dans la bonne taille.
     *
     * @param int    $user_id    L'identifiant de l'utilisateur.
     * @param string $size       La taille de l'avatar.
     *
     * @return string URI vers l'avatar.
     */
    public function getUserAvatar($user_id , $size = 'sm') {

        $user     = $this->getUser($user_id);
	    $initials = "";

	    if ($user) {
		    foreach (explode(" ", $user->name, 2) as $w) {
			    $initials .= strtoupper($w[0]);
		    }
	    }

        $img_path = "images/user/" . $user_id . "_" . $size . ".jpg";
        $img_src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";
        if (file_exists(JPATH_MEDIA . "/" . $img_path)) {
            $img_src = $this->app->get('uri.base.path') . $img_path;
        }

        $html = [];

        $html[] = '<div class="avatar avatar-' . $size . '">';
        $html[] = '<div class="avatar-img" style="background-image:url(' .$img_src . ');"></div>';
        $html[] = '<div class="avatar-initials">' . $initials . '</div>';
        $html[] = '</div>';

        return implode($html);

    }

    protected function getUser($user_id) {

        if (!isset($this->users[$user_id])) {
            $db = $this->container->get('db');
            $this->users[$user_id] = $db->setQuery("SELECT * FROM #__users WHERE id = " . (int) $user_id)
                                        ->loadObject();
        }

        return $this->users[$user_id];

    }

}
