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
        // if in docker environment
        if (isset($_ENV['docker'])) {
            echo self::getColoredString("Skipped App\\Composer\\Setup in Docker environment.\n", 'green');
            return;
        }
        
        $arrConfig = [];
        $s = '    ';

        // if additional-settings.php not exists
        if (!file_exists(__DIR__ . "/../../config/additional-settings.php")) {
            
            if (!file_exists(__DIR__ . "/../../config/additional-settings.dist.php")) {
                copy(__DIR__ . "/../../config/additional-settings.dist.php", __DIR__ . "/../../config/additional-settings.php");
            }

            // Error setting
            echo self::getColoredString("Setup Error Details\n", 'yellow', NULL, ['underscore']);
            // Ask for database name
            echo self::getColoredString("Please enter value for displayErrorDetails (default: ", 'green') . self::getColoredString("TRUE", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strDisplayErrors = trim(fgets($strHandle));

            if (empty($strDisplayErrors) || $strDisplayErrors !== "FALSE") {
                $arrConfig['displayErrorDetails'] = "TRUE";
            } else {
                $arrConfig['displayErrorDetails'] = $strDisplayErrors;
            }
            
            fclose($strHandle);
            
            // Database setting
            echo self::getColoredString("\nSetup Database\n", 'yellow', NULL, ['underscore']);

            // Ask for database name
            echo self::getColoredString("Please enter database name (default: ", 'green') . self::getColoredString("slim_skeleton", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strDbName = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strDbName)) {
                $arrConfig['database']['dbname'] = "slim_skeleton";
            } else {
                $arrConfig['database']['dbname'] = $strDbName;
            }

            // Ask for database host
            echo self::getColoredString("Please enter database host (default: ", 'green') . self::getColoredString("localhost", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strHost = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strHost)) {
                $arrConfig['database']['host'] = "localhost";
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

            // Ask for database socket
            echo self::getColoredString("Please enter database unix_socket path (default: ", 'green') . self::getColoredString("empty string", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";
            
            $strUnixSocket = trim(fgets($strHandle));
            fclose($strHandle);
            
            if (empty($strUnixSocket)) {
                $arrConfig['database']['unix_socket'] = "";
            } else {
                $arrConfig['database']['unix_socket'] = $strUnixSocket;
            }
                      
            // reCAPTCHA setting
            echo self::getColoredString("\nSetup Google reCAPTCHA\n", 'yellow', NULL, ['underscore']);

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

            echo self::getColoredString("\nSetup Google QR Code title\n", 'yellow', NULL, ['underscore']);
            # Google QR Code setting

            // Ask for database password
            echo self::getColoredString("Please enter the title  (default: ", 'green') . self::getColoredString("NULL", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $str2faQrcTitle = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($str2faQrcTitle)) {
                $arrConfig['2fa_qrc_title'] = "NULL";
            } else {
                $arrConfig['2fa_qrc_title'] = $str2faQrcTitle;
            }

            // Locale settings
            echo self::getColoredString("\nSetup Locale Settings\n", 'yellow', NULL, ['underscore']);

            // Ask for locale process
            echo self::getColoredString("Please enter number of locale process (default: ", 'green') . self::getColoredString("3", 'yellow') . self::getColoredString(")", 'green');
            echo "\n";
            // \App\Utility\LanguageUtility::LOCALE_URL | \App\Utility\LanguageUtility::DOMAIN_DISABLED
            echo self::getColoredString('1: ', 'yellow') . self::getColoredString("translation with path segment e.g. example.com/de/", 'green');
            echo "\n";
            // \App\Utility\LanguageUtility::LOCALE_URL | \App\Utility\LanguageUtility::DOMAIN_ENABLED
            echo self::getColoredString('2: ', 'yellow') . self::getColoredString("domain / subdomain for each translation", 'green');
            echo "\n";
            // \App\Utility\LanguageUtility::LOCALE_SESSION | \App\Utility\LanguageUtility::DOMAIN_DISABLED
            echo self::getColoredString('3: ', 'yellow') . self::getColoredString("one domain for all translations like youtube.com (recommended)", 'green');
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
                        $arrConfig['locale']['process'] = "\App\Utility\LanguageUtility::LOCALE_SESSION | \App\Utility\LanguageUtility::DOMAIN_DISABLED";
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

            if (empty($strLocaleAuto) || $strLocaleAuto !== "FALSE") {
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
            
            // User Validation setting
            echo self::getColoredString("\nSetup User Validation\n", 'yellow', NULL, ['underscore']);
            
            // Ask for min_user_name_length
            echo self::getColoredString("Please enter minimum length for user name (default: ", 'green') . self::getColoredString("4", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strMinUserLength = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strMinUserLength)) {
                $arrConfig['validation']['min_user_name_length'] = "4";
            } else {
                $arrConfig['validation']['min_user_name_length'] = $strMinUserLength;
            }
            
            // Ask for max_user_name_length
            echo self::getColoredString("Please enter maximum length for user name (default: ", 'green') . self::getColoredString("50", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strMaxUserLength = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strMaxUserLength)) {
                $arrConfig['validation']['max_user_name_length'] = "50";
            } else {
                $arrConfig['validation']['max_user_name_length'] = $strMaxUserLength;
            }
            
            // Ask for min_user_name_length
            echo self::getColoredString("Please enter minimum length for password (default: ", 'green') . self::getColoredString("6", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strMinPassLength = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strMinPassLength)) {
                $arrConfig['validation']['min_password_length'] = "6";
            } else {
                $arrConfig['validation']['min_password_length'] = $strMinPassLength;
            }
            
            // Ask for password_with_digit
            echo self::getColoredString("Are digits required for passwords? (default: ", 'green') . self::getColoredString("TRUE", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strPasswordWithDigit = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strPasswordWithDigit) || $strPasswordWithDigit !== "FALSE") {
                $arrConfig['validation']['password_with_digit'] = "TRUE";
            } else {
                $arrConfig['validation']['password_with_digit'] = $strPasswordWithDigit;
            }
            
            // Ask for password_with_lcc
            echo self::getColoredString("Are lowercase characters required for passwords? (default: ", 'green') . self::getColoredString("TRUE", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strPasswordWithLcc = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strPasswordWithLcc) || $strPasswordWithLcc !== "FALSE") {
                $arrConfig['validation']['password_with_lcc'] = "TRUE";
            } else {
                $arrConfig['validation']['password_with_lcc'] = $strPasswordWithLcc;
            }
            
            // Ask for password_with_ucc
            echo self::getColoredString("Are uppercase characters required for passwords? (default: ", 'green') . self::getColoredString("TRUE", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strPasswordWithUcc = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strPasswordWithUcc) || $strPasswordWithUcc !== "FALSE") {
                $arrConfig['validation']['password_with_ucc'] = "TRUE";
            } else {
                $arrConfig['validation']['password_with_ucc'] = $strPasswordWithUcc;
            }
            
            // Ask for password_with_nwc
            echo self::getColoredString("Are special / non-word characters required for passwords? (default: ", 'green') . self::getColoredString("TRUE", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strPasswordWithNwc = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strPasswordWithNwc) || $strPasswordWithNwc !== "FALSE") {
                $arrConfig['validation']['password_with_nwc'] = "TRUE";
            } else {
                $arrConfig['validation']['password_with_nwc'] = $strPasswordWithNwc;
            }
            
            // Ask for allowed_user_name_chars
            echo self::getColoredString("Please enter allowed characters for user name (default: ", 'green') . self::getColoredString("abcdefghijklmnopqrstuvwxyz0123456789-_", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strUserChars = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strUserChars)) {
                $arrConfig['validation']['allowed_user_name_chars'] = "str_split('abcdefghijklmnopqrstuvwxyz0123456789-_')";
            } else {
                $arrConfig['validation']['allowed_user_name_chars'] = "str_split('" . $strUserChars . "')";
            }

            // Public path
            echo self::getColoredString("\nSetup Public Path\n", 'yellow', NULL, ['underscore']);
            
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
            $stringConfig .= "$s$s$s$s'dbname'      => isset(\$_ENV['APP_DB_NAME']) ? \$_ENV['APP_DB_NAME'] : '" . $arrConfig['database']['dbname'] . "',\n";
            $stringConfig .= "$s$s$s$s'host'        => isset(\$_ENV['APP_DB_HOST']) ? \$_ENV['APP_DB_HOST'] : '" . $arrConfig['database']['host'] . "',\n";
            $stringConfig .= "$s$s$s$s'port'        => isset(\$_ENV['APP_DB_PORT']) ? \$_ENV['APP_DB_PORT'] : " . $arrConfig['database']['port'] . ",\n";
            $stringConfig .= "$s$s$s$s'user'        => isset(\$_ENV['APP_DB_USER']) ? \$_ENV['APP_DB_USER'] : '" . $arrConfig['database']['user'] . "',\n";
            $stringConfig .= "$s$s$s$s'password'    => isset(\$_ENV['APP_DB_PASSWORD']) ? \$_ENV['APP_DB_PASSWORD'] : '" . $arrConfig['database']['password'] . "',\n";
            $stringConfig .= "$s$s$s$s'unix_socket' => isset(\$_ENV['APP_DB_SOCKET']) ? \$_ENV['APP_DB_SOCKET'] : '" . $arrConfig['database']['unix_socket'] . "',\n";
            $stringConfig .= "$s$s$s],\n";
            $stringConfig .= "$s$s],\n\n";
            $stringConfig .= "$s$s// Google recaptcha\n";
            $stringConfig .= "$s$s'recaptcha' => [\n";
            $stringConfig .= "$s$s$s'site'   => '" . $arrConfig['recaptcha']['site'] . "',\n";
            $stringConfig .= "$s$s$s'secret' => '" . $arrConfig['recaptcha']['secret'] . "',\n";
            $stringConfig .= "$s$s],\n\n";
            $stringConfig .= "$s$s// Google QR Code title\n";
            $stringConfig .= "$s$s'2fa_qrc_title' => '" . $arrConfig['2fa_qrc_title'] . "',\n\n";
            $stringConfig .= "$s$s// User validation\n";
            $stringConfig .= "$s$s'validation' => [\n";
            $stringConfig .= "$s$s$s'min_user_name_length'    => " . $arrConfig['validation']['min_user_name_length'] . ",\n";
            $stringConfig .= "$s$s$s'max_user_name_length'    => " . $arrConfig['validation']['max_user_name_length'] . ",\n";
            $stringConfig .= "$s$s$s'min_password_length'     => " . $arrConfig['validation']['min_password_length'] . ",\n";
            $stringConfig .= "$s$s$s'password_with_digit'     => " . $arrConfig['validation']['password_with_digit'] . ", // digit required\n";
            $stringConfig .= "$s$s$s'password_with_lcc'       => " . $arrConfig['validation']['password_with_lcc'] . ", // lowercase character required\n";
            $stringConfig .= "$s$s$s'password_with_ucc'       => " . $arrConfig['validation']['password_with_ucc'] . ", // uppercase character required\n";
            $stringConfig .= "$s$s$s'password_with_nwc'       => " . $arrConfig['validation']['password_with_nwc'] . ", // non-word character required\n";
            $stringConfig .= "$s$s$s'allowed_user_name_chars' => " . $arrConfig['validation']['allowed_user_name_chars'] . ",\n";
            $stringConfig .= "$s$s],\n\n";
            $stringConfig .= "$s$s// Locale settings\n";
            $stringConfig .= "$s$s'locale' => [\n";
            $stringConfig .= "$s$s$s'process'     => " . $arrConfig['locale']['process'] . ",\n";
            $stringConfig .= "$s$s$s'auto_detect' => " . $arrConfig['locale']['auto_detect'] . ",\n";
            $stringConfig .= "$s$s$s'code'        => '" . $arrConfig['locale']['code'] . "', // default / current language\n";
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
            echo self::getColoredString("File 'config/additional-settings.php' was generated\n", 'green');

            static::createDatabase($arrConfig['database']);
        } else {
            // Ask for database reset
            echo self::getColoredString("Should database reset to default records? (default: ", 'green') . self::getColoredString("no", 'yellow') . self::getColoredString("): ", 'green');
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $answer = strtolower(trim(fgets($strHandle)));

            if ($answer === 'y' || $answer === 'yes') {
                $generalSettings = require_once __DIR__ . "/../../config/settings.php";
                $additionalSettings = [];

                if (is_readable(__DIR__ . "/../../config/additional-settings.php")) {
                    $additionalSettings = require_once __DIR__ . "/../../config/additional-settings.php";
                }

                $settings = array_replace_recursive($generalSettings, $additionalSettings);
                static::importDatabase($settings['settings']['doctrine']['connection']);
            } else {
                echo self::getColoredString("\nNo database changes have been made\n", 'yellow');
            }
        }
    }
    
    /**
     * @param array $configuration
     */
    protected static function createDatabase($configuration) {
        $mysql = new \PDO('mysql:host=' . $configuration['host'] . ';port=' . $configuration['port'] . ';unix_socket=' . $configuration['unix_socket'], $configuration['user'], $configuration['password']);

        if ($mysql->errorCode()) {
            echo self::getColoredString("\nConnection failed:\n", 'red');
            print_r($mysql->errorInfo());
        }
        
        $sql = "SELECT COUNT(*) AS `exists` FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMATA.SCHEMA_NAME = '". $configuration['dbname'] . "';";
        $query = $mysql->query($sql);
        
        if ($query === FALSE) {
            echo self::getColoredString("\nError searching for database:\n", 'red');
            print_r($mysql->errorInfo());
            return;
        }
        
        $row = $query->fetch();
        
        // if database exists
        if (isset($row['exists']) && $row['exists'] === '1') {
            echo self::getColoredString("\nDatabase already exists\n", 'yellow');
            echo self::getColoredString("No database changes have been made\n", 'yellow');
            return;
        }

        $sql = "CREATE DATABASE IF NOT EXISTS `". $configuration['dbname'] . "` CHARACTER SET utf8 COLLATE utf8_general_ci;";
        
        if ($mysql->query($sql) === FALSE) {
            echo self::getColoredString("\nError creating database:\n", 'red');
            print_r($mysql->errorInfo());
            return;
        } else {
            echo self::getColoredString("\nDatabase created successfully\n", 'green');
        }

        static::importDatabase($configuration);
    }
    
    /**
     * @param array $configuration
     */
    protected static function importDatabase($configuration) {
        $mysql = new \PDO('mysql:host=' . $configuration['host'] . ';dbname=' . $configuration['dbname'] . ';port=' . $configuration['port'] . ';unix_socket=' . $configuration['unix_socket'], $configuration['user'], $configuration['password']);

        if ($mysql->errorCode()) {
            echo self::getColoredString("\nConnection failed:\n", 'red');
            print_r($mysql->errorInfo());
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

        echo self::getColoredString("\nDatabase reset successfully\n", 'green');
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
