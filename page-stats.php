<?php get_header(); ?>
<div id="main" class="stats">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div id="page">
		<?php flo_page_title(get_the_title()) ?>
		<article <?php post_class(); ?>>
			<section class="story">
				<?php the_content();?>
			</section>
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<?php 
				global $wpdb;

				$advertiser = new Flotheme_Advertiser();
				$vid = $advertiser->profile()->id();
				$oldid = get_post_meta($vid,'flo_oldid', true);
				if (is_numeric($oldid)) $vid = $oldid;				
				$tblname = $wpdb->prefix."logs";


			?>

			<?php 
				$totalQR = $wpdb->get_var("SELECT count(*) FROM ".$tblname." WHERE item_id = '".$vid."' AND action = 'qrc_redirect'");

				$qr_days30 = $wpdb->get_results(
					"SELECT stamp, count(*) as cnt
						FROM ".$tblname."
						WHERE stamp >= DATE_SUB(CURDATE(),INTERVAL 30 DAY)
						AND action = 'qrc_redirect'
						AND item_id = '".$vid."'
						GROUP BY DATE_FORMAT(stamp, '%Y-%m-%d')					
					"
				);				
			?>
			<p>Total QR Scans: <?php echo $totalQR; ?></p>

			<?php if (!empty($qr_days30)) : ?>
			    <script type="text/javascript">
			    	chart_data = [
			          ['Date', 'Scans'],
			          <?php foreach ($days30 as $day) : ?>
			          ['<?php echo substr($day->stamp,0,10); ?>', <?php echo $day->cnt; ?>],
			          <?php endforeach; ?>
			        ]
			      google.load("visualization", "1", {packages:["corechart"]});
			      google.setOnLoadCallback(drawChart);
			      function drawChart() {
			        var data = google.visualization.arrayToDataTable(chart_data);

			        var options = {
			          title: 'QR Scans for last 30 days'
			        };

			        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_qr'));
			        chart.draw(data, options);
			      }
			    </script>			
			    <div id="chart_div_qr" style="width: 650px; height: 400px;"></div>
			<?php endif; ?>

			<?php 
				$totalV = $wpdb->get_var("SELECT count(*) FROM ".$tblname." WHERE item_id = '".$vid."' AND action = 'view'");

				$qry = "SELECT stamp, count(*) as cnt
						FROM ".$tblname."
						WHERE stamp >= DATE_SUB(CURDATE(),INTERVAL 30 DAY)
						AND action = 'view'
						AND item_id = '".$vid."'
						GROUP BY DATE_FORMAT(stamp, '%Y-%m-%d')					
					";
				$v_days30 = $wpdb->get_results($qry);				
			?>
			<p>Total Views: <?php echo $totalV; ?></p>

			<?php if (!empty($v_days30)) : ?>
			    <script type="text/javascript">
			    	chart_data = [
			          ['Date', 'View'],
			          <?php foreach ($v_days30 as $day) : ?>
			          ['<?php echo substr($day->stamp,0,10); ?>', <?php echo $day->cnt; ?>],
			          <?php endforeach; ?>
			        ]
			      google.load("visualization", "1", {packages:["corechart"]});
			      google.setOnLoadCallback(drawChart);
			      function drawChart() {
			        var data = google.visualization.arrayToDataTable(chart_data);

			        var options = {
			          title: 'Profile Views for last 30 days'
			        };

			        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_views'));
			        chart.draw(data, options);
			      }
			    </script>			
			    <div id="chart_div_views" style="width: 650px; height: 400px;"></div>
			<?php endif; ?>			

			<?php 
				$totalC = $wpdb->get_var("SELECT count(*) FROM ".$tblname." WHERE item_id = '".$vid."' AND action IN ('website','blog','facebook','twitter','tumblr','vimeo','youtube')");

				$c_days30 = $wpdb->get_results(
					"SELECT stamp, count(*) as cnt
						FROM ".$tblname."
						WHERE stamp >= DATE_SUB(CURDATE(),INTERVAL 30 DAY)
						AND action IN ('website','blog','facebook','twitter','tumblr','vimeo','youtube')
						AND item_id = '".$vid."'
						GROUP BY DATE_FORMAT(stamp, '%Y-%m-%d')					
					"
				);				
			?>
			<p>Total Clicks: <?php echo $totalC; ?></p>

			<?php if (!empty($c_days30)) : ?>
			    <script type="text/javascript">
			    	chart_data = [
			          ['Date', 'Clicks'],
			          <?php foreach ($c_days30 as $day) : ?>
			          ['<?php echo substr($day->stamp,0,10); ?>', <?php echo $day->cnt; ?>],
			          <?php endforeach; ?>
			        ]
			      google.load("visualization", "1", {packages:["corechart"]});
			      google.setOnLoadCallback(drawChart);
			      function drawChart() {
			        var data = google.visualization.arrayToDataTable(chart_data);

			        var options = {
			          title: 'Profile Clicks for last 30 days'
			        };

			        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_clicks'));
			        chart.draw(data, options);
			      }
			    </script>			
			    <div id="chart_div_clicks" style="width: 650px; height: 400px;"></div>
			<?php endif; ?>						
		</article>
	</div>
<?php endwhile; else: ?>
	<?php flo_part('notfound')?>
<?php endif; ?>
</div>
<?php get_sidebar('advertisers'); ?>
<?php get_footer(); ?>