<?php
/* Copyright (C) 2014-2017  Stephan Kreutzer
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
 * @file $/web/messages.php
 * @brief Lists all messages.
 * @author Stephan Kreutzer
 * @since 2014-06-08
 */



require_once("./libraries/https.inc.php");
require_once("./libraries/session.inc.php");

require_once("./libraries/languagelib.inc.php");
require_once(getLanguageFile("messages"));

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n".
     "<!DOCTYPE html\n".
     "    PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n".
     "    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n".
     "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"".getCurrentLanguage()."\" lang=\"".getCurrentLanguage()."\">\n".
     "    <head>\n".
     "        <meta http-equiv=\"content-type\" content=\"application/xhtml+xml; charset=UTF-8\"/>\n".
     "        <title>".LANG_PAGETITLE."</title>\n".
     "        <link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"mainstyle.css\"/>\n".
     "        <link rel=\"stylesheet\" type=\"text/css\" media=\"print\" href=\"mainstyle_print.css\"/>\n".
     "    </head>\n".
     "    <body>\n".
     "        <div class=\"mainbox\">\n".
     "          <div class=\"mainbox_header\">\n".
     "            <h1 class=\"mainbox_header_h1\">".LANG_HEADER."</h1>\n".
     "          </div>\n".
     "          <div class=\"mainbox_body\">\n".
     "            <table>\n".
     "              <thead>\n".
     "                <tr>\n".
     "                  <th>".LANG_TABLECOLUMNCAPTION_ID."</th>\n".
     "                  <th>".LANG_TABLECOLUMNCAPTION_DATETIMECREATED."</th>\n".
     "                  <th>".LANG_TABLECOLUMNCAPTION_OWNERNAME."</th>\n".
     "                  <th>".LANG_TABLECOLUMNCAPTION_TEXT."</th>\n".
     "                  <th class=\"noprint\">".LANG_TABLECOLUMNCAPTION_ACTION."</th>\n".
     "                </tr>\n".
     "              </thead>\n".
     "              <tbody>\n";

require_once("./libraries/message_management.inc.php");

$messages = GetMessages();

if (is_array($messages) === true)
{
    foreach ($messages as $message)
    {
        if ((int)$message['status'] != MESSAGE_STATUS_ACTIVE)
        {
            continue;
        }

        echo "                <tr>\n".
             "                  <td>".htmlspecialchars($message['id'], ENT_COMPAT | ENT_HTML401, "UTF-8")."</td>\n".
             "                  <td>".htmlspecialchars($message['datetime_created'], ENT_COMPAT | ENT_HTML401, "UTF-8")."</td>\n".
             "                  <td>".htmlspecialchars($message['owner_name'], ENT_COMPAT | ENT_HTML401, "UTF-8")."</td>\n".
             "                  <td>".htmlspecialchars($message['text'], ENT_COMPAT | ENT_HTML401, "UTF-8")."</td>\n".
             "                  <td class=\"noprint\"><a href=\"message_delete.php?id=".((int)$message['id'])."\" class=\"noprint\">".LANG_LINKCAPTION_MESSAGEDELETE."</a></td>\n".
             "                </tr>\n";
    }
}

echo "              </tbody>\n".
     "            </table>\n".
     "            <a href=\"index.php\" class=\"noprint\">".LANG_LINKCAPTION_MAINPAGE."</a>\n".
     "          </div>\n".
     "        </div>\n".
     "        <div class=\"footerbox noprint\">\n".
     "          <a href=\"license.php\" class=\"footerbox_link noprint\">".LANG_LICENSE."</a>\n".
     "        </div>\n".
     "    </body>\n".
     "</html>\n";




?>
