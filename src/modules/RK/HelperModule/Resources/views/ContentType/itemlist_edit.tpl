{* Purpose of this template: edit view of generic item list content type *}
<div class="form-group">
    {gt text='Object type' domain='rkhelpermodule' assign='objectTypeSelectorLabel'}
    {formlabel for='rKHelperModuleObjectType' text=$objectTypeSelectorLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {rkhelpermoduleObjectTypeSelector assign='allObjectTypes'}
        {formdropdownlist id='rKHelperModuleObjectType' dataField='objectType' group='data' mandatory=true items=$allObjectTypes cssClass='form-control'}
        <span class="help-block">{gt text='If you change this please save the element once to reload the parameters below.' domain='rkhelpermodule'}</span>
    </div>
</div>

<div class="form-group">
    {gt text='Sorting' domain='rkhelpermodule' assign='sortingLabel'}
    {formlabel text=$sortingLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formradiobutton id='rKHelperModuleSortRandom' value='random' dataField='sorting' group='data' mandatory=true}
        {gt text='Random' domain='rkhelpermodule' assign='sortingRandomLabel'}
        {formlabel for='rKHelperModuleSortRandom' text=$sortingRandomLabel}
        {formradiobutton id='rKHelperModuleSortNewest' value='newest' dataField='sorting' group='data' mandatory=true}
        {gt text='Newest' domain='rkhelpermodule' assign='sortingNewestLabel'}
        {formlabel for='rKHelperModuleSortNewest' text=$sortingNewestLabel}
        {formradiobutton id='rKHelperModuleSortDefault' value='default' dataField='sorting' group='data' mandatory=true}
        {gt text='Default' domain='rkhelpermodule' assign='sortingDefaultLabel'}
        {formlabel for='rKHelperModuleSortDefault' text=$sortingDefaultLabel}
    </div>
</div>

<div class="form-group">
    {gt text='Amount' domain='rkhelpermodule' assign='amountLabel'}
    {formlabel for='rKHelperModuleAmount' text=$amountLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formintinput id='rKHelperModuleAmount' dataField='amount' group='data' mandatory=true maxLength=2 cssClass='form-control'}
    </div>
</div>

<div class="form-group">
    {gt text='Template' domain='rkhelpermodule' assign='templateLabel'}
    {formlabel for='rKHelperModuleTemplate' text=$templateLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {rkhelpermoduleTemplateSelector assign='allTemplates'}
        {formdropdownlist id='rKHelperModuleTemplate' dataField='template' group='data' mandatory=true items=$allTemplates cssClass='form-control'}
    </div>
</div>

<div id="customTemplateArea" class="form-group"{* data-switch="rKHelperModuleTemplate" data-switch-value="custom"*}>
    {gt text='Custom template' domain='rkhelpermodule' assign='customTemplateLabel'}
    {formlabel for='rKHelperModuleCustomTemplate' text=$customTemplateLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formtextinput id='rKHelperModuleCustomTemplate' dataField='customTemplate' group='data' mandatory=false maxLength=80 cssClass='form-control'}
        <span class="help-block">{gt text='Example' domain='rkhelpermodule'}: <em>itemlist_[objectType]_display.html.twig</em></span>
    </div>
</div>

<div class="form-group">
    {gt text='Filter (expert option)' domain='rkhelpermodule' assign='filterLabel'}
    {formlabel for='rKHelperModuleFilter' text=$filterLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formtextinput id='rKHelperModuleFilter' dataField='filter' group='data' mandatory=false maxLength=255 cssClass='form-control'}
    </div>
</div>

<script type="text/javascript">
    (function($) {
    	$('#rKHelperModuleTemplate').change(function() {
    	    $('#customTemplateArea').toggleClass('hidden', $(this).val() != 'custom');
	    }).trigger('change');
    })(jQuery)
</script>
