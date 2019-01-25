<?php
namespace App\Composer;

use Composer\Script\Event;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class Setup {
    
    /**
     * Generates additional-settings.php and set up database
     * 
     * @param Event $event
     */
    public static function run(Event $event) {
        if (isset($_ENV['docker'])) {
            echo self::getColoredString("Skipped App\\Composer\\Setup in Docker environment.\n", 'green');
            return;
        }
        
        $arrConfig = [];
        $s = '    ';

        if (!file_exists(__DIR__ . "/../../config/additional-settings.php")) {
            
            if (!file_exists(__DIR__ . "/../../config/additional-settings.dist.php")) {
                copy(__DIR__ . "/../../config/additional-settings.dist.php", __DIR__ . "/../../config/additional-settings.php");
            }

            echo self::getColoredString("Setup Error Details\n", 'yellow', NULL, ['underscore']);
            // Ask for database name
            echo self::getColoredString("Please enter value for displayErrorDetails (default: ", 'green') . self::getColoredString("TRUE", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strDisplayErrors = trim(fgets($strHandle));

            if (empty($strDisplayErrors)) {
                $arrConfig['displayErrorDetails'] = 'TRUE';
            } else {
                $arrConfig['displayErrorDetails'] = $strDisplayErrors;
            }
            
            fclose($strHandle);
            
            echo self::getColoredString("Setup Database\n", 'yellow', NULL, ['underscore']);
            // Database setting

            // Ask for database name
            echo self::getColoredString("Please enter database name (default: ", 'green') . self::getColoredString("slim_database", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strDbName = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strDbName)) {
                $arrConfig['database']['dbname'] = "slim_database";
            } else {
                $arrConfig['database']['dbname'] = $strDbName;
            }

            // Ask for database host
            echo self::getColoredString("Please enter database host (default: ", 'green') . self::getColoredString("127.0.0.1", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strHost = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strHost)) {
                $arrConfig['database']['host'] = "127.0.0.1";
            } else {
                $arrConfig['database']['host'] = $strHost;
            }

            // Ask for database port
            echo self::getColoredString("Please enter database port (default: ", 'green') . self::getColoredString("3306", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $intPort = (int)trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($intPort)) {
                $arrConfig['database']['port'] = 3306;
            } else {
                $arrConfig['database']['port'] = $intPort;
            }

            // Ask for database user
            echo self::getColoredString("Please enter database user (default: ", 'green') . self::getColoredString("root", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strUser = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strUser)) {
                $arrConfig['database']['user'] = "root";
            } else {
                $arrConfig['database']['user'] = $strUser;
            }

            // Ask for database password
            echo self::getColoredString("Please enter database password (default: ", 'green') . self::getColoredString("empty string", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strPassword = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strPassword)) {
                $arrConfig['database']['password'] = "";
            } else {
                $arrConfig['database']['password'] = $strPassword;
            }

            echo self::getColoredString("Setup Google reCAPTCHA\n", 'yellow', NULL, ['underscore']);
            # reCAPTCHA setting

            // Ask for reCAPTCHA website key
            echo self::getColoredString("Please enter reCAPTCHA website key (default: ", 'green') . self::getColoredString("empty string", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $arrConfig['recaptcha']['site'] = trim(fgets($strHandle));
            fclose($strHandle);

            // Ask for reCAPTCHA secret key
            echo self::getColoredString("Please enter reCAPTCHA secret key (default: ", 'green') . self::getColoredString("empty string", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $arrConfig['recaptcha']['secret'] = trim(fgets($strHandle));
            fclose($strHandle);

            echo self::getColoredString("Setup Locale Settings\n", 'yellow', NULL, ['underscore']);
            // Locale settings

            // Ask for locale process
            echo self::getColoredString("Please enter number of locale process (default: ", 'green') . self::getColoredString("1", 'yellow') . self::getColoredString(")", 'green');
            echo "\n";
            // \App\Utility\LanguageUtility::LOCALE_URL | \App\Utility\LanguageUtility::DOMAIN_DISABLED
            echo self::getColoredString('1: ', 'yellow') . self::getColoredString("translation with path segment e.g. example.com/de/", 'green');
            echo "\n";
            // \App\Utility\LanguageUtility::LOCALE_URL | \App\Utility\LanguageUtility::DOMAIN_ENABLED
            echo self::getColoredString('2: ', 'yellow') . self::getColoredString("domain / subdomain for each translation", 'green');
            echo "\n";
            // \App\Utility\LanguageUtility::LOCALE_SESSION | \App\Utility\LanguageUtility::DOMAIN_DISABLED
            echo self::getColoredString('3: ', 'yellow') . self::getColoredString("one domain for all translations like youtube.com", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strLocaleProcess = (int)trim(fgets($strHandle));
            fclose($strHandle);
            
            switch ($strLocaleProcess) {
                case 1:
                    $arrConfig['locale']['process'] = "\App\Utility\LanguageUtility::LOCALE_URL | \App\Utility\LanguageUtility::DOMAIN_DISABLED";
                    break;
                case 2:
                    $arrConfig['locale']['process'] = "\App\Utility\LanguageUtility::LOCALE_URL | \App\Utility\LanguageUtility::DOMAIN_ENABLED";
                    break;
                case 3:
                    $arrConfig['locale']['process'] = "\App\Utility\LanguageUtility::LOCALE_SESSION | \App\Utility\LanguageUtility::DOMAIN_DISABLED";
                    break;

                default:
                    if (empty($strLocaleProcess)) {
                        $arrConfig['locale']['process'] = "\App\Utility\LanguageUtility::LOCALE_URL | \App\Utility\LanguageUtility::DOMAIN_DISABLED";
                    } else {
                        echo self::getColoredString("Locale process " . $strLocaleProcess . " does not exists!", 'white', 'red');
                        die("\n");
                    }
                    break;
            }

            // Ask for auto detection
            echo self::getColoredString("Please enter value for language auto detection (default: ", 'green') . self::getColoredString("TRUE", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strLocaleAuto = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strLocaleAuto)) {
                $arrConfig['locale']['auto_detect'] = "TRUE";
            } else {
                $arrConfig['locale']['auto_detect'] = $strLocaleAuto;
            }
            
            // Ask for locale code domain combination
            echo self::getColoredString("Please enter locale domains\n", 'green');
            echo self::getColoredString("First locale code domain combination will be the default language\n", 'green');
            echo self::getColoredString("To exit the loop press enter at 'Locale code'\n", 'green');
            
            do {
                echo self::getColoredString("Locale code (e.g. en-US): ", 'green');
                $strHandle = fopen("php://stdin", "r");
                $strLocaleCode = trim(fgets($strHandle));
                fclose($strHandle);
                
                if (empty($strLocaleCode)) {
                    break;
                }
                
                echo self::getColoredString("Domain: ", 'green');
                $strHandle = fopen("php://stdin", "r");
                $strLocaleDomain = trim(fgets($strHandle));
                fclose($strHandle);
                echo "\n";
                
                if (empty($strLocaleDomain)) {
                    break;
                }
                
                $arrConfig['locale']['active'][$strLocaleCode] = $strLocaleDomain;
                
                // if is first entry
                if (count($arrConfig['locale']['active']) === 1) {
                    $arrConfig['locale']['code'] = $strLocaleCode;
                }
            } while (TRUE);
            
            if (!isset($arrConfig['locale']['active'])) {
                echo self::getColoredString("You need at least one local code domain combination!", 'white', 'red');
                die("\n");
            }

            echo self::getColoredString("Setup Public Path\n", 'yellow', NULL, ['underscore']);
            // Public path
            // Ask for public path
            echo self::getColoredString("Please enter public path (default: ", 'green') . self::getColoredString("dynamic generated", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strPublicPath = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strPublicPath)) {
                $arrConfig['public_path'] = "isset(\$_ENV['docker']) ? '/' : str_replace('index.php', '', \$_SERVER['PHP_SELF'])";
            } else {
                $arrConfig['public_path'] = "'$strPublicPath'";
            }
            
            $stringConfig = "<?php\n";
            $stringConfig .= "return [\n";
            $stringConfig .= "$s'settings' => [\n";
            $stringConfig .= "$s$s'displayErrorDetails' => " . $arrConfig['displayErrorDetails'] . ",  // set to false in production\n\n";
            $stringConfig .= "$s$s// Doctrine settings\n";
            $stringConfig .= "$s$s'doctrine' => [\n";
            $stringConfig .= "$s$s$s'connection' => [\n";
            $stringConfig .= "$s$s$s$s'dbname'   => isset(\$_ENV['APP_DB_NAME']) ? \$_ENV['APP_DB_NAME'] : '" . $arrConfig['database']['dbname'] . "',\n";
            $stringConfig .= "$s$s$s$s'host'     => isset(\$_ENV['APP_DB_HOST']) ? \$_ENV['APP_DB_HOST'] : '" . $arrConfig['database']['host'] . "',\n";
            $stringConfig .= "$s$s$s$s'port'     => isset(\$_ENV['APP_DB_PORT']) ? \$_ENV['APP_DB_PORT'] : " . $arrConfig['database']['port'] . ",\n";
            $stringConfig .= "$s$s$s$s'user'     => isset(\$_ENV['APP_DB_USER']) ? \$_ENV['APP_DB_USER'] : '" . $arrConfig['database']['user'] . "',\n";
            $stringConfig .= "$s$s$s$s'password' => isset(\$_ENV['APP_DB_PASSWORD']) ? \$_ENV['APP_DB_PASSWORD'] : '" . $arrConfig['database']['password'] . "',\n";
            $stringConfig .= "$s$s$s],\n";
            $stringConfig .= "$s$s],\n\n";
            $stringConfig .= "$s$s// Google recaptcha\n";
            $stringConfig .= "$s$s'recaptcha' => [\n";
            $stringConfig .= "$s$s$s'site'   => '" . $arrConfig['recaptcha']['site'] . "',\n";
            $stringConfig .= "$s$s$s'secret' => '" . $arrConfig['recaptcha']['secret'] . "',\n";
            $stringConfig .= "$s$s],\n\n";
            $stringConfig .= "$s$s// Locale settings\n";
            $stringConfig .= "$s$s'locale' => [\n";
            $stringConfig .= "$s$s$s'process' => " . $arrConfig['locale']['process'] . ",\n";
            $stringConfig .= "$s$s$s'auto_detect' => " . $arrConfig['locale']['auto_detect'] . ",\n";
            $stringConfig .= "$s$s$s'code' => '" . $arrConfig['locale']['code'] . "', // default / current language\n";
            $stringConfig .= "$s$s$s'active' => [\n";
            foreach ($arrConfig['locale']['active'] as $key => $value) {
                $stringConfig .= "$s$s$s$s'$key' => '$value',\n";
            }
            $stringConfig .= "$s$s$s],\n";
            $stringConfig .= "$s$s],\n\n";
            $stringConfig .= "$s$s// Relative to domain (e.g. project is in sub directory '/project/public/')\n";
            $stringConfig .= "$s$s'public_path' => " . $arrConfig['public_path'] . ",\n";
            $stringConfig .= "$s],\n";
            $stringConfig .= "];\n";

            // write additional-settings.php
            file_put_contents(__DIR__ . "/../../config/additional-settings.php", $stringConfig);

            static::createDatabase($arrConfig['database']);
        } else {
            // Ask for import
            echo self::getColoredString("Should database reset to default records (default: ", 'green') . self::getColoredString("no", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $answer = strtolower(trim(fgets($strHandle)));

            if ($answer === 'y' || $answer === 'yes') {
                $settings = require_once __DIR__ . "/../../config/additional-settings.php";
                
                static::importDatabase($settings['settings']['doctrine']['connection']);
            }
        }
    }
    
    /**
     * @param array $configuration
     */
    protected static function createDatabase($configuration) {
        $mysql = new \mysqli($configuration['host'], $configuration['user'], $configuration['password'], '', $configuration['port']);

        if ($mysql->connect_error) {
            die("Connection failed: " . $mysql->connect_error);
        }

        $sql = "CREATE DATABASE IF NOT EXISTS `". $configuration['dbname'] . "` CHARACTER SET utf8 COLLATE utf8_general_ci;";

        if ($mysql->query($sql) === TRUE) {
            echo self::getColoredString("Database created successfully\n", 'green');
        } else {
            echo self::getColoredString("Error creating database: " . $mysql->error . "\n", 'red');
        }

        $mysql->close();

        static::importDatabase($configuration);
    }
    
    /**
     * @param array $configuration
     */
    protected static function importDatabase($configuration) {
        $mysql = new \mysqli($configuration['host'], $configuration['user'], $configuration['password'], $configuration['dbname'], $configuration['port']);

        if ($mysql->connect_error) {
            die("Connection failed: " . $mysql->connect_error);
        }

        // Temporary variable, used to store current query
        $templine = '';
        // Read in entire file
        $lines = file(__DIR__ . "/../../sql/db-dump.sql");
        // Loop through each line
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }

            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                $mysql->query($templine) or print(self::getColoredString("Error performing query " . $templine . "': " . $mysql->error . "\n", 'red'));
                // Reset temp variable to empty
                $templine = '';
            }
        }

        $mysql->close();
    }
    
    /**
     * Returns colored text for CLI
     * 
     * @param string $text
     * @param string $foreground
     * @param string $background
     * @param array $options
     * @return string
     */
    protected static function getColoredString($text, $foreground = NULL, $background = NULL, array $options = []) {
        // skip colors on windows operating system
        if (strpos(strtolower(php_uname()), 'windows') !== FALSE) {
            return $text;
        }
        
        $output = new OutputFormatterStyle($foreground, $background, $options);
        return $output->apply($text);
    }
}
