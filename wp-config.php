<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link https://fr.wordpress.org/support/article/editing-wp-config-php/ Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'smiters_prod' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ']Y,6;YHRP%nzNs|!$@vwiQ$w#T5y:?M2B-ndkGB$i?H4HpP=YT:l81;X67l}&I@0' );
define( 'SECURE_AUTH_KEY',  'J&LoSkGbqng~/&.3`Xk{z1FG2)WiH^?BDY_gV[kx%SA2tuks8!aK-:5CE77rn6Y2' );
define( 'LOGGED_IN_KEY',    '=Q-,!b2Fu<;Ia3)p}K23/wNxWeBHV/iuIq$U<?Gs=2,zVd*g;%b|*H;%5&;;&@<)' );
define( 'NONCE_KEY',        ':r,pD^!v[OWq}koHDWx4UO+2X+DAqyYjr35PH4;$WCfD@rP__` u#GgFfunmhXj!' );
define( 'AUTH_SALT',        'HE=xEgE?X#0DBL[;|i^I{BfKNq}=l9COLPYQ&bRNs~qYVU!(}8c:7J2o_E>fGV]%' );
define( 'SECURE_AUTH_SALT', 'j1m%%&1p.<n#8!uXwWo1q6~1To8Jhm<2T+0P2N=Tb,[bpG(??}J2%eOrL%M&C}Ty' );
define( 'LOGGED_IN_SALT',   '1UY81%u!=i,BP0/}xd#7ArR2lFtxjC`h$y {b&sd8!dqEY>-/_*v}`%i4pMqPFvv' );
define( 'NONCE_SALT',       '[T=qNylnt%zLnfM-[/kDen K]4;)!H;%[{Zw$YVyw)(9mtQchMIM4]<[#$vkMmIc' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'smiters_';

/**
 * Pour les développeurs et développeuses : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs et développeuses d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur la documentation.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
