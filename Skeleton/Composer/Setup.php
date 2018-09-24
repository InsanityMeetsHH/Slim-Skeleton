<?php
namespace Skeleton\Composer;

use Composer\Script\Event;

class Setup {
    
    /**
     * Generates additional-settings.php and set up database
     * 
     * @param Event $event
     */
    public static function run(Event $event) {
        $arrConfig = [];
        $s = '    ';
        $settings = "<?php\nreturn [\n$s'settings' => [\n";

        if (!file_exists(__DIR__ . "/../../config/additional-settings.php")) {
            
            if (!file_exists(__DIR__ . "/../../config/additional-settings.dist.php")) {
                copy(__DIR__ . "/../../config/additional-settings.dist.php", __DIR__ . "/../../config/additional-settings.php");
            }
            
            $arrConfig['database'] = [];

            // Ask for database name
            echo "Please enter value for displayErrorDetails (default: TRUE): ";
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strDisplayErrors = trim(fgets($strHandle));

            if (empty($strDisplayErrors)) {
                $settings .= "$s$s'displayErrorDetails' => TRUE";
            } else {
                $settings .= "$s$s'displayErrorDetails' => " . $strDisplayErrors;
            }
            
            $settings .= ",  // set to false in production\n\n";
            fclose($strHandle);
            
            // Database setting
            $settings .= "$s$s// Doctrine settings\n";
            $settings .= "$s$s'doctrine' => [\n";
            $settings .= "$s$s$s'connection' => [\n";

            // Ask for database name
            echo "Please enter database name: ";
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $arrConfig['database']['dbname'] = trim(fgets($strHandle));
            fclose($strHandle);
            $settings .= "$s$s$s$s'dbname' => isset(\$_ENV['APP_DB_NAME']) ? \$_ENV['APP_DB_NAME'] : '" . $arrConfig['database']['dbname'] . "',\n";

            // Ask for database host
            echo "Please enter database host (default: '127.0.0.1'): ";
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strHost = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strHost)) {
                $arrConfig['database']['host'] = "127.0.0.1";
            } else {
                $arrConfig['database']['host'] = $strHost;
            }
            $settings .= "$s$s$s$s'host' => '" . $arrConfig['database']['host'] . "',\n";

            // Ask for database port
            echo "Please enter database port (default: 3306): ";
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $intPort = (int)trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($intPort)) {
                $arrConfig['database']['port'] = 3306;
            } else {
                $arrConfig['database']['port'] = $intPort;
            }
            $settings .= "$s$s$s$s'port' => isset(\$_ENV['APP_DB_PORT']) ? \$_ENV['APP_DB_PORT'] : " . $arrConfig['database']['port'] . ",\n";

            // Ask for database user
            echo "Please enter database user (default: 'root'): ";
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strUser = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strUser)) {
                $arrConfig['database']['user'] = "root";
            } else {
                $arrConfig['database']['user'] = $strUser;
            }
            $settings .= "$s$s$s$s'user' => isset(\$_ENV['APP_DB_USER']) ? \$_ENV['APP_DB_USER'] : '" . $arrConfig['database']['user'] . "',\n";

            // Ask for database password
            echo "Please enter database password (default: ''): ";
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strPassword = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strPassword)) {
                $arrConfig['database']['password'] = "";
            } else {
                $arrConfig['database']['password'] = $strPassword;
            }
            $settings .= "$s$s$s$s'password' => isset(\$_ENV['APP_DB_PASSWORD']) ? \$_ENV['APP_DB_PASSWORD'] : '" . $arrConfig['database']['password'] . "',\n";
            $settings .= "$s$s$s],\n$s$s],\n\n";
            
            # reCAPTCHA setting
            $settings .= "$s$s// Google recaptcha\n";
            $settings .= "$s$s'recaptcha' => [\n";

            // Ask for reCAPTCHA website key
            echo "Please enter reCAPTCHA website key: ";
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strRcSite = trim(fgets($strHandle));
            fclose($strHandle);
            $settings .= "$s$s$s'site' => '" . $strRcSite . "',\n";

            // Ask for reCAPTCHA secret key
            echo "Please enter reCAPTCHA secret key: ";
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strRcSecret = trim(fgets($strHandle));
            fclose($strHandle);
            $settings .= "$s$s$s'secret' => '" . $strRcSecret . "',\n";
            
            $settings .= "$s$s],\n\n";
            
            // Locale settings
            $settings .= "$s$s// Locale settings\n";
            $settings .= "$s$s'locale' => [\n";

            // Ask for locale process
            echo "Please enter locale process (default: \App\Utility\LanguageUtility::LOCALE_URL | \App\Utility\LanguageUtility::DOMAIN_DISABLED): ";
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strLocaleProcess = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strLocaleProcess)) {
                $settings .= "$s$s$s'process' => \App\Utility\LanguageUtility::LOCALE_URL | \App\Utility\LanguageUtility::DOMAIN_DISABLED,\n";
            } else {
                $settings .= "$s$s$s'process' => $strLocaleProcess,\n";
            }
            
            $settings .= "$s$s$s'active' => [\n";

            // Ask for en-US domain
            echo "Please enter locale en-US domain: ";
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strEnUsDomain = trim(fgets($strHandle));
            fclose($strHandle);
            $settings .= "$s$s$s$s'en-US' => '" . $strEnUsDomain . "',\n";

            // Ask for de-DE domain
            echo "Please enter locale de-DE domain: ";
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strDeDeDomain = trim(fgets($strHandle));
            fclose($strHandle);
            $settings .= "$s$s$s$s'de-DE' => '" . $strDeDeDomain . "',\n";
            
            $settings .= "$s$s$s],\n$s$s],\n\n";
            
            // Public path
            $settings .= "$s$s// Relative to domain (e.g. project is in sub directory '/project/public/')\n";

            // Ask for public path
            echo "Please enter public path (default: '/'): ";
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $strPublicPath = trim(fgets($strHandle));
            fclose($strHandle);

            if (empty($strLocaleProcess)) {
                $settings .= "$s$s'public_path' => '/',\n";
            } else {
                $settings .= "$s$s'public_path' => '$strPublicPath',\n";
            }
            

            // write AdditionalConfiguration.php
            file_put_contents(__DIR__ . "/../../config/additional-settings.php", $settings . "\n    ]\n];");

            static::createDatabase($arrConfig['database']);
        } else {
            // Ask for import
            echo "Should the data be importet (y/n): ";
            $strHandle = fopen("php://stdin", "r");
            echo "\n";

            $answer = strtolower(trim(fgets($strHandle)));

            if ($answer === 'y' || $answer === 'yes') {
                $settings = require_once __DIR__ . "/../../config/additional-settings.php";
                var_dump($settings);
                
                static::importDatabase([
                    'dbname'   => $settings['settings']['doctrine']['connection']['dbname'],
                    'host'     => $settings['settings']['doctrine']['connection']['host'],
                    'port'     => $settings['settings']['doctrine']['connection']['port'],
                    'user'     => $settings['settings']['doctrine']['connection']['username'],
                    'password' => $settings['settings']['doctrine']['connection']['password']
                ]);
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
            echo "Database created successfully\n";
        } else {
            echo "Error creating database: " . $mysql->error . "\n";
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
                $mysql->query($templine) or print('Error performing query ' . $templine . '\': ' . $mysql->error . "\n");
                // Reset temp variable to empty
                $templine = '';
            }
        }

        $mysql->close();
    }
}
