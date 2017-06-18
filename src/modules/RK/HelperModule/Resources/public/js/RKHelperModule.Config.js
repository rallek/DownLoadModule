'use strict';

function helperToggleShrinkSettings(fieldName) {
    var idSuffix = fieldName.replace('rkhelpermodule_appsettings_', '');
    jQuery('#shrinkDetails' + idSuffix).toggleClass('hidden', !jQuery('#rkhelpermodule_appsettings_enableShrinkingFor' + idSuffix).prop('checked'));
}

jQuery(document).ready(function() {
    jQuery('.shrink-enabler').each(function (index) {
        jQuery(this).bind('click keyup', function (event) {
            helperToggleShrinkSettings(jQuery(this).attr('id').replace('enableShrinkingFor', ''));
        });
        helperToggleShrinkSettings(jQuery(this).attr('id').replace('enableShrinkingFor', ''));
    });
});
