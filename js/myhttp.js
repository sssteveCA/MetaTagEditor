
//This class is the client for retrieve page meta tags
class MyHttp{

    url;
    headers;
    params; //POST request params

    constructor(url, headers){
        this.url = url; //Request URL
        this.headers = headers; //Request headers
    }//constructor(){

    //return promise for get meta tags by page id
    

    //getters
    get url(){return this.url;}
    get headers(){return this.headers;}
    get params(){return this.params;}
}