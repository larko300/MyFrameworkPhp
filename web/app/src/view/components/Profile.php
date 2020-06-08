<div class="col-md-12">
    <div class="card">
        <div class="card-header"><h3>Профиль пользователя</h3></div>
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
            <?php if (!empty($data['error'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $data['error'] ?>
                </div>
            <?php endif; ?>
            <form action="/users/profile" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Name</label>
                            <input type="text" class="form-control" name="name"  value="<?php echo ($_POST) ? $_POST['name'] : $data['user']->getName() ?>">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo ($_POST) ? $_POST['email'] : $data['user']->getEmail() ?>">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Аватар</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="<?php echo (($data['user']->getImage() !== null)) ? $_SERVER['DOCUMENT_ROOT'] . '../app/src/img/' . $user->getImage()  : $_SERVER['DOCUMENT_ROOT'] . '/../app/src/img/no-user.jpg'?>" alt="" class="img-fluid">
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-warning">Edit profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>