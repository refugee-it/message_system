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
 * @file $/web/index.php
 * @brief Add a message.
 * @author Stephan Kreutzer
 * @since 2012-06-01
 */



require_once("./libraries/https.inc.php");

if (empty($_SESSION) === true)
{
    @session_start();
}

if (isset($_POST['logout']) === true &&
    isset($_SESSION['user_id']) === true)
{
    $language = null;

    if (isset($_SESSION['language']) === true)
    {
        $language = $_SESSION['language'];
    }

    $_SESSION = array();

    if ($language != null)
    {
        $_SESSION['language'] = $language;
    }
    else
    {
        if (isset($_COOKIE[session_name()]) == true)
        {
            setcookie(session_name(), '', time()-42000, '/');
        }
    }
}



require_once("./libraries/languagelib.inc.php");
require_once(getLanguageFile("index"));
require_once("./language_selector.inc.php");

$direction = getCurrentLanguageDirection();

if ($direction === LanguageDefinition::DirectionRTL)
{
    $direction = "_rtl";
}
else
{
    $direction = "";
}

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n".
     "<!DOCTYPE html\n".
     "    PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n".
     "    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n".
     "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"".getCurrentLanguage()."\" lang=\"".getCurrentLanguage()."\">\n".
     "    <head>\n".
     "        <meta http-equiv=\"content-type\" content=\"application/xhtml+xml; charset=UTF-8\"/>\n".
     "        <title>".LANG_PAGETITLE."</title>\n".
     "        <link rel=\"stylesheet\" type=\"text/css\" href=\"bootstrap/css/bootstrap.min.css\"/>\n".
     "        <link rel=\"stylesheet\" type=\"text/css\" href=\"mainstyle_mobile.css\"/>\n".
     "        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"/>\n".
     "    </head>\n".
     "    <body>\n".
     "        <div class=\"mainbox".$direction." container\">\n";

