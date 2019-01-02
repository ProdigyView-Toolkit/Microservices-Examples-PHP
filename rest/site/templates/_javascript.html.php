
<?php if(isset($_SERVER['ENV']) && $_SERVER['ENV'] == 'production'): ?>
	<!--
		Production files that should be minified, served with gzip
		experiation headers set, etc. The NGINX ENV variable determines
		if production files are served.
	-->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>

	<script type="text/javascript" src="/js/script.js"></script>
<?php else: ?>
	<!--
		Development files should be uniminifed for debugging purposes.
	-->
	
	<!-- JQuery -->
	<script type="text/javascript" src="/js/libs/jquery-3.3.1.js"></script>
	<!-- Boostrap -->
	<script type="text/javascript" src="/js/libs/bootstrap/bootstrap.js"></script>
	
<?php endif; ?>
