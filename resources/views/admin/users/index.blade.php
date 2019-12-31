@extends('layouts.template')

@section('title', 'Users')

@section('main')
    <h1>Users</h1>
    @csrf
    <form method="get" action="/admin/users" id="searchForm">
        @csrf
        <div class="row">
            <div class="col-sm-6 mb-2">
                <input type="text" class="form-control" name="name" id="name"
                       value="{{ request()->name }}" placeholder="Filter Name Or Email"/>
            </div>

            <div class="col-sm-6 mb-2">

                <select class="form-control" name="sorteren" id="sorteren">
                    <option value="Name asc" {{ request()->sorteren }}>Name (A => Z)</option>
                    <option value="Name Desc">Name (Z => A)</option>
                    <option value="Email Asc">Email (A => Z)</option>
                    <option value="Email Desc">Email (Z => A)</option>

                </select>
            </div>

            <div class="col-sm-2 mb-2">
                <button type="submit" class="btn btn-success btn-block">Search</button>
            </div>
        </div>

    </form>
    <hr>
    @if ($users->count() == 0)
        <div class="alert alert-danger alert-dismissible fade show">
            Can't find any user or email containing <b>'{{ request()->name }}'</b>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif
    {{ $users->links() }}
    @include('shared.alert')
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>user</th>
                <th>email</th>
                <th>active</th>
                <th>admin</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="userid">{{ $user->id }}</td>
                    <td class="name">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->active }}</td>
                    <td>{{ $user->admin }}</td>
                    <td>
                        <form action="/admin/genres/{{ $user->id }}" method="post">
                            @method('delete')
                            @csrf
                            <div class="btn-group btn-group-sm">
                                <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-outline-success"
                                   data-toggle="tooltip"
                                   title="Edit {{ $user->name }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#!" class="btn btn-outline-danger btn-delete"
                                   data-toggle="tooltip"
                                   title="Delete {{ $user->name }}">

                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('script_after')
    <script>
        $(function () {
            $('tbody').on('click', '.btn-delete', function () {
                // Get data attributes from td tag
                let id = $(this).closest('tr').find('.userid').text();
                let name = $(this).closest('tr').find('.name').text();
                // Set some values for Noty
                let text = `<p>Delete the user <b>${name}</b>?</p>`;
                let type = 'warning';
                let btnText = 'Delete user';
                let btnClass = 'btn-success';
                // Show Noty
                let modal = new Noty({
                    timeout: false,
                    layout: 'center',
                    modal: true,
                    type: type,
                    text: text,
                    buttons: [
                        Noty.button(btnText, `btn ${btnClass}`, function () {
                            // Delete genre and close modal
                            deleteUser(id);
                            modal.close();
                        }),
                        Noty.button('Cancel', 'btn btn-secondary ml-2', function () {
                            modal.close();
                        })
                    ]
                }).show();
            });
        });

        // Delete a genre
        function deleteUser(id) {
            // Delete the genre from the database
            let pars = {
                '_token': '{{ csrf_token() }}',
                '_method': 'delete'
            };
            $.post(`/admin/users/${id}`, pars, 'json')
                .done(function (data) {
                    console.log('data', data);
                    new Noty({
                        type: data.type,
                        text: data.text
                    }).show();
                    location.reload();
                })
                .fail(function (e) {
                    console.log('error', e);
                });
        }
</script>
@endsection
