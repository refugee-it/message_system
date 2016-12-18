<?php
/* Copyright (C) 2012-2016  Stephan Kreutzer
 *
 * This file is part of message system for refugee-it.de.
 *
 * message system for refugee-it.de is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License version 3 or any later version,
 * as published by the Free Software Foundation.
 *
 * message system for refugee-it.de is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License 3 for more details.
 *
 * You should have received a copy of the GNU Affero General Public License 3
 * along with message system for refugee-it.de. If not, see <http://www.gnu.org/licenses/>.
 */
/**
 * @file $/web/libraries/user_management.inc.php
 * @author Stephan Kreutzer
 * @since 2012-06-02
 */



require_once(dirname(__FILE__)."/database.inc.php");
require_once(dirname(__FILE__)."/user_defines.inc.php");



function insertNewUser($name, $password, $email, $role)
{
    /** @todo Check for empty $name, $password, $email or $role. */

    if (Database::Get()->IsConnected() !== true)
    {
        return -1;
    }

    if (Database::Get()->BeginTransaction() !== true)
    {
        return -2;
    }

    $salt = md5(uniqid(rand(), true));
    $password = hash('sha512', $salt.$password);

    $id = Database::Get()->Insert("INSERT INTO `".Database::Get()->GetPrefix()."users` (`id`,\n".
                                  "    `name`,\n".
                                  "    `e_mail`,\n".
                                  "    `salt`,\n".
                                  "    `password`,\n".
                                  "    `role`)\n".
                                  "VALUES (?, ?, ?, ?, ?, ?)\n",
                                  array(NULL, $name, $email, $salt, $password, $role),
                                  array(Database::TYPE_NULL, Database::TYPE_STRING, Database::TYPE_STRING, Database::TYPE_STRING, Database::TYPE_STRING, Database::TYPE_INT));

    if ($id <= 0)
    {
        Database::Get()->RollbackTransaction();
        return -4;
    }

    if (Database::Get()->CommitTransaction() === true)
    {
        return $id;
    }

    return -7;
}

function getUserByName($name)
{
    /** @todo Check for empty $name, $password, $email or $role. */

    if (Database::Get()->IsConnected() !== true)
    {
        return -1;
    }

    $user = Database::Get()->Query("SELECT `id`,\n".
                                   "    `salt`,\n".
                                   "    `password`,\n".
                                   "    `role`\n".
                                   "FROM `".Database::Get()->GetPrefix()."users`\n".
                                   "WHERE `name` LIKE ?\n",
                                   array($name),
                                   array(Database::TYPE_STRING));

    if (is_array($user) !== true)
    {
        return -2;
    }

    return $user;
}



?>
