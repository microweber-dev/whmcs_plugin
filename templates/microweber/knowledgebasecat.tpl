<form role="form" method="post" action="{routePath('knowledgebase-search')}">
    <div class="input-group input-group-lg kb-search">
        <input type="text"  id="inputKnowledgebaseSearch" name="search" class="form-control" placeholder="{$LANG.clientHomeSearchKb}" value="{$searchterm}" />
        <span class="input-group-btn">
            <input type="submit" id="btnKnowledgebaseSearch" class="whmc-kbtn btn-input-padded-responsive" value="{$LANG.search}" />
        </span>
    </div>
</form>

{if $kbcats}
    <h2>{$LANG.knowledgebasecategories}</h2>

    <div class="row kbcategories">
        {foreach name=kbasecats from=$kbcats item=kbcat}
            <div class="col-sm-4">
                <a href="{routePath('knowledgebase-category-view',{$kbcat.id},{$kbcat.urlfriendlyname})}">
                    <span class="glyphicon glyphicon-folder-close"></span> {$kbcat.name} <span class="badge badge-info">{$kbcat.numarticles}</span>
                </a>
                {if $kbcat.editLink}
                    <a href="{$kbcat.editLink}" class="admin-inline-edit">
                        <i class="fas fa-pencil-alt fa-fw"></i>
                        {$LANG.edit}
                    </a>
                {/if}
                <p>{$kbcat.description}</p>
            </div>
        {/foreach}
    </div>
{/if}

{if $kbarticles || !$kbcats}
    {if $tag}
        <h2>{$LANG.kbviewingarticlestagged} '{$tag}'</h2>
    {else}
        <h2>{$LANG.knowledgebasearticles}</h2>
    {/if}

    <div class="kbarticles">
        {foreach from=$kbarticles item=kbarticle}
            <a href="{routePath('knowledgebase-article-view', {$kbarticle.id}, {$kbarticle.urlfriendlytitle})}">
                <span class="glyphicon glyphicon-file"></span>&nbsp;{$kbarticle.title}
            </a>
            {if $kbarticle.editLink}
                <a href="{$kbarticle.editLink}" class="admin-inline-edit">
                    <i class="fas fa-pencil-alt fa-fw"></i>
                    {$LANG.edit}
                </a>
            {/if}
            <p>{$kbarticle.article|truncate:100:"..."}</p>
        {foreachelse}
            {include file="$template/includes/alert.tpl" type="info" msg=$LANG.knowledgebasenoarticles textcenter=true}
        {/foreach}
    </div>
{/if}
