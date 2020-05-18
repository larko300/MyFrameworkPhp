<div class="col-md-12">
    <div class="card">
        <div class="card-header"><h3>Профиль пользователя</h3></div>
        <div class="card-body">
            <div class="alert alert-success" role="alert">
                alert
            </div>
            <form action="/profile/validation" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Name</label>
                            <input type="text" class="form-control" name="name"  value="name">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Email</label>
                            <input type="email" class="form-control is-invalid" name="email" value="email">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Аватар</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="" alt="" class="img-fluid">
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-warning">Edit profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>