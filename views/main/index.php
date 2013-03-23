<?php
require_once '../shared/header.php';
$currentCars = Car::current();
?>
<h1>There are <?= Car::count() ?> cars</h1>
<div class="row">
	<div class="span3">
		<ul class="nav nav-list">
			<?php foreach ($currentCars as $car) { ?>
				<li>
					<a href="<?php echo $car->url(); ?>"><?php echo $car->title(); ?></a>
				</li>
			<?php } ?>
		</ul>
	</div>
	<div class="span9">
		<pre>
		<?php
		print_r(Car::index());
		?>
		</pre>
	</div>
</div>
<br>bye
<?php require '../shared/footer.php'; ?>