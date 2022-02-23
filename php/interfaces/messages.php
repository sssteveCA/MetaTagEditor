<?php

namespace MetaTagEditor\Interfaces;

//This interface contains string messages of the plugin
interface Messages{
    //Errors
    const ERR_DATA_MISSED = "Inserisci i dati richiesti per continuare";
    const ERR_PAGE_NOTEXISTS = "La pagina specificata non esiste";
    const ERR_YOASTSEO_MISSING = "Per poter usare questo plugin è necessario aver installato 'Yoast SEO'"; 

    //success
    const OK_DB_DELETE = "Meta Tags della pagina cancellati";
    const OK_DB_EDIT = "Meta Tags della pagina modificati";
}
?>