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
                            <th>Name</th>
                            <th class="d-none d-xl-table-cell">Email</th>
                            <th class="d-none d-xl-table-cell">Join At</th>
                            <th></th>
                            <th></th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\Models\User::where('admin',0)->get() as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td class="d-none d-xl-table-cell">{{$user->email}}</td>
                                <td class="d-none d-xl-table-cell">{{$user->created_at}}</td>
                                <td><a href="{{route('user.profile', $user->email)}}"><button class="btn btn-success">View</button></a></td>
                                <th class="d-none d-md-table-cell">
                                    <button class="btn btn-success">Success</button>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        @endif

            @include('partials.footer')
        </div>
	</div>

	@include('partials.scripts')
</body>

</html>
