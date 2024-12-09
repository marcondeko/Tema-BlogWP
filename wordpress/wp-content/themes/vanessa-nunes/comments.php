<?php
// Verifica se os comentários estão habilitados para este post
if ( post_password_required() ) {
    return;
}
?>

<!-- Se houver comentários, exibe a lista de comentários -->
<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ( '1' === $comment_count ) {
                printf( _x( 'One comment on &ldquo;%s&rdquo;', 'comments title', 'meu-tema' ), get_the_title() );
            } else {
                printf(
                    _nx( '%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'meu-tema' ),
                    number_format_i18n( $comment_count ), get_the_title()
                );
            }
            ?>
        </h2>

        <!-- Lista os comentários -->
        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 64,
            ) );
            ?>
        </ol>

        <!-- Navegação de comentários -->
        <?php the_comments_navigation(); ?>

    <?php endif; // Se não houver comentários, exibe a mensagem abaixo ?>

    <?php
    // Exibe a mensagem se os comentários estiverem fechados
    if ( ! comments_open() && $comment_count ) :
    ?>
        <p class="no-comments"><?php _e( 'Comentários estão fechados.', 'meu-tema' ); ?></p>
    <?php endif; ?>

</div><!-- .comments-area -->

<?php
// Exibe o formulário de comentários
comment_form();
?>
