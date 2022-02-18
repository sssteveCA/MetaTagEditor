<?php

namespace MetaTagEditor\Interfaces;

//This interface contains constants and message of MyMetaPage errors codes class
interface MmpErrors{
    //constants
    const ERR_MISSEDREQPARAMS = 1; //required params missed
    const ERR_NORESULTS = 2; //No results found from last query
    const ERR_PAGEID_NOTMATCH = 3; //page_id doesn't match with regular expression
    const ERR_CANONICALURL_NOTMATCH = 4; //canonical_url doesn't match with regular expression
    const ERR_TITLE_NOTMATCH = 5; //title doesn't match with regular expression
    const ERR_METADESCRIPTION_NOTMATCH = 6; //meta_description doesn't match with regular expression
    const ERR_ROBOTS_NOTMATCH = 7; //robots doesn't match with regular expression

    //messages
    const MSG_MISSEDREQPARAMS = "Uno o più parametri richiesti sono mancanti";
    const MSG_NORESULTS = "La ricerca non ha prodotto alcun risultato";
    const MSG_TABLENOTEXISTS = "La tabella specificata non esiste";
    const MSG_PAGEID_NOTMATCH = "L'id della pagina ha un formato non valido";
    const MSG_CANONICALURL_NOTMATCH = "l'URL canonico ha un formato non valido";
    const MSG_TITLE_NOTMATCH = "il titolo ha un formato non valido";
    const MSG_METADESCRIPTION_NOTMATCH = "La descrizione meta ha un formato non valido";
    const MSG_ROBOTS_NOTMATCH = "Le meta direttive robots non sono in un formato non valido";
}
?>