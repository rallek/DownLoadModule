{* Purpose of this template: Display a popup selector for Forms and Content integration *}
{assign var='baseID' value='linker'}
<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <label for="{$baseID}Id" class="col-sm-3 control-label">{gt text='Linker'}:</label>
            <div class="col-sm-9">
                <select id="{$baseID}Id" name="id" class="form-control">
                    {foreach item='linker' from=$items}
                        <option value="{$linker->getKey()}"{if $selectedId eq $linker->getKey()} selected="selected"{/if}>{$linker->getLinkerHeadline()}</option>
                    {foreachelse}
                        <option value="0">{gt text='No entries found.'}</option>
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="{$baseID}Sort" class="col-sm-3 control-label">{gt text='Sort by'}:</label>
            <div class="col-sm-9">
                <select id="{$baseID}Sort" name="sort" class="form-control">
                    <option value="linkerImage"{if $sort eq 'linkerImage'} selected="selected"{/if}>{gt text='Linker image'}</option>
                    <option value="linkerHeadline"{if $sort eq 'linkerHeadline'} selected="selected"{/if}>{gt text='Linker headline'}</option>
                    <option value="linkerText"{if $sort eq 'linkerText'} selected="selected"{/if}>{gt text='Linker text'}</option>
                    <option value="theLink"{if $sort eq 'theLink'} selected="selected"{/if}>{gt text='The link'}</option>
                    <option value="boostrapSetting"{if $sort eq 'boostrapSetting'} selected="selected"{/if}>{gt text='Boostrap setting'}</option>
                    <option value="linkerLocale"{if $sort eq 'linkerLocale'} selected="selected"{/if}>{gt text='Linker locale'}</option>
                    <option value="sorting"{if $sort eq 'sorting'} selected="selected"{/if}>{gt text='Sorting'}</option>
                    <option value="linkerGroup"{if $sort eq 'linkerGroup'} selected="selected"{/if}>{gt text='Linker group'}</option>
                    <option value="createdDate"{if $sort eq 'createdDate'} selected="selected"{/if}>{gt text='Creation date'}</option>
                    <option value="createdBy"{if $sort eq 'createdBy'} selected="selected"{/if}>{gt text='Creator'}</option>
                    <option value="updatedDate"{if $sort eq 'updatedDate'} selected="selected"{/if}>{gt text='Update date'}</option>
                    <option value="updatedBy"{if $sort eq 'updatedBy'} selected="selected"{/if}>{gt text='Updater'}</option>
                </select>
                <select id="{$baseID}SortDir" name="sortdir" class="form-control">
                    <option value="asc"{if $sortdir eq 'asc'} selected="selected"{/if}>{gt text='ascending'}</option>
                    <option value="desc"{if $sortdir eq 'desc'} selected="selected"{/if}>{gt text='descending'}</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="{$baseID}SearchTerm" class="col-sm-3 control-label">{gt text='Search for'}:</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <input type="text" id="{$baseID}SearchTerm" name="q" class="form-control" />
                    <span class="input-group-btn">
                        <input type="button" id="rKHelperModuleSearchGo" name="gosearch" value="{gt text='Filter'}" class="btn btn-default" />
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div id="{$baseID}Preview" style="border: 1px dotted #a3a3a3; padding: .2em .5em">
            <p><strong>{gt text='Linker information'}</strong></p>
            {img id='ajaxIndicator' modname='core' set='ajax' src='indicator_circle.gif' alt='' class='hidden'}
            <div id="{$baseID}PreviewContainer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript">
/* <![CDATA[ */
    ( function($) {
        $(document).ready(function() {
            rKHelperModule.itemSelector.onLoad('{{$baseID}}', {{$selectedId|default:0}});
        });
    })(jQuery);
/* ]]> */
</script>
