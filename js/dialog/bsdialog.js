
//this class show a Bootstrap dialog
class BsDialog{

    static DLGTYPE_OK = 1; //Dialog with OK button
    static DLGTYPE_YESNO = 2; //Dialog with Yes No buttons

    static ERR_NOTYPE = 10; //Invalid Type of modal
    static ERR_NOHTML = 11; //No dialog HTML code found to show the dialog

    static BTN_OK = 30; //OK button pressed
    static BTN_YES = 31; //Yes button pressed
    static BTN_NO = 32; //'No' button pressed

    _bt_pressed; //button pressed
    _errno;
    _instance; //Bootstrap dialog instance
    _message; //Dialog message
    _title; //Dialog title
    _type; //Dialog type(ok dialog, yes no dialog)
    _html; //Html of Bootstrap dialog

    constructor(title,message,type){
        this._title = title;
        this._message = message;
        this._type = type;
        this._html = null;
        this._errno = 0;
        this._action = null;
    }

    get btPressed(){return this._bt_pressed;}
    get errno(){return this._errno;}
    get html(){return this._html;}
    get instance(){return this._instance;}
    get message(){return this._message;}
    get title(){return this._title;}
    get type(){return this._type;}

    //Choose which dialog display
    setDialog(){
        let setted = false;
        this._errno = 0;
        if(this._type == BsDialog.DLGTYPE_OK){
            this._html = this.#htmlOkDialog();
            setted = true;
        }
        else if(this._type == BsDialog.DLGTYPE_YESNO){
            this._html = this.#htmlYesNoDialog();
            setted = true;
        }
        else
            this._errno = BsDialog.ERR_NOTYPE;
        return setted;
    }

    showDialog(){
        let show = false;
        this._errno = 0;
        if(this._html != null){
            document.body.append(this._html);
            let modalEl = document.getElementById('dialog');
            this._instance = new bootstrap.Modal(modalEl,{
                focus : true
            });
            this._instance.show();
        }//if(this._html != null){
        else{
            this._errno = BsDialog.ERR_NOHTML;
        }
        return show;
    }

    //html code for ok dialog
    #htmlOkDialog(){
        this._html = `
<div id="dialog" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">${this._title}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>${this._message}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary okbutton">OK</button>
            </div>
        </div>
    </div>
</div>
        `;
        return this._html;
    }

    //html code for yes no dialog
    #htmlYesNoDialog(){
        this._html = `
<div id="dialog" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">${this._title}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>${this._message}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary yesbutton">SÌ</button>
                <button type="button" class="btn btn-secondary nobutton" data-bs-dismiss="modal">NO</button>
            </div>
        </div>
    </div>
</div>
        `;
        return this._html;
    }
}