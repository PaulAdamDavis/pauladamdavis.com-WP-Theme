


	</div><!-- end .wrapper -->

    <footer id="footer">
        <div class="wrapper">
            <small>&copy; 2010-<?php echo date('y'); ?> <?php bloginfo('name'); ?> – Connect on Twitter, predictably as <a href="http://twitter.com/pauladamdavis">@PaulAdamDavis</a></small>
        </div>
    </footer>

    <!-- JavaScript -->
    <?php if ($_SERVER['HTTP_HOST'] == 'pad.dev') : ?>
        <script src="<?php bloginfo('template_url'); ?>/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php bloginfo("template_url"); ?>/js/jquery.fancybox.pack.js?v=2.1.4"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/scripts.js"></script>
    <?php else : ?>
        <script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php bloginfo('template_url'); ?>/js/jquery-1.9.1.min.js"><\/script>')</script>
        <script src="<?php bloginfo('template_url'); ?>/js/scripts.min.js"></script>
    <?php endif; ?>
    <?php wp_footer(); ?>

    <!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->

</body>
</html>