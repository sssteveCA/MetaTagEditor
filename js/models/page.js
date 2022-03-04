
//model of page meta tags
class Page{

    static ERR_JSONERROR = 1;
    static ERR_PROPERTYMISSING = 2;
    static ERR_VALUESEMPTY = 3;
    static ERR_FROMSERVER = 4;

    static MSG_JSONERROR = "Sintassi JSON errata";
    static MSG_PROPERTYMISSING = "Proprietà richiesta mancante";
    static MSG_VALUESEMPTY = "Uno o più proprietà hanno un valore non valido";

    _id;
    _page_id;
    _canonical_url;
    _title;
    _meta_description;
    _robots;
    _errno;
    _error;

    constructor(id = 0, page_id = 0, canonical_url = '',title = '', meta_description = '', robots = ''){
        this._id = id;
        this._page_id = page_id;
        this._canonical_url = canonical_url;
        this._title = title;
        this._meta_description = meta_description;
        this._robots = robots; // array
        this._errno = 0;
        this._error = null;
    }

    get id(){return this._id;}
    get canonical_url(){return this._canonical_url;}
    get meta_description(){return this._meta_description;}
    get page_id(){return this._page_id;}
    get title(){return this._title;}
    get robots(){return this._robots;}
    get errno(){return this._errno;}
    get error(){
        switch(this._errno){
            case Page.ERR_JSONERROR:
                this._error = Page.MSG_JSONERROR;
                break;
            case Page.ERR_PROPERTYMISSING:
                this._error = Page.MSG_PROPERTYMISSING;
                break;
            case Page.ERR_VALUESEMPTY:
                this._error = Page.MSG_VALUESEMPTY;
                break;
            default:
                this._error = null;
                break;
        }
        return this._error;
    }

    set id(id){this._id = id;}
    set canonical_url(canonical_url){this._canonical_url = canonical_url;}
    set page_id(page_id){this._page_id = page_id;}
    set title(title){this._title = title;}
    set meta_description(meta_description){this._meta_description = meta_description;}
    set robots(robots){this._robots = robots;}

    //check if all values are not empty
    notEmpty(){
        let filled = false;
        this._errno = 0;
        if(this._page_id && this._canonical_url && this._title && this._meta_description && this._robots ){
            filled = true;
        }
        else this._errno = Page.ERR_VALUESEMPTY;
        return filled;
    }

    //Parse JSON string response and insert values in properties
    parseJsonString(jsonStr){
        var parsed = true; //true if json string is correctly parsed
        this._errno = 0;
        try{
            var jsonObj = JSON.parse(jsonStr);
            if(jsonObj.hasOwnProperty("done") && jsonObj["done"] == true){
                if(jsonObj.hasOwnProperty("page")){
                    var jsonObjPage = jsonObj["page"];
                    if(!jsonObjPage.hasOwnProperty("page_id"))parsed = false;
                    if(!jsonObjPage.hasOwnProperty("canonical_url"))parsed = false;
                    if(!jsonObjPage.hasOwnProperty("title"))parsed = false;
                    if(!jsonObjPage.hasOwnProperty("meta_description"))parsed = false;
                    if(!jsonObjPage.hasOwnProperty("robots"))parsed = false;
                    if(parsed){
                        this._page_id = jsonObjPage["page_id"];
                        this._canonical_url = jsonObjPage["canonical_url"];
                        this._title = jsonObjPage["title"];
                        this._meta_description = jsonObjPage["meta_description"];
                        this._robots = jsonObjPage["robots"];
                    }
                    else{
                        //missed all properties required
                        this._errno = Page.ERR_PROPERTYMISSING;
                    }
                }//if(jsonObj.hasOwnProperty("page")){
            }//if(jsonObj.hasOwnProperty("done") && jsonObj["done"] == true){
            else{
                parsed = false;
                this._errno = Page.ERR_FROMSERVER;
            }
        }catch(e){
            parsed = false;
            console.warn(e);
            if(e instanceof SyntaxError){
                this._errno = Page.ERR_JSONERROR;
            }
        }
        return parsed;
    }

}