'use strict';

var currentRKDownLoadModuleEditor = null;
var currentRKDownLoadModuleInput = null;

/**
 * Returns the attributes used for the popup window. 
 * @return {String}
 */
function getRKDownLoadModulePopupAttributes()
{
    var pWidth, pHeight;

    pWidth = screen.width * 0.75;
    pHeight = screen.height * 0.66;

    return 'width=' + pWidth + ',height=' + pHeight + ',scrollbars,resizable';
}

/**
 * Open a popup window with the finder triggered by a CKEditor button.
 */
function RKDownLoadModuleFinderCKEditor(editor, downloUrl)
{
    // Save editor for access in selector window
    currentRKDownLoadModuleEditor = editor;

    editor.popup(
        Routing.generate('rkdownloadmodule_external_finder', { objectType: 'file', editor: 'ckeditor' }),
        /*width*/ '80%', /*height*/ '70%',
        'location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,scrollbars=yes'
    );
}


var rKDownLoadModule = {};

rKDownLoadModule.finder = {};

rKDownLoadModule.finder.onLoad = function (baseId, selectedId)
{
    if (jQuery('#rKDownLoadModuleSelectorForm').length < 1) {
        return;
    }
    jQuery('select').not("[id$='pasteAs']").change(rKDownLoadModule.finder.onParamChanged);
    
    jQuery('.btn-default').click(rKDownLoadModule.finder.handleCancel);

    var selectedItems = jQuery('#rkdownloadmoduleItemContainer a');
    selectedItems.bind('click keypress', function (event) {
        event.preventDefault();
        rKDownLoadModule.finder.selectItem(jQuery(this).data('itemid'));
    });
};

rKDownLoadModule.finder.onParamChanged = function ()
{
    jQuery('#rKDownLoadModuleSelectorForm').submit();
};

rKDownLoadModule.finder.handleCancel = function (event)
{
    var editor;

    event.preventDefault();
    editor = jQuery("[id$='editor']").first().val();
    if ('tinymce' === editor) {
        rKDownLoadClosePopup();
    } else if ('ckeditor' === editor) {
        rKDownLoadClosePopup();
    } else {
        alert('Close Editor: ' + editor);
    }
};


function rKDownLoadGetPasteSnippet(mode, itemId)
{
    var quoteFinder;
    var itemPath;
    var itemUrl;
    var itemTitle;
    var itemDescription;
    var pasteMode;

    quoteFinder = new RegExp('"', 'g');
    itemPath = jQuery('#path' + itemId).val().replace(quoteFinder, '');
    itemUrl = jQuery('#url' + itemId).val().replace(quoteFinder, '');
    itemTitle = jQuery('#title' + itemId).val().replace(quoteFinder, '').trim();
    itemDescription = jQuery('#desc' + itemId).val().replace(quoteFinder, '').trim();
    pasteMode = jQuery("[id$='pasteAs']").first().val();

    // item ID
    if (pasteMode === '3') {
        return '' + itemId;
    }

    // relative link to detail page
    if (pasteMode === '1') {
        return mode === 'url' ? itemPath : '<a href="' + itemPath + '" title="' + itemDescription + '">' + itemTitle + '</a>';
    }
    // absolute url to detail page
    if (pasteMode === '2') {
        return mode === 'url' ? itemUrl : '<a href="' + itemUrl + '" title="' + itemDescription + '">' + itemTitle + '</a>';
    }

    return '';
}


// User clicks on "select item" button
rKDownLoadModule.finder.selectItem = function (itemId)
{
    var editor, html;

    editor = jQuery("[id$='editor']").first().val();
    if ('tinymce' === editor) {
        html = rKDownLoadGetPasteSnippet('html', itemId);
        tinyMCE.activeEditor.execCommand('mceInsertContent', false, html);
        // other tinymce commands: mceImage, mceInsertLink, mceReplaceContent, see http://www.tinymce.com/wiki.php/Command_identifiers
    } else if ('ckeditor' === editor) {
        if (null !== window.opener.currentRKDownLoadModuleEditor) {
            html = rKDownLoadGetPasteSnippet('html', itemId);

            window.opener.currentRKDownLoadModuleEditor.insertHtml(html);
        }
    } else {
        alert('Insert into Editor: ' + editor);
    }
    rKDownLoadClosePopup();
};

function rKDownLoadClosePopup()
{
    window.opener.focus();
    window.close();
}

jQuery(document).ready(function() {
    rKDownLoadModule.finder.onLoad();
});
