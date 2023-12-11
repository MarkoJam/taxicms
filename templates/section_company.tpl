<h1>Company</h1>
<div class="container">
	{section name=pom loop=$data.sections_all}
		{$data.sections_all[pom].shorthtml}
	{/section}
</div>
