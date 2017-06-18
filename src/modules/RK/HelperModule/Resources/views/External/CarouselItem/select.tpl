{* Purpose of this template: Display a popup selector for Forms and Content integration *}
{assign var='baseID' value='carouselItem'}
<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <label for="{$baseID}Id" class="col-sm-3 control-label">{gt text='Carousel item'}:</label>
            <div class="col-sm-9">
                <select id="{$baseID}Id" name="id" class="form-control">
                    {foreach item='carouselItem' from=$items}
                        <option value="{$carouselItem->getKey()}"{if $selectedId eq $carouselItem->getKey()} selected="selected"{/if}>{$carouselItem->getItemName()}</option>
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
                    <option value="itemName"{if $sort eq 'itemName'} selected="selected"{/if}>{gt text='Item name'}</option>
                    <option value="title"{if $sort eq 'title'} selected="selected"{/if}>{gt text='Title'}</option>
                    <option value="subtitle"{if $sort eq 'subtitle'} selected="selected"{/if}>{gt text='Subtitle'}</option>
                    <option value="link"{if $sort eq 'link'} selected="selected"{/if}>{gt text='Link'}</option>
                    <option value="itemImage"{if $sort eq 'itemImage'} selected="selected"{/if}>{gt text='Item image'}</option>
                    <option value="titleColor"{if $sort eq 'titleColor'} selected="selected"{/if}>{gt text='Title color'}</option>
                    <option value="itemStartDate"{if $sort eq 'itemStartDate'} selected="selected"{/if}>{gt text='Item start date'}</option>
                    <option value="intemEndDate"{if $sort eq 'intemEndDate'} selected="selected"{/if}>{gt text='Intem end date'}</option>
                    <option value="singleItemIdentifier"{if $sort eq 'singleItemIdentifier'} selected="selected"{/if}>{gt text='Single item identifier'}</option>
                    <option value="itemLocale"{if $sort eq 'itemLocale'} selected="selected"{/if}>{gt text='Item locale'}</option>
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
            <p><strong>{gt text='Carousel item information'}</strong></p>
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
