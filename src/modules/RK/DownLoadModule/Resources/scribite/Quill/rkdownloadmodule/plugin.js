var rkdownloadmodule = function(quill, options) {
    setTimeout(function() {
        var button;

        button = jQuery('button[value=rkdownloadmodule]');

        button
            .css('background', 'url(' + Zikula.Config.baseURL + Zikula.Config.baseURI + '/web/modules/rkdownload/images/admin.png) no-repeat center center transparent')
            .css('background-size', '16px 16px')
            .attr('title', 'Down load')
        ;

        button.click(function() {
            RKDownLoadModuleFinderOpenPopup(quill, 'quill');
        });
    }, 1000);
};
