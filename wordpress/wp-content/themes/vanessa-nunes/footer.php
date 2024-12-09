<footer class="">
    <section class="bg-dark text-white p-4">
        <div class="container">
            <div class="row">
                <!-- Widget 1 -->
                <div class="col-md-3 col-sm-6">
                    <div class="footer-widget">
                        <?php 
                        if (is_active_sidebar('footer-widget-1')) {
                            dynamic_sidebar('footer-widget-1');
                        }
                        ?>
                    </div>
                </div>

                <!-- Widget 2 -->
                <div class="col-md-3 col-sm-6">
                    <div class="footer-widget">
                        <?php 
                        if (is_active_sidebar('footer-widget-2')) {
                            dynamic_sidebar('footer-widget-2');
                        }
                        ?>
                    </div>
                </div>

                <!-- Widget 3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="footer-widget">
                        <?php 
                        if (is_active_sidebar('footer-widget-3')) {
                            dynamic_sidebar('footer-widget-3');
                        }
                        ?>
                    </div>
                </div>

                <!-- Widget 4 -->
                <div class="col-md-3 col-sm-6">
                    <div class="footer-widget">
                        <?php 
                        if (is_active_sidebar('footer-widget-4')) {
                            dynamic_sidebar('footer-widget-4');
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-light text-center py-3">
        <!-- Copyright -->
        <div class="container">
            <p class="mb-0">&copy; <?php echo date("Y") . " " . get_bloginfo('name'); ?> - Todos os direitos reservados.</p>
        </div>
    </section>
</footer>
