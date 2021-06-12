<div class="container mt-4">
        <div class="row">
            
            
            <!-- Website Title -->
            <div class="col-md-4 col-sm-4 col-4">
                <h3 id="logo">
					<a href="<?php echo Theme::siteUrl() ?>">
						<?php echo $site->title() ?>
					</a>
				</h3>
            </div>
            
            
            <!-- Blank Column -->
            <div class="col-md-4 col-sm-12 col-12 text-right">
                &nbsp;
            </div>
            
            
            
            <!-- Social Networks -->
            <div class="col-md-4 col-sm-12 col-12 text-left" id="social">
                <div class="list-group-horizontal float-left">
                    <?php $length = count(Theme::socialNetworks()); $counter = 0; ?>
                    <?php foreach (Theme::socialNetworks() as $key=>$label): ?>
                        <a class="inline" href="<?php echo $site->{$key}(); ?>" target="_blank">
                        <?php echo $label; ?>
                        </a>
                        <?php $counter = $counter + 1; if($counter < $length) { echo "<span>&nbsp;</span>"; } ?>
					<?php endforeach ?>
                </div>
            </div>
            
            
            <!-- Static Pages -->
            <?php $length = count($staticContent); ?>
            <?php if($length > 0): ?>
                <div class="col-md-12 col-sm-12 col-12 text-right">
                <div class="list-group-horizontal float-right">
                <?php $counter = 0; ?>
                <br>
                <?php foreach ($staticContent as $staticPage): ?>
                    <a href="<?php echo $staticPage->permalink() ?>">
                    <?php echo $staticPage->title(); ?>
                    </a>
                    <?php $counter = $counter + 1; if($counter < $length) { echo "<span>&nbsp;</span>"; } ?>
                <?php endforeach ?>
                    </div>
                </div>
                <?php endif ?>
            
            
    </div>
</div>
