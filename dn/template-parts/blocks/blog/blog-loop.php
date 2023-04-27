<?php 

	$args = array(
		 'type' => 'post',
	   'orderby' => 'name',
	   'order'   => 'ASC'
	);

  $post_categories = get_categories($args);

  $posts_args = [
  	'status' => 'publish'
  	// 'numberposts' => 10, 
  	// 'category_name' => 'cat-slug' 
  ];

  if(isset($_GET['cat'])){
  	$posts_args['category_name'] = $_GET['cat'];
  }

  $posts = get_posts( $posts_args );



?>

<section class="archive">
	<div class="header">
		<div class="headerl">
			<div class="text title">
				<h3>News</h3>
			</div>
		</div>
		<div class="headerr tags gray-background">
			<span>
				Tags:
				<span class="open-filters">
					<?php get_svg('arrow-bottom', "#555555") ?>
				</span>
			</span>
			<nav>
				<?php foreach($post_categories as $post_category_key => $post_category): ?>
						<a href="?cat=<?php echo $post_category->slug ?>"><?php echo $post_category->name ?></a>
				<?php endforeach ?> 
			</nav>
		</div>
	</div>

	<div class="posts wrapper">
		<?php foreach($posts as $post_key => $post): ?>
		<div class="item">
			<a href="<?php echo get_permalink($post->ID) ?>">
				<div class="img">
					<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ) ?>" alt="">
					<div class="overlay">
						<div class="link white">
							<span>Read Story</span>
						</div>
					</div>
				</div>

				<div class="item-text">
					<div class="date"><?php echo get_the_date('', $post->ID) ?></div>
					<div class="title"><?php echo $post->post_title ?></div>
				</div>
			</a>
		</div>
		<?php endforeach; ?>
	</div>
</section>