{if isset($breadcrumbs) && $breadcrumbs}
<nav class="breadcrumbs" aria-label="Breadcrumb">
    {foreach $breadcrumbs as $crumb}
        {if $crumb@last}
            <span class="breadcrumbs__item breadcrumbs__item--current">{$crumb.title}</span>
        {else}
            <a href="{$crumb.url}" class="breadcrumbs__item">{$crumb.title}</a>
            <span class="breadcrumbs__sep">/</span>
        {/if}
    {/foreach}
</nav>
{/if}
