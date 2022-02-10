<?php

//This interface contains HTML code constants
interface Html{
    const MAIN_MENU = <<<HTML
<div class="mte_menu_container">
    <div class="mte_menu_header">
        <h1 class="text-center">Editor dei meta tag</h1>
    </div>
    <div class="ms-3 mte_menu_content mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-4 col-lg-3 text-center text-sm-start mb-2">
                    <input type="number" id="mte_page_id" name="page_id" placeholder="ID della pagina">
                </div>
                <div class="col-12 col-sm-4 offset-lg-1 col-lg-3 text-center mb-2">
                    <button id="mte_btn_show" class="btn btn-primary">MOSTRA</button>
                </div>
                <div class="col-12 col-sm-4 offset-lg-1 col-lg-3 text-center text-sm-end mb-2">
                    <button id="mte_btn_edit" class="btn btn-primary">MODIFICA</button>
                </div>
                <div class="col-12 col-sm-6 offset-lg-1 col-lg-4 mb-2">
                    <div id="mte_page_meta_tags" class="border border-secondary">
                    </div>
                </div>
                <div class="col-12 col-sm-6 offset-lg-2 col-lg-4  mb-2">
                    <textarea id="mte_meta_tags_editor" rows="10"></textarea>
                </div>
            </div>
        </div>
    </div> <!-- <div class="ms-3 mte_menu_content mt-2"> -->
</div>
HTML;
}
?>