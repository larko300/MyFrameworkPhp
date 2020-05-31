<div class="col-md-12">
    <div class="card">
        <div class="card-header"><h3>Posts</h3></div>
        <?php

        foreach ($data as $post): ?>
        <div class="card-body">
            <div class="alert alert-success" role="alert">
                Alerts
            </div>
            <div class="media">
                <img src="../img/no-user.jpg" class="mr-3" alt="..." width="64" height="64">
                <div class="media-body">
                    <h5 class="mt-0"><?php echo $post['username'] ?></h5>
                    <span><small><?php echo $post['date'] ?></small></span>
                    <p><?php echo $post['body'] ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

