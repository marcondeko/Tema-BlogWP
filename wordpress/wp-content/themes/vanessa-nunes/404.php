<?php get_header(); ?>

<div class="container">
    <h1>Desculpe, a página não foi encontrada!</h1>
    <p>O conteúdo que você está procurando não está disponível. Tente procurar usando o formulário abaixo ou volte para a página inicial.</p>

    <?php get_search_form(); ?>

    <a href="<?php echo home_url(); ?>" class="btn btn-primary">Voltar para a Página Inicial</a>
</div>

<?php get_footer(); ?>
