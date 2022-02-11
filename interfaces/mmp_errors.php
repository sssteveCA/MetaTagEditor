<?php

//This interface contains constants and message of MyMetaPage errors codes class
interface MmpErrors{
    //constants
    const ERR_MISSEDREQPARAMS = 1; //required params missed
    const ERR_NORESULTS = 2; //No results found from last query

    //messages
    const MSG_MISSEDREQPARAMS = "Uno o più parametri richiesti sono mancanti";
    const MSG_NORESULTS = "La ricerca non ha prodotto alcun risultato";
    const MSG_TABLENOTEXISTS = "La tabella specificata non esiste";
}
?>