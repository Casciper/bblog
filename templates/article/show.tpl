{extends file="layouts/main.tpl"}

{block name="content"}
    {include file="partials/breadcrumbs.tpl"}

    <article class="article">
        <header class="article__header">
            <h1 class="article__title">{$article.title}</h1>
            <div class="article__meta">
                <span class="article__date">{$article.created_at|date_format:"%d.%m.%Y"}</span>
                <span class="article__views">{$article.views} просм.</span>
                {if $categories}
                    <span class="article__categories">
                        {foreach $categories as $cat}
                            <a href="/category/{$cat.id}" class="article__category">{$cat.name}</a>{if !$cat@last}, {/if}
                        {/foreach}
                    </span>
                {/if}
            </div>
        </header>

        {if $article.image}
            <div class="article__img-wrap">
                <img src="{$article.image}" alt="{$article.title}" class="article__img">
            </div>
        {/if}

        {if $article.description}
            <p class="article__description">{$article.description}</p>
        {/if}

        <div class="article__text">
            {$article.text}
        </div>
    </article>

    {if $similar}
        <section class="similar">
            <h2 class="similar__title">Похожие статьи</h2>
            <div class="articles-grid">
                {foreach $similar as $item}
                    <article class="article-card">
                        {if $item.image}
                            <a href="/article/{$item.id}" class="article-card__img-wrap">
                                <img src="{$item.image}" alt="{$item.title}" class="article-card__img">
                            </a>
                        {else}
                            <div class="article-card__img-placeholder"></div>
                        {/if}
                        <div class="article-card__body">
                            <h3 class="article-card__title">
                                <a href="/article/{$item.id}">{$item.title}</a>
                            </h3>
                            {if $item.description}
                                <p class="article-card__desc">{$item.description}</p>
                            {/if}
                            <div class="article-card__meta">
                                <span class="article-card__date">{$item.created_at|date_format:"%d.%m.%Y"}</span>
                                <span class="article-card__views">{$item.views} просм.</span>
                            </div>
                        </div>
                    </article>
                {/foreach}
            </div>
        </section>
    {/if}
{/block}
