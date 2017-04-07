<?php

/**
 * Log the user out and optionally redirect to a page afterwards.
 *
 * LICENSE:
 *
 * This source file is subject to the licensing terms that
 * is available through the world-wide-web at the following URI:
 * http://codecanyon.net/wiki/support/legal-terms/licensing-terms/.
 *
 * @author       Jigowatt <info@jigowatt.co.uk>
 * @author       Matt Gates <info@mgates.me>
 * @copyright    Copyright © 2009-2015 Jigowatt Ltd.
 * @license      http://codecanyon.net/wiki/support/legal-terms/licensing-terms/
 * @link         http://codecanyon.net/item/php-login-user-management/49008
 */

include_once('classes/generic.class.php');

/**
 * Begin removing their existence.
 *
 * Good bye friend :(. Promise you'll come back?!
 */
if (isset($_SESSION['simulation']['username'])) :
    $id = $_SESSION['simulation']['user_id'];
	$params[':id'] = $id;
	$sqlU = "UPDATE `login_users` SET `last_login` = unix_timestamp() WHERE `user_id` = :id ";
    $new = new Generic;
    $new->query($sqlU , $params);
	session_unset();
	session_destroy();
endif;

echo (1);
exit();