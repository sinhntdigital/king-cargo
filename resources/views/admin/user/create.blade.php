@extends("layouts.bo-layout")
@section("content") 
    <form class="m-login__form m-form" action="{{ route('user.store') }}" method="post">
    	{!! csrf_field() !!}
        <div class="form-group m-form__group">
            <input class="form-control m-input" type="text" placeholder="Nick name" name="name" required="">
        </div>
        <div class="form-group m-form__group">
            <input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off" required="">
        </div>
        <div class="form-group m-form__group">
            <input class="form-control m-input" type="password" placeholder="Password" name="password" required="">
        </div>
        
        <div class="form-group m-form__group">
            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="password_confirmation" required="">
        </div>

        <div class="form-group m-form__group">
         	<select class="form-control m-input" name="resources" required="true">
         		<option>select</option>
         		@foreach (\App\Models\Resource::all() as $resource)
         			<option value="{{$resource->id}}">
         				{{$resource->full_name}}
         			</option>
         		@endforeach
         	</select>
        </div>

        <div class="form-group m-form__group">
         	<select class="form-control m-input" name="role" required="true">
         		<option>select role</option>
         		<option value="admin">Admin</option>
         		<option value="accountant">accountant</option>
         		<option value="customer">customer</option>
         	</select>
        </div>
        <div class="m-login__form-action">
            <button id="m_login_signup_submit" class="btn btn-brand m-btn m-btn--pill m-btn--custom m-btn--air">Create</button>
        </div>
    </form>
@endsection