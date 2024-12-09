<?php get_header(); ?>

<main class="container">
    <div class="row">
        <div class="col-md-8">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1><?php the_title(); ?></h1>
                    <div class="post-meta">
                        <p>Publicado em <?php the_date(); ?> por <?php the_author(); ?></p>
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
            <?php endwhile; else : ?>
                <p>Desculpe, essa página não existe.</p>
            <?php endif; ?>
        </div>
        <aside class="col-md-4">
            <?php get_sidebar(); ?>
            
        </aside>
    </div>
</main>

<?php get_footer(); ?>
