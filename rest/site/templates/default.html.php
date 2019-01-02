<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>{SITE_TITLE}</title>
		
		{SITE_META}

		<?php include('_css.html.php'); ?>

	</head>

	<body>

		<!-- Navigation -->
		<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
			<div class="container">
				<a class="navbar-brand" href="/"><?= $this->Meta->getTitle(); ?></a>
				<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					Menu
					<i class="fas fa-bars"></i>
				</button>
				<div class="collapse navbar-collapse" id="navbarResponsive">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<a class="nav-link" href="/">Home</a>
						</li>
						
					</ul>
				</div>
			</div>
		</nav>

		<div id="validation-messages" >
			<?= $this -> ShowAlert -> showAlert(); ?>
		</div>
		<div id="app">
		<?php echo $this -> content(); ?>
		</div>
		

		<!-- Footer -->
		<footer>
			<div class="container">
				<div class="row">
					<div class="col-lg-8 col-md-10 mx-auto">
						<ul class="list-inline text-center">
							<li class="list-inline-item">
								<a href="#"> <span class="fa-stack fa-lg"> <i class="fas fa-circle fa-stack-2x"></i> <i class="fab fa-twitter fa-stack-1x fa-inverse"></i> </span> </a>
							</li>
							<li class="list-inline-item">
								<a href="#"> <span class="fa-stack fa-lg"> <i class="fas fa-circle fa-stack-2x"></i> <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i> </span> </a>
							</li>
							<li class="list-inline-item">
								<a href="#"> <span class="fa-stack fa-lg"> <i class="fas fa-circle fa-stack-2x"></i> <i class="fab fa-github fa-stack-1x fa-inverse"></i> </span> </a>
							</li>
						</ul>
						<p class="copyright text-muted">
							Copyright &copy; Your Website 2018
						</p>
					</div>
				</div>
			</div>
		</footer>

		<?php include('_javascript.html.php'); ?>
		<!-- Replaces with appended javascript -->
		{HEADER_ADDITION}
	</body>

</html>
