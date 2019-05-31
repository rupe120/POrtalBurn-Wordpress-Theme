<form method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' )); ?>">
	<fieldset>
		<span class="search--input-wrap">
			<input type="text" placeholder="<?php esc_attr_e( 'Search...', 'zona' ) ?>" value="<?php echo get_search_query(); ?>" name="s" id="s" />
		</span>
		<button type="submit" id="searchsubmit"><i class="icon icon-search"></i></button>
	</fieldset>
</form>