<?php foreach ($result as $contact_item){ ?>

    <h2><?php echo 'Hello' ?></h2>
    <div class="main">
        <?php echo $contact_item->name . "\n" ?>
        <?php echo $contact_item->url_key ?> 
    </div>

<?php } ?>


