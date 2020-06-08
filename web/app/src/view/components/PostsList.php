<div class="col-md-12">
    <div class="card">
        <div class="card-header"><h3>Posts</h3></div>
        <?php foreach ($data['posts'] as $post) :?>
        <div class="card-body">
            <?php
            if (!empty($_SESSION['flesh'])) :
                ?>
                <div class="alert alert-success" role="alert">
                    <?= $_SESSION['flesh'] ?>
                </div>
                <?php
                unset($_SESSION['flesh']);
            endif;
            ?>
            <div class="media">
                <img src="<?php echo ($post->getOwner()->getImage() !== null) ? $_SERVER['DOCUMENT_ROOT'] . '../app/src/img/' . $post->getOwner()->getImage()  : $_SERVER['DOCUMENT_ROOT'] . '/../app/src/img/no-user.jpg'?>" class="mr-3" alt="..." width="64" height="64">
                <div class="media-body">
                    <h5 class="mt-0"><?= $post->getOwner()->getName() ?></h5>
                    <span><small><?= $post->getDate(); ?></small></span>
                    <p><?= $post->getBody() ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
