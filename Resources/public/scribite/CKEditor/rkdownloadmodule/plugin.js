CKEDITOR.plugins.add('rkdownloadmodule', {
    requires: 'popup',
    init: function (editor) {
        editor.addCommand('insertRKDownLoadModule', {
            exec: function (editor) {
                RKDownLoadModuleFinderOpenPopup(editor, 'ckeditor');
            }
        });
        editor.ui.addButton('rkdownloadmodule', {
            label: 'Down load',
            command: 'insertRKDownLoadModule',
            icon: this.path.replace('scribite/CKEditor/rkdownloadmodule', 'images') + 'admin.png'
        });
    }
});
