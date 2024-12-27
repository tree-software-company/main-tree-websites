@extends('layouts.login')

@section('content')
<div class="admin-container">
  
  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <h2>Form Website Records</h2>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($formWebsite as $item)
      <tr>
        <td>{{ $item['id'] ?? 'N/A' }}</td>
        <td>{{ $item['name'] ?? 'N/A' }}</td>
        <td>
          <form action="{{ route('admin.sendEmail') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ $item['email'] }}">
            <input type="hidden" name="message" value="Hello {{ $item['name'] }}">
            <button type="submit" class="btn btn-primary">Send Email</button>
          </form>
        </td>
        <td>{{ $item['message'] ?? 'N/A' }}</td>
        <td>{{ ucfirst($item['status'] ?? 'not answered') }}</td>
        <td>
          <form action="{{ route('admin.updateFormWebsiteStatus') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $item['id'] }}">
            <select name="status" onchange="this.form.submit()" class="form-control">
              <option value="not answered" {{ ($item['status'] ?? '') == 'not answered' ? 'selected' : '' }}>Not Answered</option>
              <option value="answered" {{ ($item['status'] ?? '') == 'answered' ? 'selected' : '' }}>Answered</option>
            </select>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <h2>Landing Page Newsletter</h2>
  <table class="table">
    <thead>
      <tr>
        <th>Email</th>
        <th>Name</th>
      </tr>
    </thead>
    <tbody>
      @foreach($newsletter as $nl)
      <tr>
        <td>{{ $nl['email'] ?? 'N/A' }}</td>
        <td>{{ $nl['name'] ?? 'N/A' }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <h2>Users</h2>

  <form action="{{ route('admin.index') }}" method="GET" class="form-inline mb-4">
    <div class="form-group mr-2">
      <input type="text" name="search_first_name" class="form-control" placeholder="First Name" value="{{ request('search_first_name') }}">
    </div>
    <div class="form-group mr-2">
      <input type="text" name="search_last_name" class="form-control" placeholder="Last Name" value="{{ request('search_last_name') }}">
    </div>
    <div class="form-group mr-2">
      <input type="email" name="search_email" class="form-control" placeholder="Email" value="{{ request('search_email') }}">
    </div>
    <div class="form-group mr-2">
      <select name="search_user_type" class="form-control">
        <option value="">-- User Type --</option>
        <option value="user" {{ request('search_user_type') == 'user' ? 'selected' : '' }}>User</option>
        <option value="admin" {{ request('search_user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
    <a href="{{ route('admin.index') }}" class="btn btn-secondary ml-2">Reset</a>
  </form>

  <table class="table">
    <thead>
      <tr>
        <th>User ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Birthday</th>
        <th>Country</th>
        <th>User Type</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
      <tr>
        <td>{{ $user['user_id'] ?? 'N/A' }}</td>
        <td>{{ $user['first_name'] ?? 'N/A' }}</td>
        <td>{{ $user['last_name'] ?? 'N/A' }}</td>
        <td>{{ $user['email'] ?? 'N/A' }}</td>
        <td>{{ $user['phone'] ?? 'N/A' }}</td>
        <td>{{ isset($user['birthday']) ? \Carbon\Carbon::parse($user['birthday'])->format('Y-m-d') : 'N/A' }}</td>
        <td>{{ $user['country'] ?? 'N/A' }}</td>
        <td>
          <form action="{{ route('admin.updateUserType') }}" method="POST">
            @csrf
            <input type="hidden" name="userId" value="{{ $user['user_id'] }}">
            <select name="user_type" onchange="this.form.submit()" class="form-control">
              <option value="user" {{ ($user['user_type'] ?? '') == 'user' ? 'selected' : '' }}>User</option>
              <option value="admin" {{ ($user['user_type'] ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
          </form>
        </td>
        <td>
          <form action="{{ route('admin.updateUserPassword') }}" method="POST" class="form-inline">
            @csrf
            <input type="hidden" name="userId" value="{{ $user['user_id'] }}">
            <input type="password" name="newPassword" placeholder="New Password" class="form-control mr-2" required>
            <button type="submit" class="btn btn-warning">Change Password</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="9">No users found.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

</div>
@endsection