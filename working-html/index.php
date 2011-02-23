<?php
	$kuler = array( 
		'c1' => '#1c295c', 
		'c2' => '#556699', 
		'c3' => '#d5d5f3', 
		'c4' => '#e9e9f9', 
		'c5' => '#fff'
	);
	
	// Convert color to RGB so we can use background opacity
	function hex2rgb( $color ) {
        if ( $color[0] == '#' ) {
                $color = substr( $color, 1 );
        }
        if ( strlen( $color ) == 6 ) {
                list( $r, $g, $b ) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return false;
        }
        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
        return array( $r, $g, $b );
	}
	function echo_hex($color2hex) {
		$color_array = hex2rgb($color2hex);
		for ($i=0; $i < 3; $i++) { 
			echo $color_array[$i].',';
		}
	}
?>
<!DOCTYPE html> 
<html dir="ltr" lang="en-US"> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Carrington Personal</title>
		
	<style type="text/css" media="screen">
		/** Base
		 -------------------------------------------------- */
		body {
			background-color: <?php echo $kuler['c2']; ?>;
			font-family: Helvetica, Arial, Verdana, sans-serif;
			font-size: 14px;
			font-weight: 300;
			line-height: 21px;
			margin: 0;
		}
		a {
			color: <?php echo $kuler['c2']; ?>;
			text-decoration: none;
		}
		a:hover {
			color: <?php echo $kuler['c1']; ?>;
		}
		h1, h2, h3, h4 {
			font-weight: normal;
		}
		h1 {
			font-size: 32px;
			font-family: Titillium400, Helvetica, Arial, Verdana, sans-serif;
		}
		h2, h3, h4 {
			font-family: Titillium600, Helvetica, Arial, Verdana, sans-serif;
		}
		h2 {
			font-size: 18px;
		}
		h3 {
			font-size: 16px;
		}
		h4 {
			font-size: 14px;
		}
		h5 {
			color: #ccc;
			font-size: 10px;
			letter-spacing: 1px;
			text-transform: uppercase;
		}
		
		
		/** Load Fonts
		 -------------------------------------------------- */
		@font-face {
		    font-family: Titillium400;
		    src: url(fonts/TitilliumText22L003.otf);
		}
		@font-face {
		    font-family: Titillium600;
		    src: url(fonts/TitilliumText22L004.otf);
		}
		
		.container {
			width: 990px;
			margin: 0 auto;
		}

		/** Header
		 -------------------------------------------------- */
		#header {
			background-color: <?php echo $kuler['c1']; ?>;
		}
		#header .container {
			background-color: <?php echo $kuler['c1']; ?>;
			position: relative;
			padding-bottom: 15px;
			padding-top: 44px;
		}
		#header a {
			color: <?php echo $kuler['c5']; ?>;
		}
		#header a:hover {
			color: <?php echo $kuler['c3']; ?>;
		}
		#header h1 {
			margin: 0;
		}
		#header #nav-main {
			bottom: 0;
			line-height: 1em;
			list-style-type: none;
			margin: 0;
			padding: 0;
			position: absolute;
			right: 0;
		}
		#header #nav-main li {
			display: inline-block;
			margin: 0 0 0 20px;
			padding: 0;
		}
		#header #nav-main li a {
			display: inline-block;
			border-bottom: 3px solid <?php echo $kuler['c1']; ?>;
			padding-bottom: 10px;
		}
		#header #nav-main li a.current,
		#header #nav-main li a:hover {
			border-bottom: 3px solid <?php echo $kuler['c2']; ?>;
		}


		/** Mathead
		 -------------------------------------------------- */
		#masthead {
			background-color: <?php echo $kuler['c2']; ?>;
			min-height: 10px;
			padding: 40px 0 41px 0;
		}
		.featured {
			background-color: <?php echo $kuler['c1'] ?>;
			border: 5px solid <?php echo $kuler['c1'] ?>;
			height: 170px;
			overflow: hidden;
			position: relative;
			width: 300px;
		}
		.featured-title,
		.featured-content {
			position: absolute;
		}
		.featured-title {
			line-height: 1em;
			margin: 10px 0;
			z-index: 10;
		}
		.featured-title a {
			background-color: <?php echo $kuler['c1'] ?>;
			color: <?php echo $kuler['c5'] ?>;
			display: inline-block;
			padding: 6px 14px 5px 12px;
		}
		.featured-content {
			color:<?php echo $kuler['c5'] ?>;
			min-height: 170px;
			padding: 45px 12px 0 12px;
			z-index: 9;
		}
		.featured-content p {
			margin-top: 0;
		}
		.featured-link {
			display: block;
			position: absolute;
			height: 180px;
			left: 0;
			text-indent: -999em;
			top: 0;
			width: 310px;
			z-index: 20;
		}
		/* rollover */
		.featured:hover {
			background-color: <?php echo $kuler['c3'] ?>;
			border: 5px solid <?php echo $kuler['c3'] ?>;
		}
		.featured:hover .featured-title a {
			background-color: <?php echo $kuler['c3'] ?>;
			color: <?php echo $kuler['c1'] ?>;
		}
		.featured:hover .featured-content {
			color:<?php echo $kuler['c2'] ?>;
		}
		/* with featured image */
		.has-featured-img .featured-content {
			display: none;
		}
		.has-featured-img:hover .featured-content {
			color:<?php echo $kuler['c5'] ?>;
			background-color: rgba(<?php echo_hex($kuler['c2']); ?>.75);
			display: block;
		}
		.featured-img {
			position: absolute;
			top: 0;
			left: 0;
			z-index: 1;
		}
		
		/** Content - wraps body and sidebar
		 -------------------------------------------------- */
		#content {
			background-color: #fff;
			padding: 40px 0;
		}


		/** Post
		 -------------------------------------------------- */
		.post-header {
			clear: both;
			position: relative;
			margin-bottom: 15px;
			width: 100%;
		}
		.post-header,
		.post-content {
			padding-left: 140px;
			padding-right: 30px;
		}
		.post-title, 
		.post-date {
			line-height: 1.2em;
			margin: 0;
		}
		.post-title {
			color: <?php echo $kuler['c2']; ?>;			
		}
		.post-date {
			color: #ccc;
			bottom: 4px;
			font-family: Titillium400, Helvetica, Arial, Verdana, sans-serif;
			font-size: 20px;
			left: 0;
			letter-spacing: -1px;
			position: absolute;
		}
		.post-date,
		.post-meta {
			float: left;
			margin-right: 20px;
			text-align: right;
			width: 120px;
		}
		.post-meta {
			color: #ccc;
			font-size: 12px;
		}
		.post-meta a {
			color: #999;
		}
		.post-meta a:hover {
			color: <?php echo $kuler['c1']; ?>;
		}
		.post-meta h5 {
			margin: 0;
		}
		.post-meta ul,
		.post-meta p {
			margin: 0 0 15px 0;
		}
		.post-meta ul {
			list-style-type: none;
		}


		/** Sidebar
		 -------------------------------------------------- */
		.bio-box,
		.widget {
			margin: 0 0 25px 0;
		}
		.bio-box {
			background-color: <?php echo $kuler['c3']; ?>;	
			color: <?php echo $kuler['c2']; ?>;
			margin-bottom: 30px;
		}
		.bio-box a {
			color: <?php echo $kuler['c2']; ?>;
			text-decoration: underline;
		}
		.bio-box a:hover {
			color: <?php echo $kuler['c1']; ?>;				
		}
		.bio-img {
			float: right;
			margin: 0 0 15px 0;
		}
		.bio-box .bio-content {
			padding: 4px 18px 18px 18px;
		}
		.bio-box .bio-content p {
			margin: 10px 0 0 0;
		}		
		.widget {
			color: #999;
			font-size: 13px;
			line-height: 18px;
			margin: 0 0 25px 0;
		}
		.widget-title {
			color: <?php echo $kuler['c2']; ?>;
			background-color: <?php echo $kuler['c4']; ?>;
			margin: 0 0 10px 0;
			padding: 7px 10px 6px 10px;
		}
		.widget ul {
			padding: 0 10px 0 26px;
			margin: 0;
		}
		.widget ul li {
			margin: 5px 0 0 0;
		}
		.widget ul.ul-col-2 {
			padding: 0 0 0 26px;
		}
		.widget ul.ul-col-2 li {
			float: left;
			margin-right: 12px;
			width: 130px;
		}
		
		
		/** Footer
		 -------------------------------------------------- */
		#footer {
			background-color: <?php echo $kuler['c2']; ?>;
			color: <?php echo $kuler['c1']; ?>;
			font-size: 12px;
			line-height: 18px;
			padding: 30px 0;	
		}
		#footer a {
			color: <?php echo $kuler['c1']; ?>;
			text-decoration: underline;
		}
		#footer a:hover {
			color: <?php echo $kuler['c3']; ?>;
		}
		#footer .credit {
			float: right;
			margin-top: 0;
		}
		

		
		/** Grid
		 -------------------------------------------------- */
		.col-a,
		.col-b,
		.col-c,
		.col-ab,
		.col-bc {
			display: inline;
			float: left;
			margin: 0 15px;
		}
		.col-a,
		.col-b,
		.col-c {
			width: 310px;
		}
		.col-ab,
		.col-bc {
			width: 650px;
		}
		.col-a,
		.col-ab {
			margin-left: 0;
		}
		.col-c {
			margin-right: 0;
		}
		.clearfix {
			display: block;
			zoom: 1;
		}
		.clearfix:after {
			content: " ";
			display: block;
			font-size: 0;
			height: 0;
			clear: both;
			visibility: hidden;
		}
	</style>
