<div class="row">
    <div class="col-xs-12 col-sm-8">
        {!! Inputs::text('full_name', 'Full name *', 100) !!}
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
        {!! Inputs::text('phone_number', 'Phone Number *', 25) !!}
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6">
        {!! Inputs::text('identify', 'Identify number', 25) !!}
    </div>
    <div class="col-xs-12 col-sm-6">
        {!! Inputs::date('birthday', 'Birthday', '01/01/2000') !!}
    </div>
</div>
{!! Inputs::text('address', 'Address', 255) !!}
@csrf