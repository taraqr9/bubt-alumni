<!DOCTYPE html>
<html lang="en">

<head>
	@include('partials.head')
</head>

<body>
	<div class="wrapper">
		@include('partials.nav')
        <div class="main">
		@include('partials.top')

        @if(Auth::user()->admin == 1):
        <main class="content">
            <div class="container-fluid p-0">
                <div class="card flex-fill">
                    <div class="card-header">

                        <h5 class="card-title mb-0">All Members</h5>
                    </div>
                    <table class="table table-hover my-0">
                        <thead>
                        <tr>
                            <th class="d-none d-xl-table-cell">Name</th>
                            <th class="d-none d-xl-table-cell">Phone</th>
                            <th class="d-none d-xl-table-cell">Referred By</th>
                            <th class="d-none d-xl-table-cell">Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="d-none d-xl-table-cell">{{$user->name}}</td>
                                <td class="d-none d-xl-table-cell">{{$user->mobile}}</td>
                                <td class="d-none d-xl-table-cell">
                                    <a href="/user/{{App\Models\User::where('email', $user->information->reference)->get()->first()->id}}/profile">
                                        {{App\Models\User::where('email', $user->information->reference)->get()->first()->name}}
                                    </a>
                                </td>
                                <td class="d-none d-xl-table-cell"><span class="
                                @if($user->status == 0)
                                    {{ 'btn btn-info' }}
                                @elseif($user->status == 1)
                                    {{ 'btn btn-success' }}
                                @elseif($user->status == 2)
                                    {{ 'btn btn-warning' }}
                                @endif">
                                        {{\App\Enums\UserStatus::from($user?->status)->name}}</span></td>
                                <th class="d-none d-md-table-cell">
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="/user/{{$user->id}}/profile">
                                                View
                                            </a>
                                            <a class="dropdown-item" href="{{route("user.edit", ['id' => $user->id])}}">Edit</a>
                                            <a class="dropdown-item" href="{{route('user.status',['id'=>$user->id, 'status'=>1])}}">Approve</a>
                                            <a class="dropdown-item" href="{{route('user.status',['id'=>$user->id, 'status'=>2])}}">Decline</a>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="ml-auto mt-3 p-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </main>
        @endif

            @include('partials.footer')
        </div>
	</div>

	@include('partials.scripts')

    <script>
        const status = document.getElementById('status');
        console.log(status);
    </script>
</body>

</html>
