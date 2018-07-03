<?php


	$contem = "M.I.A.";
	$nome = "m.i.a.";
	$string = "?recurso foaf:name ?nome .
                  ?nome bif:contains \"'$contem'\" .
                  {?recurso a dbo:MusicalArtist}
                      UNION
                  {?recurso a dbo:Band}
                      UNION
                  {?recurso a dbo:Artist}
                      UNION
                  {?recurso a yago:WikicatFeministMusicians} .
                  FILTER(regex(lcase(str(?nome)), '^$nome$'))";
    echo $string;


?>