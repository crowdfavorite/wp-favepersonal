<?php 
/* Content Sample
<div class="cfp-popover cfp-popover-top-center" style="display: none;">
	<div class="cfp-popover-notch"></div>
	<div class="cfp-popover-inner">
		<div class="cfp-popover-content">
			<p><strong>.popover</strong></p>
			<p>The notch is an image, the rest is CSS. Still need to style elements that will appear inside the popover.</p>
			<p>Use .cfp-popover-top-right, .cfp-popover-top-right, .cfp-popover-top-center, .cfp-popover-color-preview to position the notch in the proper location.</p>
		</div><!--.cfp-popover-content-->
		<div class="cfp-popover-scroll">
			<p>scrollable list area</p>
			<p>scrollable list area</p>
			<p>scrollable list area</p>
			<p>scrollable list area</p>
			<p>scrollable list area</p>
			<p>scrollable list area</p>
			<p>scrollable list area</p>
		</div><!-- .cfp-popover-scroll -->
		<div class="cfp-popover-footer">
			<input class="button button-primary" type="submit" name="submit" value="Save Settings">
		</div><!-- .cfp-popover-footer -->
	</div><!--.cfp-popover-inner-->
</div>
*/ 
?>
<div id="<?php echo $popover_id; ?>" class="cfp-popover cfp-popover-top-<?php echo $arrow_pos; if (!empty($class)) { echo ' '.$class; } ?>" style="display: <?php echo (!empty($display) ? $display : 'none'); ?>;">
	<div class="cfp-popover-notch"></div>
	<div class="cfp-popover-inner">
	<?php 
		if (!empty($html)) {
			echo $html;
		}
	?>
	</div><!--.cfp-popover-inner-->
</div>