if (isset($_POST['name']) !== true ||
    isset($_POST['password']) !== true)
{
    require_once("./language_selector.inc.php");
    echo getHTMLLanguageSelector("index.php",
                                 "",
                                 "",
                                 "",
                                 "form-group",
                                 "form-control",
                                 "form-control");

    echo "          <div class=\"mainbox_header\">\n".
         "            <h1 class=\"mainbox_header_h1\">".LANG_HEADER."</h1>\n".
         "          </div>\n".
         "          <div class=\"mainbox_body\">\n";

    if (isset($_POST['install_done']) == true)
    {
        if (@unlink(dirname(__FILE__)."/install/install.php") === true)
        {
            clearstatcache();
        }
        else
        {
            echo "            <p class=\"error\">\n".
                 "              ".LANG_INSTALLDELETEFAILED."\n".
                 "            </p>\n";
        }
    }

    if (file_exists("./install/install.php") === true &&
        isset($_GET['skipinstall']) != true)
    {
        echo "            <a href=\"install/install.php\">".LANG_INSTALLBUTTON."</a>\n";

        require_once("./license.inc.php");
        echo getHTMLLicenseNotification("license");
    }
    else
    {
        require_once("./libraries/user_management.inc.php");

        if (isset($_SESSION['user_id']) === true)
        {
            echo "            <a href=\"messages.php\">".LANG_LINKCAPTION_MESSAGES."</a><br/>\n".
                 "            <a href=\"message_delete.php?cleartrash=true\">".LANG_LINKCAPTION_CLEARMESSAGETRASH."</a><br/>\n".
                 "            <form action=\"index.php\" method=\"post\">\n".
                 "              <fieldset>\n".
                 "                <input type=\"submit\" name=\"logout\" value=\"".LANG_BUTTON_LOGOUT."\"/>\n".
                 "              </fieldset>\n".
                 "            </form>\n";
        }
        else
        {
            echo "            <p>\n".
                 "              ".LANG_WELCOMETEXT."\n".
                 "            </p>\n".
                 "            <form action=\"message_add.php\" method=\"post\">\n".
                 "              <fieldset class=\"form-group\">\n".
                 "                <label for=\"message_name\">".LANG_MESSAGE_NAMEFIELD_CAPTION."</label>\n".
                 "                <input name=\"name\" type=\"text\" size=\"40\" maxlength=\"254\" class=\"form-control\" id=\"message_name\"/>\n".
                 "                <label for=\"message_text\">".LANG_MESSAGEFIELD_CAPTION."</label>\n".
                 "                <textarea name=\"message\" rows=\"24\" cols=\"80\" class=\"form-control\" id=\"message_text\"></textarea>\n".
                 "                <input type=\"submit\" value=\"".LANG_SUBMITBUTTON."\" class=\"form-control\"/>\n".
                 "              </fieldset>\n".
                 "            </form>\n".
                 "            <p>\n".
                 "              ".LANG_LOGINDESCRIPTION."\n".
                 "            </p>\n".
                 "            <form action=\"index.php\" method=\"post\">\n".
                 "              <fieldset class=\"form-group\">\n".
                 "                <label for=\"login_name\">".LANG_LOGIN_NAMEFIELD_CAPTION."</label>\n".
                 "                <input name=\"name\" type=\"text\" size=\"20\" maxlength=\"254\" class=\"form-control\" id=\"login_name\"/>\n".
                 "                <label for=\"password\">".LANG_PASSWORDFIELD_CAPTION."</label>\n".
                 "                <input name=\"password\" type=\"password\" size=\"20\" maxlength=\"254\" class=\"form-control\" id=\"password\"/>\n".
                 "                <input type=\"submit\" value=\"".LANG_SUBMITBUTTON."\" class=\"form-control\"/>\n".
                 "              </fieldset>\n".
                 "            </form>\n";

            require_once("./license.inc.php");
            echo getHTMLLicenseNotification("license");
        }
    }

    echo "          </div>\n".
         "          <div class=\"footerbox\">\n".
         "            <a href=\"license.php\" class=\"footerbox_link\">".LANG_LICENSE."</a>\n".
         "          </div>\n";
}
else
{
    require_once("./libraries/user_management.inc.php");

    $user = NULL;

    $result = getUserByName($_POST['name']);

    if (is_array($result) !== true)
    {
        echo "          <div class=\"mainbox_body\">\n".
             "            <p class=\"error\">\n".
             "              ".LANG_DBCONNECTFAILED."\n".
             "            </p>\n".
             "          </div>\n".
             "          <div class=\"footerbox\">\n".
             "            <a href=\"license.php\" class=\"footerbox_link\">".LANG_LICENSE."</a>\n".
             "          </div>\n".
             "        </div>\n".
             "    </body>\n".
             "</html>\n";

        exit(-1);
    }


    if (count($result) === 0)
    {
        echo "          <div class=\"mainbox_body\">\n".
             "            <p class=\"error\">\n".
             "              ".LANG_LOGINFAILED."\n".
             "            </p>\n".
             "            <a href=\"index.php\" class=\"btn btn-default\">".LANG_LINKCAPTION_RETRYLOGIN."</a>\n".
             "          </div>\n".
             "          <div class=\"footerbox\">\n".
             "            <a href=\"license.php\" class=\"footerbox_link\">".LANG_LICENSE."</a>\n".
             "          </div>\n".
             "        </div>\n".
             "    </body>\n".
             "</html>\n";

        exit(0);
    }
    else
    {
        // The user does exist, he wants to login.

        if ($result[0]['password'] === hash('sha512', $result[0]['salt'].$_POST['password']))
        {
            $user = array("id" => (int)$result[0]['id'],
                          "role" => (int)$result[0]['role']);
        }
        else
        {
            echo "          <div class=\"mainbox_body\">\n".
                 "            <p class=\"error\">\n".
                 "              ".LANG_LOGINFAILED."\n".
                 "            </p>\n".
                 "            <a href=\"index.php\" class=\"btn btn-default\">".LANG_LINKCAPTION_RETRYLOGIN."</a>\n".
                 "          </div>\n".
                 "          <div class=\"footerbox\">\n".
                 "            <a href=\"license.php\" class=\"footerbox_link\">".LANG_LICENSE."</a>\n".
                 "          </div>\n".
                 "        </div>\n".
                 "    </body>\n".
                 "</html>\n";

            exit(0);
        }
    }

    if (is_array($user) === true)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $_POST['name'];
        $_SESSION['user_role'] = $user['role'];

        echo "          <div class=\"mainbox_body\">\n".
             "            <p class=\"success\">\n".
             "              ".LANG_LOGINSUCCESS."\n".
             "            </p>\n".
             "            <a href=\"index.php\">".LANG_LINKCAPTION_CONTINUE."</a>\n".
             "          </div>\n".
             "          <div class=\"footerbox\">\n".
             "            <a href=\"license.php\" class=\"footerbox_link\">".LANG_LICENSE."</a>\n".
             "          </div>\n";
    }
}

echo "        </div>\n".
     "    </body>\n".
     "</html>\n";


?>
