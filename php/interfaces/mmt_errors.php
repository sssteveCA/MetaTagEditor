<?php

namespace MetaTagEditor\Interfaces;

//This interface contains error constants of MetaTagTable class
interface MmtErrors{
    //Constants
    const ERR_NORESULTS = 1;

    //Messages
    const MSG_TABLENOTEXISTS = "La tabella specificata non esiste";
    const MSG_NORESULTS = "La ricerca non ha prodotto alcun risultato";
}
?>