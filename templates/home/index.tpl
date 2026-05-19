{extends file="layouts/main.tpl"}

{block name="content"}
    {foreach $categories as $cat}
        <section class="category-section">
            <div class="category-section__header">
                <h2 class="category-section__title">
                    <a href="/category/{$cat.id}">{$cat.name}</a>
                </h2>
                <a href="/category/{$cat.id}" class="category-section__all">Все статьи &rarr;</a>
            </div>

            {if $cat.articles}
                <div class="articles-grid">
                    {foreach $cat.articles as $article}
                        <article class="article-card">
                            {if $article.image}
                                <a href="/article/{$article.id}" class="article-card__img-wrap">
                                    <img src="{$article.image}" alt="{$article.title}" class="article-card__img">
                                </a>
                            {/if}
                            <div class="article-card__body">
                                <h3 class="article-card__title">
                                    <a href="/article/{$article.id}">{$article.title}</a>
                                </h3>
                                {if $article.description}
                                    <p class="article-card__desc">{$article.description}</p>
                                {/if}
                                <div class="article-card__meta">
                                    <span class="article-card__date">{$article.created_at|date_format:"%d.%m.%Y"}</span>
                                    <span class="article-card__views">{$article.views} просм.</span>
                                </div>
                            </div>
                        </article>
                    {/foreach}
                </div>
            {else}
                <p class="empty">В этой категории пока нет статей.</p>
            {/if}
        </section>
    {foreachelse}
        <p class="empty">Категории не найдены.</p>
    {/foreach}
{/block}
