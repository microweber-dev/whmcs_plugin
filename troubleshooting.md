# Troubleshooting


| Error | Solution |
|---|---|
| WHMCS Session doesn't work | you must put the sessions to be stored in database. In file `configuration.php` put `$session_handling = 'database';`  https://docs.whmcs.com/Sessions |
| Got error 'PHP message: PHP Warning:  require(): open_basedir restriction in effect. | "WHM Home » Security Center » PHP open_basedir Tweak" read more here: https://documentation.cpanel.net/display/80Docs/PHP+open_basedir+Tweak. Got to "Home »Software »MultiPHP INI Editor" and put open_basedir =  in `php.ini` file
 |
|  |  |

 