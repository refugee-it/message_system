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
 * @file $/web/libraries/message_management.inc.php
 * @author Stephan Kreutzer
 * @since 2016-07-25
 */



require_once(dirname(__FILE__)."/database.inc.php");



define("MESSAGE_STATUS_UNKNOWN", 0);
define("MESSAGE_STATUS_ACTIVE", 1);
define("MESSAGE_STATUS_TRASHED", 2);



function GetMessages()
{
    if (Database::Get()->IsConnected() !== true)
    {
        return -1;
    }

    $messages = Database::Get()->QueryUnsecure("SELECT `id`,\n".
                                               "    `owner_name`,\n".
                                               "    `text`,\n".
                                               "    `status`,\n".
                                               "    `datetime_created`\n".
                                               "FROM `".Database::Get()->GetPrefix()."messages`\n".
                                               "WHERE 1\n".
                                               "ORDER BY `datetime_created` ASC");

    if (is_array($messages) !== true)
    {
        return -2;
    }

    return $messages;
}

function InsertNewMessage($ownerName, $message)
{
    /** @todo Check for empty parameters. */

    if (Database::Get()->IsConnected() !== true)
    {
        return -1;
    }

    $id = Database::Get()->Insert("INSERT INTO `".Database::Get()->GetPrefix()."messages` (`id`,\n".
                                  "    `owner_name`,\n".
                                  "    `text`,\n".
                                  "    `status`,\n".
                                  "    `datetime_created`)\n".
                                  "VALUES (?, ?, ?, ".MESSAGE_STATUS_ACTIVE.", NOW())\n",
                                  array(NULL, $ownerName, $message),
                                  array(Database::TYPE_NULL, Database::TYPE_STRING, Database::TYPE_STRING));

    if ($id <= 0)
    {
        return -2;
    }

    return $id;
}

function DeleteMessage($id)
{
    if (is_numeric($id) !== true)
    {
        return -1;
    }

    if (Database::Get()->IsConnected() !== true)
    {
        return -2;
    }

    $result = Database::Get()->Execute("UPDATE `".Database::Get()->GetPrefix()."messages`\n".
                                       "SET `status`=".MESSAGE_STATUS_TRASHED."\n".
                                       "WHERE `id`=?",
                                       array($id),
                                       array(Database::TYPE_INT));

    if ($result === true)
    {
        return 0;
    }
    else
    {
        return -3;
    }
}

function ClearMessageTrash()
{
    if (Database::Get()->IsConnected() !== true)
    {
        return -1;
    }

    $result = Database::Get()->ExecuteUnsecure("DELETE FROM `".Database::Get()->GetPrefix()."messages`\n".
                                               "WHERE `status`=".MESSAGE_STATUS_TRASHED);

    if ($result === true)
    {
        return 0;
    }
    else
    {
        return -2;
    }
}



?>
