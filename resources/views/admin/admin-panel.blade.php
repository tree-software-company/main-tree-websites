@extends('layouts.app')
@section('content')
<div class="admin-container">
  <h2>form_website Records</h2>
  <table class="table">
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Status</th><th>Action</th></tr>
    @foreach($formWebsite as $item)
    <tr>
      <td>{{ $item['id'] ?? '' }}</td>
      <td>{{ $item['name'] ?? '' }}</td>
      <td>
        <form action="{{ route('admin.sendEmail') }}" method="POST">
          @csrf
          <input type="hidden" name="email" value="{{ $item['email'] }}">
          <input type="hidden" name="message" value="Hello {{ $item['name'] }}">
          <button type="submit">{{ $item['email'] }}</button>
        </form>
      </td>
      <td>{{ $item['message'] ?? '' }}</td>
      <td>{{ $item['status'] ?? 'not answered' }}</td>
      <td>
        <form action="{{ route('admin.updateFormWebsiteStatus') }}" method="POST">
          @csrf
          <input type="hidden" name="id" value="{{ $item['id'] }}">
          <select name="status" onchange="this.form.submit()">
            <option value="not answered" {{ ($item['status'] ?? '') == 'not answered' ? 'selected':'' }}>Not Answered</option>
            <option value="answered" {{ ($item['status'] ?? '') == 'answered' ? 'selected':'' }}>Answered</option>
          </select>
        </form>
      </td>
    </tr>
    @endforeach
  </table>

  <h2>landing-page-newsletter</h2>
  <table class="table">
    <tr><th>Email</th><th>Name</th></tr>
    @foreach($newsletter as $nl)
    <tr>
      <td>{{ $nl['email'] ?? '' }}</td>
      <td>{{ $nl['name'] ?? '' }}</td>
    </tr>
    @endforeach
  </table>

  <h2>Users</h2>
  <table class="table">
    <tr><th>User ID</th><th>Email</th><th>Action</th></tr>
    @foreach($users as $user)
    <tr>
      <td>{{ $user['id'] ?? '' }}</td>
      <td>{{ $user['email'] ?? '' }}</td>
      <td>
        <form action="{{ route('admin.updateUserPassword') }}" method="POST">
          @csrf
          <input type="hidden" name="userId" value="{{ $user['id'] }}">
          <input type="password" name="newPassword" placeholder="New Password">
          <button type="submit">Change</button>
        </form>
      </td>
    </tr>
    @endforeach
  </table>
</div>
@endsection