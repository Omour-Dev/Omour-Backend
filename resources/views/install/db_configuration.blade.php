@extends('install.layout')

@section('content')

    @if($errors->all())
      <div class="alert alert-danger">
        <ul>
          <a href='#' class="close" data-dismiss="alert" aria-label="close">x</a>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <h2>2. Database Configuration</h2>
    <form method="POST" action="{{ url(route('store.db.configurations')) }}" class="form-horizontal">
        {{ csrf_field() }}
        <div class="box">
            <p>Please enter your database connection details.</p>
            <div class="configure-form">
                <div class="form-group {{ $errors->has('db.host') ? 'has-error': '' }}">
                    <label class="control-label col-sm-3" for="host">Host <span>*</span></label>

                    <div class="col-sm-9">
                        <input type="text" name="db[host]" value="{{ old('db.host', '127.0.0.1') }}" id="host" class="form-control" autofocus>

                        {!! $errors->first('db.host', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('db.port') ? 'has-error': '' }}">
                    <label class="control-label col-sm-3" for="port">Port <span>*</span></label>

                    <div class="col-sm-9">
                        <input type="text" name="db[port]" value="{{ old('db.port', '3306') }}" id="port" class="form-control">

                        {!! $errors->first('db.port', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('db.username') ? 'has-error': '' }}">
                    <label class="control-label col-sm-3" for="db-username">DB Username <span>*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="db[username]" value="{{ old('db.username') }}" id="db-username" class="form-control">

                        {!! $errors->first('db.username', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="db-password">DB Password</label>

                    <div class="col-sm-9">
                        <input type="password" name="db[password]" value="{{ old('db.password') }}" id="db-password" class="form-control">
                    </div>
                </div>

                <div class="form-group {{ $errors->has('db.database') ? 'has-error': '' }}">
                    <label class="control-label col-sm-3" for="database">Database <span>*</span></label>

                    <div class="col-sm-9">
                        <input type="text" name="db[database]" value="{{ old('db.database') }}" id="database" class="form-control">

                        {!! $errors->first('db.database', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="box">
                    <p>Please enter your app details.</p>
                    <div class="configure-form p-b-0">
                        <div class="form-group {{ $errors->has('app.app_name') ? 'has-error': '' }}">
                            <label class="control-label col-sm-3" for="app-name">App Name <span>*</span></label>

                            <div class="col-sm-9">
                                <input type="text" name="app[app_name]" value="{{ old('app.app_name') }}" id="app-name" class="form-control">

                                {!! $errors->first('app.app_name', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="content-buttons clearfix">
            <button type="submit" class="btn btn-primary pull-right install-button">Submit</button>
        </div>
    </form>

@endsection
