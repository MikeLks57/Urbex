<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous" defer></script>

	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>

	<script src="<?= $this->assetUrl('js/script.js') ?>"></script>


	
</head>
<body>
	<header class="main-header">
		<nav class="navbar navbar-default">
		  	<div class="container-fluid">
			    <div class="navbar-header">
			    	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			        	<span class="sr-only">Toggle navigation</span>
			        	<span class="icon-bar"></span>
			        	<span class="icon-bar"></span>
			        	<span class="icon-bar"></span>
			      	</button>
			      	<a class="navbar-brand" href="#">Urbex World</a>
			    </div><!-- /.navbar-header -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			    	<ul class="nav navbar-nav">
				        <li class="active"><a href="#">Urbex Pics<span class="sr-only">(current)</span></a></li>
				        <li><a href="">Partager</a></li>
				        <li><a href="">A propos</a></li>
			      	</ul>
			      	<form class="navbar-form navbar-right">
        				<div class="form-group">
          					<input type="text" class="form-control" placeholder="Rechercher">
        				</div>
        				<!-- <button type="submit" class="btn btn-default">Submit</button> -->
      				</form>
      			</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav><!-- /.nav.navbar-default -->	
	</header><!-- /.main-header -->

	<main>
        <section class="main-section">
        	<div class="container-fluid">
        		<div class="row">
	        		<div class="col-xs-12 col-md-10 col-md-offset-1">
	        			<?= $this->section('main_content') ?>
	        		</div><!-- /.container col-xs-12 col-md-10 -->
	        	</div>
        	</div><!-- /.container-fluid container-->
        </section><!-- /.main-section -->
    </main>

	<footer>
	</footer>

</body>
</html>