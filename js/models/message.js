
//This class parse the JSON response when there is a message to show
class Message{

    static ERR_UNKNOWNERROR = -1;
    static ERR_TEXTMISSING = 1; //No text string passed
    static ERR_INVALIDJSON = 2; //Error in JSON syntax
    static ERR_INVALIDCONTENT = 3; //Json object doesn't contains required properties

    static MSG_UNKNOWNERROR = "Errore sconosciuto";
    static MSG_TEXTMISSING = "Non è stata fornita la stringa JSON";
    static MSG_INVALIDJSON = "Sintassi JSON errata";
    static MSG_INVALIDCONTENT = "Le proprietà richieste non sono state trovate nella stringa JSON";

    _text;
    _message;
    _done; //true if operation done successfully
    _errno;
    _error;

    constructor(text){
        this._text = text;
        this._errno = 0;
        this._error = null;
        this._done = false;
    }

    get done(){return this._done;}
    get text(){return this._text;}
    get message(){return this._message;}
    get errno(){return this._errno;}
    get error(){
        switch(this._errno){
            case Message.ERR_UNKNOWNERROR:
                this._error = Message.MSG_UNKNOWNERROR;
                break;
            case Message.ERR_TEXTMISSING:
                this._error = Message.MSG_TEXTMISSING;
                break;
            case Message.ERR_INVALIDJSON:
                this._error = Message.MSG_INVALIDJSON;
                break;
            case Message.ERR_INVALIDCONTENT:
                this._error = Message.MSG_INVALIDCONTENT;
                break;
            default:
                this._error = null;
                break;
        }
    }

    //parse the JSON response and returns the message string
    parseText(){
        this._message = null;
        this._errno = 0;
        if(this._text != null){
            try{
                let jsonObj = JSON.parse(this._text);
                if(jsonObj.hasOwnProperty('msg') && jsonObj.hasOwnProperty('done')){
                    this._message = jsonObj['msg'];
                    this._done = jsonObj['done'];
                }
                else
                    this._errno = Message.ERR_INVALIDCONTENT;
            }catch(e){
                console.warn(e);
                if(e instanceof SyntaxError)
                    this._errno = Message.ERR_INVALIDJSON;
                else
                    this._errno = Message.ERR_UNKNOWNERROR;
            }
        }//if(this._text != null){
        else
            this._errno = Message.ERR_TEXTMISSING;
        return this._message;
    }
}