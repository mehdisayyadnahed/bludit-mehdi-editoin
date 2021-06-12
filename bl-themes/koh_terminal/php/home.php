<div class="container mt-4"> <!-- Content Container HOME -->
        <div class="row">
            
        <div class="col-md-4">

        <?php include(THEME_DIR_PHP.'sidebar.php'); ?>
        
        <br/>
        
        <div style="border-radius: 5px;">
		<?php
			$items = getCategories();
			foreach ($items as $category) {
				// Each category is an Category-Object
				if (count($category->pages())>0) { ?>
					<a href="<?php echo $category->permalink(); ?>" class="list-group-item list-group-item-action">
						<?php echo $category->name(); ?>
						<span class="badge badge-primary badge-pill float-left"><?php echo count($category->pages()); ?></span>
					</a>
		<?php } } ?>
		
        </div>
        
        <br/>
        
		</div>

        <?php if (empty($content)): ?>
        	<div class="col-md-8 mt-4">
        	    
        	<div class="card ">

	    <!-- Load Bludit Plugins: Page Begin -->
	
	    <!-- Cover image -->
	
	        <div class="card-body">
		<!-- Title -->
	        <h1 class="text-primary"><?php $language->p('No pages found') ?></h1>

		<!-- Full content -->
		
		<p><?php echo $L->get('no-pages-found-content'); ?></p>
        	</div>

        	<div class="card-body">
		<!-- Load Bludit Plugins: Page End -->
		    </div>
            </div>
        	</div>

        <?php endif ?>

        <?php if ($content): ?>
            <div class="col-md-8">
    			<!-- Post -->
    			<?php foreach ($content as $page): ?>
                
    			<!-- Load Bludit Plugins: Page Begin -->
    			<?php Theme::plugins('pageBegin'); ?>
                
    			<div class="card mt-2">
    				<div class="card-header"><?php echo $page->category(); ?></div>
    				<img src="" alt="">
    				<div class="card-body">
    					<div class="card-title">
    					    <!-- <h3 class="text-primary"><?php #echo $page->title(); ?></h3> -->
    						<h3><a href="<?php echo $page->permalink(); ?>" class="text-primary"><?php echo $page->title(); ?></a></h3>
    					</div>
    					
    				    <p style="margin-top: 10px; margin-bottom: 10px;">
            		    <?php $author_name = $page->username(); if($page->user('nickname') != '' ){
            		    $author_name = $page->user('nickname'); }
            		    echo ("<nobr>" . $L->get('author') . ': <a href=' . $site->uriFilters('tag') . $page->tags() . ">" . $author_name . "</a></nobr>"); ?> | 
            		    <?php echo ("<nobr>" . $L->get('date') . ': ' . $page->date() . "</nobr>"); ?> | 
            		    <?php echo ("<nobr>" . $L->get('Reading time') . ': ' . $page->readingTime() . "</nobr>"); ?></p>
            		    
    					<div class="card-text">
    				        <?php //echo (substr(($page->contentBreak()),0, 200)." ... ");
                                if(strlen($page->description())>0 ){
                                    echo $page->description();
                                } else {
                                    $max = 333;
                                    $all = explode(' ', substr($page->content(false), 0, $max));
                                    array_pop($all);
                                    echo implode(' ', $all);
                                    if (strlen($page->content(false)) > $max) {
                                        echo " ... "; } } ?>
    					</div>
    					<a href="<?php echo $page->permalink(); ?>" class="btn btn-primary float-right" style="margin-top: 1.25rem;"><?php echo $L->get('read-more'); ?></a>
    				</div>
    			</div>
    			<?php Theme::plugins('pageEnd'); ?>
    			<?php endforeach ?>
    			<br/>
    			
                <div class="container text-center" style="direction: ltr; margin-right: 0.35rem;">
                <?php if (Paginator::numberOfPages()>1): ?>
                <nav class="paginator">
                	<ul class="pagination flex-wrap" style="justify-content: right;">

                		<!-- Next button -->
                		<?php if (Paginator::showNext()): ?>
                		<li class="page-item">
                			<a class="page-link" href="<?php echo Paginator::nextPageUrl() ?>"><?php echo $L->get('Next'); ?> </a>
                		</li>
                		<?php endif; ?>
                
                		<!-- Home button -->
                		<li class="page-item <?php if (Paginator::currentPage()==1) echo 'disabled' ?>">
                			<a class="page-link" href="<?php echo Theme::siteUrl() ?>"><?php echo $L->get('Home'); ?></a>
                		</li>
                
                		<!-- Previous button -->
                		<?php if (Paginator::showPrev()): ?>
                		<li class="page-item">
                			<a class="page-link" href="<?php echo Paginator::previousPageUrl() ?>" tabindex="-1"> <?php echo $L->get('Previous'); ?></a>
                		</li>
                		<?php endif; ?>
                
                	</ul>
                </nav>
                <?php endif ?>
                </div>
                
            </div>
        </div>
    </div> <!-- END Content Container HOME -->
    <?php endif ?>
    <!-- Pagination -->
