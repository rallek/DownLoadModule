/**
 * Initializes the plugin, this will be executed after the plugin has been created.
 * This call is done before the editor instance has finished it's initialization so use the onInit event
 * of the editor instance to intercept that event.
 *
 * @param {tinymce.Editor} ed Editor instance that the plugin is initialised in
 * @param {string} url Absolute URL to where the plugin is located
 */
tinymce.PluginManager.add('rkdownloadmodule', function(editor, url) {
    var icon;

    icon = Zikula.Config.baseURL + Zikula.Config.baseURI + '/web/modules/rkdownload/images/admin.png';

    editor.addButton('rkdownloadmodule', {
        //text: 'Down load',
        image: icon,
        onclick: function() {
            RKDownLoadModuleFinderOpenPopup(editor, 'tinymce');
        }
    });
    editor.addMenuItem('rkdownloadmodule', {
        text: 'Down load',
        context: 'tools',
        image: icon,
        onclick: function() {
            RKDownLoadModuleFinderOpenPopup(editor, 'tinymce');
        }
    });

    return {
        getMetadata: function() {
            return {
                title: 'Down load',
                url: 'http://oldtimer-ig-osnabrueck.de'
            };
        }
    };
});
