<nav>
    <ul>
        <li><a href="<?= HOST_NAME; ?>"><i class="fa fa-home"></i>&nbsp; Home</a></li>
        <?php echo Category::renderNavigation(); ?>
    </ul>
    <form>
        <input type="text" placeholder="search....">
        <button><i class="fa fa-search"></i></button>
    </form>
</nav>