<!-- Post -->
<div class="card my-5">

	<!-- Load Bludit Plugins: Page Begin -->
	<?php Theme::plugins('pageBegin'); ?>

	<!-- Cover image -->
	<?php if ($page->coverImage()): ?>
	<img class="card-img-top mb-3 rounded-0" alt="Cover Image" src="<?php echo $page->coverImage(); ?>"/>
	<?php endif ?>

	<div class="card-body">
		<!-- Title -->
		<h3 class="text-primary"><?php echo $page->title(); ?></h3>


		
		<!-- Creation date -->
	    <?php if (!$page->isStatic() && !$url->notFound()): ?>
		    <p style="margin-top: 10px; margin-bottom: 10px;">
    		    <?php $author_name = $page->username(); if($page->user('nickname') != '' ){
    		    $author_name = $page->user('nickname'); }
    		    echo ("<nobr>" . $L->get('author') . ': <a href=' . $site->uriFilters('tag') . $page->tags() . ">" . $author_name . "</a></nobr>"); ?> | 
    		    <?php echo ("<nobr>" . $L->get('date') . ': ' . $page->date() . "</nobr>"); ?> | 
    		    <?php echo ("<nobr>" . $L->get('Reading time') . ': ' . $page->readingTime() . "</nobr>"); ?></p>
		<?php endif ?>

		<!-- Full content -->
		<?php echo $page->content(); ?>
		
		<?php if( (($page->user('firstname') != '') || ($page->user('email') != '')) and !$url->notFound() ): ?>
			<br>
    		<div  class="card card-body" style="background-color: #121212;">
    		    <?php if( $page->user('firstname') != ''){ echo ("<br>" . $L->get("about-author") . ": " . $page->user('firstname')); } ?>
    		    <?php if ($page->user('email') != ''): ?>
    		        <?php if ($page->user('firstname') != ''): ?>
    		            <?php echo ("<br>"); endif ?>
    		        <?php echo ( $L->get("contact-links") . ": " . $page->user('email')); endif ?>
            </div>
        <?php endif ?>
	</div>

	<!-- Load Bludit Plugins: Page End -->
	<?php Theme::plugins('pageEnd'); ?>
</div>
