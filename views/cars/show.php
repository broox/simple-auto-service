<?php
require_once '../../config.php';
require_once SITE_PATH.'/app.php';

$car = new Car($_GET['slug']);
if ($car->doesntExist()) {
    require_once('../main/404.php'); die();
}

require_once '../shared/header.php';
?>
<h1>
	<?php echo $car->title() ?>
	<small><a href="<?php echo $car->editURL() ?>">edit</a></small>
</h1>

<?php require '../shared/footer.php'; ?>