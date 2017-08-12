@extends('layouts.tracking')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="margin-top:100px">
            <div class="panel panel-default">
                <div class="panel-heading">Rastrear</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/get_tracking">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                         @if (session('code'))
                        <div class="alert alert-danger" role="alert">Código incorrecto</div>
                        @endif
                            <label for="email" class="col-md-4 control-label">código de rastreo</label>

                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control" name="code" value="{{ old('email') }}" required autofocus>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Enviar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
