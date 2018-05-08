<div class="row">
    <div class="col-xs-12 col-sm-8">
        {!! Inputs::text('name', 'name *', 100) !!}
    </div>
    <div class="col-xs-12 col-sm-4">
        {!! Inputs::status('status', 'Status *') !!}
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-8">
        {!! Inputs::text('email', 'Email *', 100) !!}
    </div>
    <div class="col-xs-12 col-sm-4">
        {!! Inputs::role('role', 'role *', 25) !!}
    </div>
</div>

<div class="row">
     <div class="col-xs-12 col-sm-8">
        {!! Inputs::password('password', 'Password *', 100) !!}
    </div>
    <div class="col-xs-12 col-sm-4">
        {!! Inputs::resource_id('resource_id', 'Resource name *', 25) !!}
    </div>
</div>
@csrf