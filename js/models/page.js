
//model of page meta tags
class Page{

    _id;
    _page_id;
    _title;
    _meta_description;
    _content;

    constructor(id, page_id, title, meta_description, content){
        this._id = id;
        this._page_id = page_id;
        this._title = title;
        this._meta_description = meta_description;
        this._content = content;
    }

    get id(){return this._id;}
    get page_id(){return this._page_id;}
    get title(){return this._title;}
    get meta_description(){return this._meta_description;}
    get content(){return this._content;}

    set id(id){this._id = id;}
    set page_id(page_id){this._page_id = page_id;}
    set title(title){this._title = title;}
    set meta_description(meta_description){this._meta_description = meta_description;}
    set content(content){this._content = content;}

}