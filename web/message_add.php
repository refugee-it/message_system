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
 * @file $/web/message_add.php
 * @brief Add a message to a person.
 * @author Stephan Kreutzer
 * @since 2016-12-03
 */



require_once("./libraries/https.inc.php");

require_once("./libraries/languagelib.inc.php");
require_once(getLanguageFile("message_add"));

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n".
     "<!DOCTYPE html\n".
     "    PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n".
     "    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n".
     "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"".getCurrentLanguage()."\" lang=\"".getCurrentLanguage()."\">\n".
     "  <head>\n".
     "    <meta http-equiv=\"content-type\" content=\"application/xhtml+xml; charset=UTF-8\"/>\n".
     "    <title>".LANG_PAGETITLE."</title>\n".
     "    <link rel=\"stylesheet\" type=\"text/css\" href=\"bootstrap/css/bootstrap.min.css\"/>\n".
     "    <link rel=\"stylesheet\" type=\"text/css\" href=\"mainstyle_mobile.css\"/>\n".
     "        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"/>\n".
     "  </head>\n".
     "  <body>\n".
     "    <div class=\"mainbox container\">\n";

require_once("./language_selector.inc.php");
echo getHTMLLanguageSelector("message_add.php",
                             "",
                             "",
                             "",
                             "form-group",
                             "form-control",
                             "form-control");

echo "      <div class=\"mainbox_header\">\n".
     "        <h1 class=\"mainbox_header_h1\">".LANG_HEADER."</h1>\n".
     "      </div>\n".
     "      <div class=\"mainbox_body\">\n";

$ownerName = null;

if (isset($_POST['name']) === true)
{
    $ownerName = $_POST['name'];

    if (empty($ownerName) == true)
    {
        $ownerName = null;
    }
}

$message = null;

if (isset($_POST['message']) === true)
{
    $message = $_POST['message'];

    if (empty($message) == true)
    {
        $message = null;
    }
}

$addSuccess = false;

if ($ownerName != null &&
    $message != null)
{
    require_once("./libraries/message_management.inc.php");

    $id = InsertNewMessage($ownerName, $message);

    if ($id > 0)
    {
        $addSuccess = true;

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

if ($addSuccess == false)
{
    echo "        <div>\n".
         "          <form action=\"message_add.php\" method=\"post\">\n".
         "            <fieldset class=\"form-group\">\n".
         "              <label for=\"name\">".LANG_NAMEFIELD_CAPTION."</label>\n".
         "              <input name=\"name\" type=\"text\" size=\"40\" maxlength=\"254\" value=\"".htmlspecialchars($ownerName, ENT_COMPAT | ENT_HTML401, "UTF-8")."\" id=\"name\" class=\"form-control\">\n".
         "              <label for=\"message\">".LANG_MESSAGEFIELD_CAPTION."</label>\n".
         "              <textarea name=\"message\" rows=\"24\" cols=\"80\" id=\"message\" class=\"form-control\">".htmlspecialchars($message, ENT_COMPAT | ENT_HTML401, "UTF-8")."</textarea>\n".
         "              <input type=\"submit\" value=\"".LANG_SUBMITBUTTON."\" class=\"form-control\"/>\n".
         "            </fieldset>\n".
         "          </form>\n".
         "        </div>\n";
}

echo "        <a href=\"index.php\" class=\"btn btn-default\">".LANG_BACK."</a>\n".
     "      </div>\n".
     "    </div>\n".
     "    <div class=\"footerbox\">\n".
     "      <a href=\"license.php\" class=\"footerbox_link\">".LANG_LICENSE."</a>\n".
     "    </div>\n".
     "  </body>\n".
     "</html>\n".
     "\n";


?>
