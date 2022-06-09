<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">



    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div style="margin-left: 3%">All Users</div><br><br>

    {{-- <a href="{{ route('users.create') }}" style="color: blue">Add New User</a> --}}

    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
        Add new User
    </button>
    <br><br>

    <div class="card-content collapse show">
        <div class="card-body card-dashboard">
            <table class="table display nowrap table-striped table-bordered scroll-horizontal">
                <thead class="">
                    <tr>
                        <th>#</th>
                        <th>User Name </th>
                        <th>User Email </th>
                        <th>User phone </th>
                    </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
            <div class="justify-content-center d-flex">

            </div>
        </div>
    </div>

    <!-- add_modal_User -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" id="userModal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add new User </h4>
                </div>
                <div class="modal-body">
                    <!-- add_form -->
                    <form action="" id="UserForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">User Name</label>
                            <input type="text" class="form-control" name="name" placeholder="User Name">
                            <small id="user_name" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">User Email</label>
                            <input type="email" class="form-control" name="email" placeholder="User Email">
                            <small id="user_email" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">User Phone</label>
                            <input type="text" class="form-control" name="phone" placeholder="User Phone">
                            <small id="user_phone" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">User image</label>
                            <input type="file" id="file" class="form-control" name="image">

                            <small id="photo_error" class="form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">User Password</label>
                            <input type="password" class="form-control" name="password" placeholder="User password">
                            <small id="user_password" class="form-text text-danger"></small>
                        </div>

                        <br><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="save_user" class="btn btn-success">Submit</button>
                </div>
            </div>

        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(e) {

            fetchUsers();

            function fetchUsers() {

                $.ajax({
                    type: 'GET',
                    enctype: 'multipart/form-data',
                    url: "/Allusers",
                    dataType: "json",
                   
                    success: function(response) {
                        $('tbody').html("");
                        $.each(response.users, function(key, item) {
                            $('tbody').append('<tr>\
                                <td>' + item.id + '</td>\
                                <td>' + item.name + '</td>\
                                <td>' + item.email + '</td>\
                                <td>' + item.phone + '</td>\
                             </tr>');
                        });
                    },
                });

            }


            $(document).on('click', '#save_user', function(e) {
                e.preventDefault();

                var formData = new FormData($('#UserForm')[0]);

                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{ route('users.store') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(data) {
                        $("#myModal").modal('hide');
                        fetchUsers();
                    },
                    error: function(reject) {
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function(key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                    }
                });
            });

        });
    </script>
</body>

</html>
