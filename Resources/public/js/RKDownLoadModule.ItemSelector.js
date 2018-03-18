'use strict';

var rKDownLoadModule = {};

rKDownLoadModule.itemSelector = {};
rKDownLoadModule.itemSelector.items = {};
rKDownLoadModule.itemSelector.baseId = 0;
rKDownLoadModule.itemSelector.selectedId = 0;

rKDownLoadModule.itemSelector.onLoad = function (baseId, selectedId)
{
    rKDownLoadModule.itemSelector.baseId = baseId;
    rKDownLoadModule.itemSelector.selectedId = selectedId;

    // required as a changed object type requires a new instance of the item selector plugin
    jQuery('#rKDownLoadModuleObjectType').change(rKDownLoadModule.itemSelector.onParamChanged);

    jQuery('#' + baseId + '_catidMain').change(rKDownLoadModule.itemSelector.onParamChanged);
    jQuery('#' + baseId + '_catidsMain').change(rKDownLoadModule.itemSelector.onParamChanged);
    jQuery('#' + baseId + 'Id').change(rKDownLoadModule.itemSelector.onItemChanged);
    jQuery('#' + baseId + 'Sort').change(rKDownLoadModule.itemSelector.onParamChanged);
    jQuery('#' + baseId + 'SortDir').change(rKDownLoadModule.itemSelector.onParamChanged);
    jQuery('#rKDownLoadModuleSearchGo').click(rKDownLoadModule.itemSelector.onParamChanged);
    jQuery('#rKDownLoadModuleSearchGo').keypress(rKDownLoadModule.itemSelector.onParamChanged);

    rKDownLoadModule.itemSelector.getItemList();
};

rKDownLoadModule.itemSelector.onParamChanged = function ()
{
    jQuery('#ajaxIndicator').removeClass('hidden');

    rKDownLoadModule.itemSelector.getItemList();
};

rKDownLoadModule.itemSelector.getItemList = function ()
{
    var baseId;
    var params;

    baseId = rKDownLoadModule.itemSelector.baseId;
    params = {
        ot: baseId,
        sort: jQuery('#' + baseId + 'Sort').val(),
        sortdir: jQuery('#' + baseId + 'SortDir').val(),
        q: jQuery('#' + baseId + 'SearchTerm').val()
    }
    if (jQuery('#' + baseId + '_catidMain').length > 0) {
        params[catidMain] = jQuery('#' + baseId + '_catidMain').val();
    } else if (jQuery('#' + baseId + '_catidsMain').length > 0) {
        params[catidsMain] = jQuery('#' + baseId + '_catidsMain').val();
    }

    jQuery.getJSON(Routing.generate('rkdownloadmodule_ajax_getitemlistfinder'), params, function( data ) {
        var baseId;

        baseId = rKDownLoadModule.itemSelector.baseId;
        rKDownLoadModule.itemSelector.items[baseId] = data;
        jQuery('#ajaxIndicator').addClass('hidden');
        rKDownLoadModule.itemSelector.updateItemDropdownEntries();
        rKDownLoadModule.itemSelector.updatePreview();
    });
};

rKDownLoadModule.itemSelector.updateItemDropdownEntries = function ()
{
    var baseId, itemSelector, items, i, item;

    baseId = rKDownLoadModule.itemSelector.baseId;
    itemSelector = jQuery('#' + baseId + 'Id');
    itemSelector.length = 0;

    items = rKDownLoadModule.itemSelector.items[baseId];
    for (i = 0; i < items.length; ++i) {
        item = items[i];
        itemSelector.get(0).options[i] = new Option(item.title, item.id, false);
    }

    if (rKDownLoadModule.itemSelector.selectedId > 0) {
        jQuery('#' + baseId + 'Id').val(rKDownLoadModule.itemSelector.selectedId);
    }
};

rKDownLoadModule.itemSelector.updatePreview = function ()
{
    var baseId, items, selectedElement, i;

    baseId = rKDownLoadModule.itemSelector.baseId;
    items = rKDownLoadModule.itemSelector.items[baseId];

    jQuery('#' + baseId + 'PreviewContainer').addClass('hidden');

    if (items.length === 0) {
        return;
    }

    selectedElement = items[0];
    if (rKDownLoadModule.itemSelector.selectedId > 0) {
        for (var i = 0; i < items.length; ++i) {
            if (items[i].id == rKDownLoadModule.itemSelector.selectedId) {
                selectedElement = items[i];
                break;
            }
        }
    }

    if (null !== selectedElement) {
        jQuery('#' + baseId + 'PreviewContainer')
            .html(window.atob(selectedElement.previewInfo))
            .removeClass('hidden');
    }
};

rKDownLoadModule.itemSelector.onItemChanged = function ()
{
    var baseId, itemSelector, preview;

    baseId = rKDownLoadModule.itemSelector.baseId;
    itemSelector = jQuery('#' + baseId + 'Id').get(0);
    preview = window.atob(rKDownLoadModule.itemSelector.items[baseId][itemSelector.selectedIndex].previewInfo);

    jQuery('#' + baseId + 'PreviewContainer').html(preview);
    rKDownLoadModule.itemSelector.selectedId = jQuery('#' + baseId + 'Id').val();
};

jQuery(document).ready(function() {
    var infoElem;

    infoElem = jQuery('#itemSelectorInfo');
    if (infoElem.length == 0) {
        return;
    }

    rKDownLoadModule.itemSelector.onLoad(infoElem.data('base-id'), infoElem.data('selected-id'));
});
