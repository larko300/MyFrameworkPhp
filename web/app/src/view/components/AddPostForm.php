<div class="col-md-12" style="margin-top: 20px;">
    <div class="card">
        <div class="card-header"><h3>Add post</h3></div>
        <div class="card-body">
            <?php
            if (!empty($data['user'])) {
            ?>
                <form action="/posts/create" method="post">
                    <div class="form-group">
                        <textarea name="body" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Create</button>
                </form>
            <?php
            } else {
             ?>
                <h4>Что бы оставить комментарий <a href="/users/login">войдите</a> или <a href="/users/register">зарегистрируйтесь</a></h4>
            <?php
            }
            ?>
        </div>
    </div>
</div>