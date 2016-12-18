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
 * @file $/web/message_delete.php
 * @brief Moves a message into the trash.
 * @author Stephan Kreutzer
 * @since 2016-12-13
 */



require_once("./libraries/https.inc.php");

session_start();

if (isset($_SESSION['user_id']) !== true)
{
    exit(-1);
}

$id = null;

if (isset($_GET['id']) === true)
{
    if (is_numeric($_GET['id']) === true)
    {
        $id = (int)$_GET['id'];
    }
}

$clearTrash = null;

if (isset($_GET['cleartrash']) === true)
{
    $clearTrash = true;
}

if ($id == null &&
    $clearTrash == null)
{
    exit(-2);
}

require_once("./libraries/languagelib.inc.php");
require_once(getLanguageFile("message_delete"));

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n".
     "<!DOCTYPE html\n".
     "    PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n".
     "    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n".
     "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"".getCurrentLanguage()."\" lang=\"".getCurrentLanguage()."\">\n".
     "  <head>\n".
     "    <meta http-equiv=\"content-type\" content=\"application/xhtml+xml; charset=UTF-8\"/>\n".
     "    <title>".LANG_PAGETITLE."</title>\n".
     "    <link rel=\"stylesheet\" type=\"text/css\" href=\"mainstyle.css\"/>\n".
     "  </head>\n".
     "  <body>\n".
     "    <div class=\"mainbox\">\n".
     "      <div class=\"mainbox_header\">\n".
     "        <h1 class=\"mainbox_header_h1\">".LANG_HEADER."</h1>\n".
     "      </div>\n".
     "      <div class=\"mainbox_body\">\n";

require_once("./libraries/message_management.inc.php");

if ($clearTrash != null)
{
    $result = ClearMessageTrash();

    if ($result === 0)
    {
        echo "        <p>\n".
            "          <span class=\"success\">".LANG_OPERATIONSUCCEEDED."</span>\n".
            "        </p>\n";
    }
    else
    {
        echo "        <p>\n".
            "          <span class=\"error\">".LANG_OPERATIONFAILED."</span>\n".
            "        </p>\n";
    }
}
else
{
    $result = DeleteMessage($id);

    if ($result === 0)
    {
        echo "        <p>\n".
            "          <span class=\"success\">".LANG_OPERATIONSUCCEEDED."</span>\n".
            "        </p>\n";
    }
    else
    {
        echo "        <p>\n".
            "          <span class=\"error\">".LANG_OPERATIONFAILED."</span>\n".
            "        </p>\n";
    }
}

echo "        <a href=\"messages.php\">".LANG_BACK."</a>\n".
     "      </div>\n".
     "    </div>\n".
     "    <div class=\"footerbox\">\n".
     "      <a href=\"license.php\" class=\"footerbox_link\">".LANG_LICENSE."</a>\n".
     "    </div>\n".
     "  </body>\n".
     "</html>\n".
     "\n";


?>
