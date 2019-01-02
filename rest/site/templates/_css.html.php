<link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    
<?php if(isset($_SERVER['ENV']) && $_SERVER['ENV'] == 'production'): ?>
	<!-- Font Awesome CSS -->
	<link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet">
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<!-- App's CSS -->
	<link href="/css/style.min.css?v=.01" rel="stylesheet" >
<?php else : ?>
	<!-- Bootstrap -->
	<link href="/css/bootstrap/bootstrap.css" rel="stylesheet" >
	<!-- Fontawesome -->
	<link href="/css/fontawesome/all.css" rel="stylesheet" >
	<!-- Custom styles for this template -->
    <link href="/css/clean-blog.css" rel="stylesheet">
<?php endif; ?>