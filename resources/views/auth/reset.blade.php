 @extends('layouts.auth')
 @section('content')
     <div class="row justify-content-center mt-5">
         <div class="col-md-6">
             @if ($errors->any())
                 <div class="alert alert-danger">
                     <ul>
                         @foreach ($errors->all() as $item)
                             <li>{{ $item }}</li>
                         @endforeach
                     </ul>

                 </div>
             @endif
             @if (session()->has('status'))
                 <div class="alert alert-success">
                     {{ session()->get('status') }}

                 </div>
             @endif
             <div class="card">
                 <div class="card-header">
                     Reset Password
                 </div>
                 <div class="card-body">
                     <form action="{{ route('password.update') }}" method="POST">
                         @csrf
                         <input type="hidden" name="token" value="{{ request()->token }}">
                         <input type="hidden" name="email" value="{{ request()->email }}">
                         <div class="form-group mt-3">
                             <label for="new_password">New Password:</label>
                             <input type="password" class="form-control" id="new_password" placeholder="Enter new password"
                                 name="password">
                         </div>
                         <div class="form-group mt-3">
                             <label for="confirm_password">Confirm Password:</label>
                             <input type="password" class="form-control" id="confirm_password"
                                 placeholder="Confirm new password" name="password_confirmation">
                         </div>
                         <button type="submit" class="btn btn-primary mt-3">Reset</button>
                     </form>

                 </div>
             </div>

         </div>
     </div>
 @endsection
