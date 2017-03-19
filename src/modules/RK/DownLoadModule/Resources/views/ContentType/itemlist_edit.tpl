{* Purpose of this template: edit view of generic item list content type *}
<div class="form-group">
    {gt text='Object type' domain='rkdownloadmodule' assign='objectTypeSelectorLabel'}
    {formlabel for='rKDownLoadModuleObjectType' text=$objectTypeSelectorLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {rkdownloadmoduleObjectTypeSelector assign='allObjectTypes'}
        {formdropdownlist id='rKDownLoadModuleObjectType' dataField='objectType' group='data' mandatory=true items=$allObjectTypes cssClass='form-control'}
        <span class="help-block">{gt text='If you change this please save the element once to reload the parameters below.' domain='rkdownloadmodule'}</span>
    </div>
</div>

{if $featureActivationHelper->isEnabled(constant('RK\\DownLoadModule\\Helper\\FeatureActivationHelper::CATEGORIES'), $objectType)}
{formvolatile}
{if $properties ne null && is_array($properties)}
    {nocache}
    {foreach key='registryId' item='registryCid' from=$registries}
        {assign var='propName' value=''}
        {foreach key='propertyName' item='propertyId' from=$properties}
            {if $propertyId eq $registryId}
                {assign var='propName' value=$propertyName}
            {/if}
        {/foreach}
        <div class="form-group">
            {assign var='hasMultiSelection' value=$categoryHelper->hasMultipleSelection($objectType, $propertyName)}
            {gt text='Category' domain='rkdownloadmodule' assign='categorySelectorLabel'}
            {assign var='selectionMode' value='single'}
            {if $hasMultiSelection eq true}
                {gt text='Categories' domain='rkdownloadmodule' assign='categorySelectorLabel'}
                {assign var='selectionMode' value='multiple'}
            {/if}
            {formlabel for="rKDownLoadModuleCatIds`$propertyName`" text=$categorySelectorLabel cssClass='col-sm-3 control-label'}
            <div class="col-sm-9">
                {formdropdownlist id="rKDownLoadModuleCatIds`$propName`" items=$categories.$propName dataField="catids`$propName`" group='data' selectionMode=$selectionMode cssClass='form-control'}
                <span class="help-block">{gt text='This is an optional filter.' domain='rkdownloadmodule'}</span>
            </div>
        </div>
    {/foreach}
    {/nocache}
{/if}
{/formvolatile}
{/if}

<div class="form-group">
    {gt text='Sorting' domain='rkdownloadmodule' assign='sortingLabel'}
    {formlabel text=$sortingLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formradiobutton id='rKDownLoadModuleSortRandom' value='random' dataField='sorting' group='data' mandatory=true}
        {gt text='Random' domain='rkdownloadmodule' assign='sortingRandomLabel'}
        {formlabel for='rKDownLoadModuleSortRandom' text=$sortingRandomLabel}
        {formradiobutton id='rKDownLoadModuleSortNewest' value='newest' dataField='sorting' group='data' mandatory=true}
        {gt text='Newest' domain='rkdownloadmodule' assign='sortingNewestLabel'}
        {formlabel for='rKDownLoadModuleSortNewest' text=$sortingNewestLabel}
        {formradiobutton id='rKDownLoadModuleSortDefault' value='default' dataField='sorting' group='data' mandatory=true}
        {gt text='Default' domain='rkdownloadmodule' assign='sortingDefaultLabel'}
        {formlabel for='rKDownLoadModuleSortDefault' text=$sortingDefaultLabel}
    </div>
</div>

<div class="form-group">
    {gt text='Amount' domain='rkdownloadmodule' assign='amountLabel'}
    {formlabel for='rKDownLoadModuleAmount' text=$amountLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formintinput id='rKDownLoadModuleAmount' dataField='amount' group='data' mandatory=true maxLength=2 cssClass='form-control'}
    </div>
</div>

<div class="form-group">
    {gt text='Template' domain='rkdownloadmodule' assign='templateLabel'}
    {formlabel for='rKDownLoadModuleTemplate' text=$templateLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {rkdownloadmoduleTemplateSelector assign='allTemplates'}
        {formdropdownlist id='rKDownLoadModuleTemplate' dataField='template' group='data' mandatory=true items=$allTemplates cssClass='form-control'}
    </div>
</div>

<div id="customTemplateArea" class="form-group"{* data-switch="rKDownLoadModuleTemplate" data-switch-value="custom"*}>
    {gt text='Custom template' domain='rkdownloadmodule' assign='customTemplateLabel'}
    {formlabel for='rKDownLoadModuleCustomTemplate' text=$customTemplateLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formtextinput id='rKDownLoadModuleCustomTemplate' dataField='customTemplate' group='data' mandatory=false maxLength=80 cssClass='form-control'}
        <span class="help-block">{gt text='Example' domain='rkdownloadmodule'}: <em>itemlist_[objectType]_display.html.twig</em></span>
    </div>
</div>

<div class="form-group">
    {gt text='Filter (expert option)' domain='rkdownloadmodule' assign='filterLabel'}
    {formlabel for='rKDownLoadModuleFilter' text=$filterLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formtextinput id='rKDownLoadModuleFilter' dataField='filter' group='data' mandatory=false maxLength=255 cssClass='form-control'}
        {*<span class="help-block">
            <a class="fa fa-filter" data-toggle="modal" data-target="#filterSyntaxModal">{gt text='Show syntax examples' domain='rkdownloadmodule'}</a>
        </span>*}
    </div>
</div>

{*include file='include_filterSyntaxDialog.tpl'*}

<script type="text/javascript">
    (function($) {
    	$('#rKDownLoadModuleTemplate').change(function() {
    	    $('#customTemplateArea').toggleClass('hidden', $(this).val() != 'custom');
	    }).trigger('change');
    })(jQuery)
</script>