</head>
<body>
	
	
	<div id="header">
		<div class="container">
			<h1><a href="">Carrington Personal</a></h1>
			<ul id="nav-main">
				<li><a href="" class="current">Home</a></li>
				<li><a href="">About</a></li>
				<li><a href="">Blog</a></li>
				<li><a href="">Contact</a></li>
			</ul>			
		</div><!-- .container -->
	</div><!-- #header -->
	
	
	<div id="masthead">
		<div class="container clearfix">
			<div class="col-a">
				<div class="featured has-featured-img">
					<img src="img/fpo-300x170-1.jpg" class="featured-img" />
					<h2 class="featured-title"><a href="">Praesent Placerat</a></h2>
					<div class="featured-content">
						<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
					</div>
					<a href="" class="featured-link">Read More</a>
				</div><!-- .featured -->				
			</div><!-- .col-a -->
			<div class="col-b">
				<div class="featured has-featured-img">
					<img src="img/fpo-300x170-2.jpg" class="featured-img" />
					<h2 class="featured-title"><a href="">Vestibulum Auctor Dapibus</a></h2>
					<div class="featured-content">
						<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
					</div>
					<a href="" class="featured-link">Read More</a>
				</div><!-- .featured -->				
			</div><!-- .col-b -->
			<div class="col-c">
				<div class="featured">
					<h2 class="featured-title"><a href="">Integer Vitae Libero</a></h2>
					<div class="featured-content">
						<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
					</div>
					<a href="" class="featured-link">Read More</a>
				</div><!-- .featured -->				
			</div><!-- .col-c -->
		</div><!-- .container -->
	</div><!-- #masthead -->
	
	
	<div id="content">
		<div class="container clearfix">
		


			<div id="body" class="col-ab">
				<div class="post">
					<div class="post-header">
						<h1 class="post-title">Lorem Ipsum Dolor</h1>
						<p class="post-date">02.17.11</p>					
					</div><!-- .post-header -->
					<div class="post-meta">
						<h5>Replies</h5>
						<ul>
							<li><a href="">2 Comments</a></li>
							<li><a href="">2 Tweets</a></li>
							<li><a href="">1 Facebook</a></li>
						</ul>
						<h5>Categories</h5>
						<ul>
							<li><a href="">Praesent Dapibus</a></li>
						</ul>
						<h5>Tags</h5>
						<p><a href="">null</a>, <a href="">justo</a>, <a href="">conseq</a></p>
					</div>
					<div class="post-content">
						<p>Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>				
						<p>Suspendisse mauris. Fusce accumsan mollis eros. Pellentesque a diam sit amet mi ullamcorper vehicula. Integer adipiscing risus a sem. Nullam quis massa sit amet nibh viverra malesuada. Nunc sem lacus, accumsan quis, faucibus non, congue vel, arcu. Ut scelerisque hendrerit tellus. Integer sagittis. Vivamus a mauris eget arcu gravida tristique. Nunc iaculis mi in ante. Vivamus imperdiet nibh feugiat est. Ut convallis, sem sit amet interdum consectetuer, odio augue aliquam leo, nec dapibus tortor nibh sed augue. Integer eu magna sit amet metus fermentum posuere. Morbi sit amet nulla sed dolor elementum imperdiet. Quisque fermentum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque adipiscing eros ut libero.</p>
						<p>Sed egestas ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor. Sed semper lorem at felis. Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus sed, urna.</p>
						<p>Morbi interdum mollis sapien. Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu pulvinar risus, vitae facilisis libero dolor a purus. Sed vel lacus. Mauris nibh felis, adipiscing varius, adipiscing in, lacinia vel, tellus. Suspendisse ac urna. Etiam pellentesque mauris ut lectus. Nunc tellus ante, mattis eget, gravida vitae, ultricies ac, leo. Integer leo pede, ornare a, lacinia eu, vulputate vel, nisl.</p>
						<p>Ut condimentum mi vel tellus. Suspendisse laoreet. Fusce ut est sed dolor gravida convallis. Morbi vitae ante. Vivamus ultrices luctus nunc. Suspendisse et dolor. Etiam dignissim. Proin malesuada adipiscing lacus. Donec metus. Curabitur gravida.</p>
					</div><!-- .post-content -->
				</div>
			</div><!-- #body -->
		

			<div id="sidebar" class="col-c">
				<div class="bio-box">
					<img src="img/fpo-bio-img.jpg" class="bio-img" />
					<div class="bio-content">
						<p>Lorem ipsum dolor sit amet, <a href="">consectetur</a> adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					</div>
				</div><!-- .bio-box -->
			
				<div class="widget">
					<h3 class="widget-title">Recent Posts</h3>
					<ul> 
						<li><a href="">Lorem Ipsum Dolor Amet Consectetuer</a></li> 
						<li><a href="">Aliquam Tincidunt Mauris Eusus</a></li> 
						<li><a href="">Vestibulum Auctor Dapibus</a></li> 
						<li><a href="">Nunc Dignissim Risus Id Metus</a></li> 
						<li><a href="">Cras Ornare Tristique Elit</a></li> 
						<li><a href="">Vivamus Vestibulum Nulla Necante</a></li> 
						<li><a href="">Praesent Placerat Risus Quis</a></li> 
						<li><a href="">Fusce Pellentesque Suscipit</a></li>
					</ul>
				</div><!-- .widget -->
				<div class="widget">
					<h3 class="widget-title">Categories</h3>
					<ul class="ul-col-2 clearfix"> 
						<li><a href="">Consectetuer</a></li> 
						<li><a href="">Aliquam</a></li> 
						<li><a href="">Praesent Placerat</a></li> 
						<li><a href="">Vestibulum</a></li> 
						<li><a href="">Dignissim</a></li> 
						<li><a href="">Cras Ornare</a></li> 
						<li><a href="">Vivamus Nulla</a></li> 
						<li><a href="">Flentesque</a></li>
					</ul>
				</div><!-- .widget -->
			</div><!-- #sidebar -->


		</div><!-- .container -->		
	</div><!-- #content -->
	
	
	<div id="footer">
		<div class="container">
			<p class="credit">Proudly powered by <a href="http://wordpress.org/">WordPress</a> and <a href="http://crowdfavorite.com/">Carrington Personal</a>.</p>
			<p>FPO for generic footer content. Fancy footer sidebar to come...</p>
		</div><!-- .container -->
	</div><!-- #footer -->
	
	
	

</body>
</html>
