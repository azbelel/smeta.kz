@extends('layouts.app')

@section('content')
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
@endsection

@section('scripts')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.update').editable({
            url: '/update-user',
            type: 'text',
            pk: 1,
            name: 'name',
            title: 'Enter name'
        });

    </script>
@endsection
