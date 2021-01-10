<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1 class="introduction"><?php echo $config['title']; ?></h1>
    <p>This is the home page.</p>

    <?php if (isset($_SESSION['user'])) : ?>
        <p>Welcome, <?php echo $_SESSION['user']['usr_name']; ?>!</p>
    <?php endif; ?>

  
</article>

<?php require __DIR__ . '/views/footer.php'; ?>