<form role="search" method="get" id="searchform" action="<?php echo site_url('search')?>/" >
    <fieldset>
        <input type="text" value="<?php echo get_search_query(); ?>" name="q" id="s" placeholder="<?php _e('Search', 'flotheme')?>" />
        <input type="submit" id="searchsubmit" value=" " />
    </fieldset>
</form>
