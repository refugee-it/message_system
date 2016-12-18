<?php
/* Copyright (C) 2014-2016  Stephan Kreutzer
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
 * @file $/web/license.php
 * @brief License information page.
 * @author Stephan Kreutzer
 * @since 2014-06-06
 */



require_once("./libraries/https.inc.php");

session_start();

require_once("./libraries/languagelib.inc.php");
require_once(getLanguageFile("license"));

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n".
     "<!DOCTYPE html\n".
     "    PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n".
     "    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n".
     "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n".
     "    <head>\n".
     "        <meta http-equiv=\"content-type\" content=\"application/xhtml+xml; charset=UTF-8\"/>\n".
     "        <title>".LANG_PAGETITLE."</title>\n".
     "        <link rel=\"stylesheet\" type=\"text/css\" href=\"bootstrap/css/bootstrap.min.css\"/>\n".
     "        <link rel=\"stylesheet\" type=\"text/css\" href=\"mainstyle_mobile.css\"/>\n".
     "        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"/>\n".
     "    </head>\n".
     "    <body>\n".
     "        <div class=\"mainbox container\">\n".
     "          <div class=\"mainbox_header\">\n".
     "            <h1 class=\"mainbox_header_h1\">".LANG_HEADER."</h1>\n".
     "          </div>\n".
     "          <div class=\"mainbox_body\">\n";
     
require_once("./license.inc.php");
echo getHTMLLicenseNotification("license");
echo "<hr/>\n";
echo getHTMLLicenseFull("license");
     
echo "          </div>\n".
     "        </div>\n".
     "    </body>\n".
     "</html>\n";



?>
