<?php
/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Start the autoloader provided by Composer itself that will take care of
| all these painful task for us.
|
*/

include 'vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Let's do some magic
|--------------------------------------------------------------------------
*/

$app = new App();
$app->run();

?>