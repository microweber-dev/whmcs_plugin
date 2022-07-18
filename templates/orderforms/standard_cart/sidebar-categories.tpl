{foreach $secondarySidebar as $panel}
    <div menuItemName="{$panel->getName()}" class="panel card card-sidebar mb-3 {if $panel->getClass()}{$panel->getClass()}{else}panel-sidebar{/if}{if $panel->getExtra('mobileSelect') and $panel->hasChildren()} hidden-sm hidden-xs d-none d-md-block{/if}"{if $panel->getAttribute('id')} id="{$panel->getAttribute('id')}"{/if}>
        <div class="panel-heading card-header">
            <h3 class="panel-title">
                {if $panel->hasIcon()}
                    <i class="{$panel->getIcon()}"></i>&nbsp;
                {/if}

                {$panel->getLabel()}

                {if $panel->hasBadge()}
                    &nbsp;<span class="badge">{$panel->getBadge()}</span>
                {/if}

                <i class="fas fa-chevron-up card-minimise panel-minimise pull-right float-right"></i>
            </h3>
        </div>

        {if $panel->hasBodyHtml()}
            <div class="panel-body card-body collapsable-card-body">
                {$panel->getBodyHtml()}
            </div>
        {/if}

        {if $panel->hasChildren()}
            <div class="list-group collapsable-card-body{if $panel->getChildrenAttribute('class')} {$panel->getChildrenAttribute('class')}{/if}">
                {foreach $panel->getChildren() as $child}
                    {if $child->getUri()}
                        <a menuItemName="{$child->getName()}" href="{$child->getUri()}" class="list-group-item list-group-item-action{if $child->isDisabled()} disabled{/if}{if $child->getClass()} {$child->getClass()}{/if}{if $child->isCurrent()} active{/if}"{if $child->getAttribute('dataToggleTab')} data-toggle="tab"{/if}{if $child->getAttribute('target')} target="{$child->getAttribute('target')}"{/if} id="{$child->getId()}">
                            {if $child->hasIcon()}
                                <i class="{$child->getIcon()}"></i>&nbsp;
                            {/if}

                            {$child->getLabel()}

                            {if $child->hasBadge()}
                                &nbsp;<span class="badge">{$child->getBadge()}</span>
                            {/if}
                        </a>
                    {else}
                        <div menuItemName="{$child->getName()}" class="list-group-item{if $child->getClass()} {$child->getClass()}{/if}" id="{$child->getId()}">
                            {if $child->hasIcon()}
                                <i class="{$child->getIcon()}"></i>&nbsp;
                            {/if}

                            {$child->getLabel()}

                            {if $child->hasBadge()}
                                &nbsp;<span class="badge">{$child->getBadge()}</span>
                            {/if}
                        </div>
                    {/if}
                {/foreach}
            </div>
        {/if}

        {if $panel->hasFooterHtml()}
            <div class="panel-footer card-footer clearfix">
                {$panel->getFooterHtml()}
            </div>
        {/if}
    </div>

    {if $panel->getExtra('mobileSelect') and $panel->hasChildren()}
        {* Mobile Select only supports dropdown menus *}
        <div class="panel card hidden-lg hidden-md d-md-none{if $panel->getClass()}{$panel->getClass()}{else} panel-default{/if}"{if $panel->getAttribute('id')} id="{$panel->getAttribute('id')}"{/if}>
            {include file="orderforms/standard_cart/sidebar-categories-selector.tpl"}
        </div>
    {/if}
{/foreach}
