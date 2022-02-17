
class MyHttp{

    static ERR_URLMISSING = 1; //url required missing
    static ERR_METHODMISSING = 2; //HTTP method missing

    _url; //Request URL
    _method; //HTTP method
    _headers; //Request headers
    _params; //POST request params
    _errno; //error code

    constructor(url, method, headers,params){
        this._url = url; 
        this._method = method;
        this._headers = headers; 
        this._params = params;
        this._errno = 0;

    }//constructor(){

    //getters
    get url(){return this._url;}
    get method(){return this._method;}
    get headers(){return this._headers;}
    get params(){return this._params;}
    get errno(){return this._errno;}

    //this method returns an HTTP string response
    getResponse(){
        //console.log("myHttp getResponse");
        var response = null;
        this._errno = 0;
        if(this._url !== null){
            if(this._method != null){
                if(this._headers == null)
                    this._headers = {};
                if(this._params == null)
                    this._params = {};
                    response = this.#getResult();
            }//if(this._method != null){
            else
                this._errno = MyHttp.ERR_METHODMISSING;
        }// if(this._url !== null){
        else
            this._errno = MyHttp.ERR_URLMISSING;
        return response;
    }

    //get HTTP response from Promise
    async #getResult(){
        var promiseVals = {
            method : this._method,
            headers : this._headers,
            body : this._params,
            /* mode : 'cors',
            cache : 'default',
            redirect : 'follow',
            referrerPolicy : 'no-referrer'  */
        };
        //console.log("myHttp #getResult promise vals");
        console.log(promiseVals);
        var promise = await fetch(this._url,promiseVals);
        return promise.text(); //returns response as text
    }
}

