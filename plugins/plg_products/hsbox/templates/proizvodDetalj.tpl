<h1>Proizvod detalji</h1>
{$proizvod.naziv}
{$proizvod.opis}

<h2>KARAKTERISTIKE:</h2>
{section name=cnt loop=$karakteristike}
{$karakteristike[cnt].naziv} : {$karakteristike[cnt].vrednost} <br/> 
{/section}