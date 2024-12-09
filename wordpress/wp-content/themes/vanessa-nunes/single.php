<?php get_header(); ?>

<main class="container pt-4 bg-white">
    <div class="row">
        <div class="col-md-8">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1><?php the_title(); ?></h1>
                    <div class="post-meta">
                        <p>Publicado em <?php the_date(); ?> por <?php the_author(); ?></p>
                        <p><?php the_category(', '); ?></p>
                    </div>
                    <div class="post-thumbnail">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
                        <?php endif; ?>
                    </div>
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>
                </article>
                <nav class="post-navigation">
                    <div class="nav-previous"><?php previous_post_link('%link', '← Post Anterior'); ?></div>
                    <div class="nav-next"><?php next_post_link('%link', 'Próximo Post →'); ?></div>
                </nav>
                <?php
                // Exibir comentários, se habilitados
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            <?php endwhile; else : ?>
                <p>Desculpe, nenhum conteúdo foi encontrado.</p>
            <?php endif; ?>
        </div>
        <aside class="col-md-4">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</main>

<?php get_footer(); ?>
