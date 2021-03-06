
class MyHttp{

    static ERR_URLMISSING = 1; //url required missing
    static ERR_METHODMISSING = 2; //HTTP method missing

    _url; //Request URL
    _method; //HTTP method
    _headers; //Request headers
    _params; //POST request params
    _errno; //error code
    _response; //HTTP text response

    constructor(url, method, headers = {}, params = {}){
        this._url = url; 
        this._method = method;
        this._headers = headers; 
        this._params = params;
        this._errno = 0;
        this._response = null;

    }//constructor(){

    //getters
    get url(){return this._url;}
    get method(){return this._method;}
    get headers(){return this._headers;}
    get params(){return this._params;}
    get errno(){return this._errno;}
    get response(){return this._response;}

    //this method returns an HTTP string response
    getResponse(){
        this._response = null;
        this._errno = 0;
        if(this._url !== null){
            if(this._method != null){
                if(this._headers == null)
                    this._headers = {};
                if(this._method == 'GET' || this._method == 'HEAD'){
                    this._response = this.#getResultGet();
                }//if(this._method == 'GET' || this._method == 'HEAD'){
                else{
                    //These method need request body
                    if(this._params == null)
                    this._params = {};
                    this._response = this.#getResultPost();
                }
            }//if(this._method != null){
            else
                this._errno = MyHttp.ERR_METHODMISSING;
        }// if(this._url !== null){
        else
            this._errno = MyHttp.ERR_URLMISSING;
        return this._response;
    }

    //get HTTP response from GET method
    async #getResultGet(){
        var promiseVals = {
            method : this._method,
            headers : this._headers
        };
        var promise = await fetch(this._url);
        return promise.text(); //returns response as text
    }

    //get HTTP response from POST method
    async #getResultPost(){
        var promiseVals = {
            method : this._method,
            headers : this._headers,
            body : this._params,
            /* mode : 'cors',
            cache : 'default',
            redirect : 'follow',
            referrerPolicy : 'no-referrer'  */
        };
        var promise = await fetch(this._url,promiseVals);
        return promise.text(); //returns response as text
    }
}

