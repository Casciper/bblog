{extends file="layouts/main.tpl"}

{block name="content"}
    <div class="category-header">
        <h1 class="category-header__title">{$category.name}</h1>
        {if $category.description}
            <p class="category-header__desc">{$category.description}</p>
        {/if}
    </div>

    <div class="category-toolbar">
        <span class="category-toolbar__label">Сортировка:</span>
        <a href="?sort=date" class="category-toolbar__link{if $sort === 'date'} category-toolbar__link--active{/if}">По дате</a>
        <a href="?sort=views" class="category-toolbar__link{if $sort === 'views'} category-toolbar__link--active{/if}">По просмотрам</a>
        <a href="?sort=title" class="category-toolbar__link{if $sort === 'title'} category-toolbar__link--active{/if}">По названию</a>
    </div>

    {if $articles}
        <div class="articles-grid">
            {foreach $articles as $article}
                <article class="article-card">
                    {if $article.image}
                        <a href="/article/{$article.id}" class="article-card__img-wrap">
                            <img src="{$article.image}" alt="{$article.title}" class="article-card__img">
                        </a>
                    {/if}
                    <div class="article-card__body">
                        <h2 class="article-card__title">
                            <a href="/article/{$article.id}">{$article.title}</a>
                        </h2>
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

        {if $pages > 1}
            <nav class="pagination">
                {if $page > 1}
                    <a href="/category/{$category.id}{if $page > 2}/p{$page-1}{/if}?sort={$sort}" class="pagination__link">&laquo;</a>
                {/if}

                {for $i = 1 to $pages}
                    {if $i === $page}
                        <span class="pagination__link pagination__link--active">{$i}</span>
                    {else}
                        <a href="/category/{$category.id}{if $i > 1}/p{$i}{/if}?sort={$sort}" class="pagination__link">{$i}</a>
                    {/if}
                {/for}

                {if $page < $pages}
                    <a href="/category/{$category.id}/p{$page+1}?sort={$sort}" class="pagination__link">&raquo;</a>
                {/if}
            </nav>
        {/if}
    {else}
        <p class="empty">В этой категории пока нет статей.</p>
    {/if}
{/block}
