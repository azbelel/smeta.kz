<!DOCTYPE html>

<html>

<head>

    <title>Laravel Ajax Request using X-editable bootstrap Plugin Example</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}

{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}

{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
    <script src="//code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

</head>

<body>

<div class="container">

    <h3>Laravel Ajax Request using X-editable bootstrap Plugin Example</h3>

    <table class="table table-bordered">

        <tr>

            <th>Name</th>

            <th>Email</th>

            <th width="100px">Action</th>

        </tr>

        @foreach($users as $user)

            <tr>

                <td><a href="" class="update" data-name="name" data-type="text" data-pk="{{ $user->id }}" data-title="Enter name">{{ $user->name }}</a></td>

                <td><a href="" class="update" data-name="email" data-type="email" data-pk="{{ $user->id }}" data-title="Enter email">{{ $user->email }}</a></td>

                <td><button class="btn btn-danger btn-sm">Delete</button></td>

            </tr>

        @endforeach

    </table>

</div>

</body>



<script type="text/javascript">
    window.onload=(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.update').editable({
            mode:'inline',
            url: '/update-user',
            type: 'text',
            pk: 1,
            name: 'name',
            title: 'Enter name'
        });
    });
</script>
</html>