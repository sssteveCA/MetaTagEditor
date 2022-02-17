
//model of page meta tags
class Page{

    static ERR_JSONERROR = 1;
    static ERR_PROPERTYMISSING = 2;

    _id;
    _page_id;
    _canonical_url;
    _title;
    _meta_description;
    _robots;
    _errno;

    constructor(id = 0, page_id = 0, canonical_url = '',title = '', meta_description = '', robots = ''){
        this._id = id;
        this._page_id = page_id;
        this._canonical_url = canonical_url;
        this._title = title;
        this._meta_description = meta_description;
        this._robots = robots;
        this._errno = 0;
    }

    get id(){return this._id;}
    get canonical_url(){return this._canonical_url;}
    get page_id(){return this._page_id;}
    get title(){return this._title;}
    get meta_description(){return this._meta_description;}
    get robots(){return this._robots;}
    get errno(){return this._errno;}

    set id(id){this._id = id;}
    set canonical_url(canonical_url){this._canonical_url = canonical_url;}
    set page_id(page_id){this._page_id = page_id;}
    set title(title){this._title = title;}
    set meta_description(meta_description){this._meta_description = meta_description;}
    set robots(robots){this._robots = robots;}

    //Parse JSON string response and insert values in properties
    parseJsonString(jsonStr){
        var parsed = true; //true if json string is correctly parsed
        this._errno = 0;
        try{
            var jsonObj = JSON.parse(jsonStr);
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