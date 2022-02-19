
//model that contains pages meta tags edited by this plugin
class PagesList{

    static ERR_UNKNOWNERROR = -1; 
    static ERR_TEXTMISSING = 1; //No text string for do the parsing
    static ERR_INVALIDJSON = 2; //JSON string invalid format

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
                this._pages = JSON.parse(this._text);
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