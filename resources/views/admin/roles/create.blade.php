@extends('admin.layouts.app')

@section('title')
{{ __('Add new role') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Roles') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Add new role') }}</h4> <br>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible show fade">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            {{ __(session('status')) }}
                          </div>
                        </div>
                    @endif
                    <form action="{{ route('roles.store') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Name') }}</label>
                            <div class="col-sm-9">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label for="inputEmail" class="control-label">{{ __('Permissions') }}</label>
                                
                                <div class="custom-checkbox custom-control">
                                    <input type="checkbox" id="permission" class="custom-control-input minimal"
                                    >
                                    <label for="permission" class="custom-control-label">{{ __('Check all') }}</label>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                @php
                                    $permissionsArray = array();
                                @endphp
                                @foreach ($permissions as $permission)
            
                                    @if (!in_array(explode(' ', $permission->name)[1], $permissionsArray))
                                        
                                        <div class="check-all-container">
                                        <div style="clear: both;"></div>
                                        <b>{{ ucfirst(explode(' ', $permission->name)[1]) }}:</b> <br>
                                        <div class="row">
                                            @foreach ($permissions as $permission2)
                
                                                @if (explode(' ', $permission->name)[1] === explode(' ', $permission2->name)[1])
                
                                                <div class="col-sm-4">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" id="permission-{{ $loop->index+1 }}" class="custom-control-input minimal" name="permissions[]" value="{{ $permission2->id }}"
                                                        > 
                                                        <label for="permission-{{ $loop->index+1 }}" class="custom-control-label">{{ $permission2->name }}</label>
                                                    </div>
                                                </div>
                
                                                @endif
                
                                            @endforeach
                                        </div>
                                        </div>
                                        
                                        @php
                                            $permissionsArray[] = explode(' ', $permission->name)[1];
                                        @endphp
            
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-warning btn-block">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('js')
<script>
    $("input#permission").on('change', function(e) {
        if ($(this).prop('checked')) {
            $("input[type=checkbox]").attr('checked', true)
        } else {
            $("input[type=checkbox]").attr('checked', false)
        }
    })
</script>
@endsection