<form role="search" method="get" class="search-form" action="<?=home_url( '/' )?>">
	<div>
		<label for="s">I'm looking for</label>
		<input type="text" value="<?=htmlentities($_GET['s'])?>" name="s" class="search-field" id="s" placeholder="Search HR" />
	</div>
</form>