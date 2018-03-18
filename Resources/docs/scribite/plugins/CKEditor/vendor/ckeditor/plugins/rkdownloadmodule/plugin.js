CKEDITOR.plugins.add('rkdownloadmodule', {
    requires: 'popup',
    lang: 'en,nl,de',
    init: function (editor) {
        editor.addCommand('insertRKDownLoadModule', {
            exec: function (editor) {
                var url = Routing.generate('rkdownloadmodule_external_finder', { objectType: 'file', editor: 'ckeditor' });
                // call method in RKDownLoadModule.Finder.js and provide current editor
                RKDownLoadModuleFinderCKEditor(editor, url);
            }
        });
        editor.ui.addButton('rkdownloadmodule', {
            label: editor.lang.rkdownloadmodule.title,
            command: 'insertRKDownLoadModule',
            icon: this.path.replace('docs/scribite/plugins/CKEditor/vendor/ckeditor/plugins/rkdownloadmodule', 'public/images') + 'admin.png'
        });
    }
});
