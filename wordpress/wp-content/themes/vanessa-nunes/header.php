<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <section id="header-top">
	        <div class="container">
	            <div class="row">
                    <div class ="col-lg-6 col-md-6 text-center text-md-right header-top-right">
                        <div class="row">
                            <div class ="col-lg-6 col-md-6 text-center text-md-right header-top-right">
                                <p><i class="fa fa-clock-o"></i>Redes Sociais</p>
                            </div> 
                            <div class ="col-lg-6 col-md-6 text-center text-md-right header-top-right">
                                <p> link </a>
                            </div>
                        </div>               
                    </div>
                    
                    <div class="col-lg-6 col-md-6 text-center text-md-right header-top-right">
                        <div class="row">
                            <div class ="col-lg-6 col-md-6 text-center text-md-right header-top-right"><a href="#"><i class="fa fa-envelope-o"></i>contato@blogvanessanunes.com.br</a></div>
                            <div class ="col-lg-6 col-md-6 text-center text-md-right header-top-right"><a href="#"><i class="fa fa-phone"></i>+51 12 97048-3776</a></div>
                        </div>       
	                </div>
					
	            </div>
	        </div>
	    </section>
        <nav id="nav-header" class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="<?php echo home_url(); ?>">Página Inicial</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class' => 'navbar-nav',
                        'container' => false,
                        'depth' => 2, // Permite menus com dois níveis (pai e filho)
                        'walker' => new WP_Bootstrap_Navwalker(),
                    ));
                    ?>
                </div>
            </div>
        </nav>

    </header>
