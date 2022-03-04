<?php

namespace MetaTagEditor\Interfaces;

//This interface contains constants and message of MyMetaPage errors codes class
interface MmpErrors{
    //constants
    const ERR_MISSEDREQPARAMS = 1; //required params missed
    const ERR_NORESULTS = 2; //No results found from last query
    const ERR_ID_NOTMATCH = 3; //id doesn't match with regular expression
    const ERR_PAGEID_NOTMATCH = 4; //page_id doesn't match with regular expression
    const ERR_CANONICALURL_NOTMATCH = 5; //canonical_url doesn't match with regular expression
    const ERR_TITLE_NOTMATCH = 6; //title doesn't match with regular expression
    const ERR_METADESCRIPTION_NOTMATCH = 7; //meta_description doesn't match with regular expression
    const ERR_ROBOTS_NOTMATCH = 8; //robots doesn't match with regular expression
    const ERR_QUERYERROR = 9; //SQL syntax error
    const ERR_NOROWSAFFECTED = 10; //No rows affected in last query
    const ERR_PAGEIDNOTEXISTS = 11; //No page found with page_id passed

    //messages
    const MSG_MISSEDREQPARAMS = "Uno o più parametri richiesti sono mancanti";
    const MSG_NORESULTS = "La ricerca non ha prodotto alcun risultato";
    const MSG_TABLENOTEXISTS = "La tabella specificata non esiste";
    const MSG_ID_NOTMATCH = "L'id ha un formato non valido";
    const MSG_PAGEID_NOTMATCH = "L'id della pagina ha un formato non valido";
    const MSG_CANONICALURL_NOTMATCH = "l'URL canonico ha un formato non valido";
    const MSG_TITLE_NOTMATCH = "il titolo ha un formato non valido";
    const MSG_METADESCRIPTION_NOTMATCH = "La descrizione meta ha un formato non valido";
    const MSG_ROBOTS_NOTMATCH = "Le meta direttive robots non sono in un formato non valido";
    const MSG_QUERYERROR = "La query inviata non è corretta";
    const MSG_NOROWSAFFECTED = "Nessuna modifica alla tabella eseguita";
    const MSG_PAGEIDNOTEXISTS = "Nessuna pagina trovata con questo ID";
}
?>