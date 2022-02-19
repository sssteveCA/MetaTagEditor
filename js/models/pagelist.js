
//model that contains pages meta tags edited by this plugin
class PagesList{

    static ERR_UNKNOWNERROR = -1; 
    static ERR_TEXTMISSING = 1; //No text string for do the parsing
    static ERR_INVALIDJSON = 2; //JSON string invalid format
    static ERR_INVALIDCONTENT = 3; //invalid JSON array content 

    _text; //pages list as JSON text
    _pages; //array of Page objects
    _errno; //error code

    constructor(text){
        this._text = text;
        this._pages = {};
        this._errno = 0;
    }

    get text(){return this._text;}
    get pages(){return this._pages;}

    set text(text){this._text = text;}

    //parse the JSON array text response and returns a list of Page object
    parseText(){
        this._pages = {};
        this._errno = 0;
        if(this._text != null){
            try{
                let json = JSON.parse(this._text);
                if(json.hasOwnProperty('data')){
                    for(var i in json["data"]){
                        let page = new Page();
                        page.id = json["data"][i]["id"];
                        page.page_id = json["data"][i]["page_id"];
                        page.canonical_url = json["data"][i]["canonical_url"];
                        page.title = json["data"][i]["title"];
                        page.meta_description = json["data"][i]["meta_description"];
                        page.robots = json["data"][i]["robots"];
                        this._pages[page.page_id] = page;
                    }//for(var i in json["data"]){
                }//if(json.hasOwnProperty('data')){
                else
                    this._errno = Pages.ERR_INVALIDCONTENT;
            }
            catch(e){
                console.warn(e);
                if(e instanceof SyntaxError)
                    this._errno = Pages.ERR_INVALIDJSON;  
                else
                    this._errno = Pages.ERR_UNKNOWNERROR;
            }
        }//if(this._text != null){
        else
            this._errno = Pages.ERR_TEXTMISSING;
        return this._pages;
    }
}