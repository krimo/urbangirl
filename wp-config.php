<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur 
 * {@link http://codex.wordpress.org/Editing_wp-config.php Modifier
 * wp-config.php} (en anglais). C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'krimo_wp');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'krimo_admin');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'Veniversum511');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '-!]tjbo9?4(P$-z]$+b&uII0Dh=N09I>nPk?)MRq;PDp!-j|t*]ix.|<;8Sfc>X[');
define('SECURE_AUTH_KEY',  ';J3Z*Sc>4qIH-[P%$9XFm&f^~7:cx1<?~H5<Nv3a)xe0CgzN AO-+}U7|lG^OTX6');
define('LOGGED_IN_KEY',    'NSTZ aJ9NQB`0lpFQ|zuJv#~OmRmV?{dE_8;Uh9B;>t<ic*jzU#3-me&7gAL{ 7j');
define('NONCE_KEY',        'E5Wihv>4&iO8zup;Z{aNq@`5Y?W93!/T5~PK)P4Ixl4r[:}HSZHYSNLW9r[wEaih');
define('AUTH_SALT',        'rL6sRBL5VAD+ )bz&=3HKYB//`)7/syxy}ci|cG6y5wRpx!z-NC4-m>IEylL >@X');
define('SECURE_AUTH_SALT', 'WVM0Spu8#X:IK0X hD)]tzP2tM+U*:lZmeLTb|$O?7b7.-mU-)+Z+#Qb#0|F-uMt');
define('LOGGED_IN_SALT',   'q>E!Ph1]P6%~@a7-V83Yh+V|mKEP6a+64|?<RWX=8|;8YwrsiIzIG|3ba*|h|N?U');
define('NONCE_SALT',       ' l4/V>#`2JtGU  3?p}OH;RnDTP} &|D.2+@YXG=Uc3~Gim%b8/Ue)BB-?DK^[Ef');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wp_';

/**
 * Langue de localisation de WordPress, par défaut en Anglais.
 *
 * Modifiez cette valeur pour localiser WordPress. Un fichier MO correspondant
 * au langage choisi doit être installé dans le dossier wp-content/languages.
 * Par exemple, pour mettre en place une traduction française, mettez le fichier
 * fr_FR.mo dans wp-content/languages, et réglez l'option ci-dessous à "fr_FR".
 */
define('WPLANG', 'fr_FR');
/** 
 * Pour les développeurs : le mode deboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 */ 
define('WP_DEBUG', false);


/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');