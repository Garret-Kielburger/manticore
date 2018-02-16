@extends('templates.default')


@section('content')
    <div style="padding-left:20%">
    <h3>Update your Profile</h3>
    <div class="row">
        <div class="col-lg-6">
            <form class="form-vertical" role="form" method="post" action="{{ route('profile.edit', Auth::user()->username) }}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : "" }}">
                            <label for="first_name" class="control-label">First name</label>
                            <input type="text" name="first_name" class="form-control" id="first_name" value="{{ Request::old('first_name') ?: Auth::user()->first_name }}">
                            @if ($errors->has('first_name'))
                                <span class="help-block">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : "" }}">
                            <label for="last_name" class="control-label">Last name</label>
                            <input type="text" name="last_name" class="form-control" id="last_name" value="{{Request::old('last_name') ?: Auth::user()->last_name }}">
                            @if ($errors->has('last_name'))
                                <span class="help-block">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('street_number') ? ' has-error' : "" }}">
                            <label for="street_number" class="control-label">Street No.</label>
                            <input type="text" name="street_number" class="form-control" id="street_number" value="{{  Request::old('street_number') ?: Auth::user()->street_number }}">
                            @if ($errors->has('street_number'))
                                <span class="help-block">{{ $errors->first('street_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('street_name') ? ' has-error' : "" }}">
                            <label for="street_name" class="control-label">Street Name</label>
                            <input type="text" name="street_name" class="form-control" id="street_name" value="{{  Request::old('street_name') ?: Auth::user()->street_name }}">
                            @if ($errors->has('street_name'))
                                <span class="help-block">{{ $errors->first('street_name') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('province_or_state') ? ' has-error' : "" }}">
                            <label for="province_or_state" class="control-label">Province/State</label>
                            <input type="text" name="province_or_state" class="form-control" id="province_or_state" value="{{  Request::old('province_or_state') ?: Auth::user()->province_or_state }}">
                            @if ($errors->has('province_or_state'))
                                <span class="help-block">{{ $errors->first('province_or_state') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('postal_or_zip_code') ? ' has-error' : "" }}">
                            <label for="postal_or_zip_code" class="control-label">Postal/Zip Code</label>
                            <input type="text" name="postal_or_zip_code" class="form-control" id="postal_or_zip_code" value="{{  Request::old('postal_or_zip_code') ?: Auth::user()->postal_or_zip_code }}">
                            @if ($errors->has('postal_or_zip_code'))
                                <span class="help-block">{{ $errors->first('postal_or_zip_code') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group{{ $errors->has('country_code') ? ' has-error' : "" }}">
                                <label for="country_code" class="control-label">Country</label>
                                <input type="text" name="country_code" class="form-control" id="country_code" value="{{  Request::old('country_code') ?: Auth::user()->country_code }}">
                                @if ($errors->has('country_code'))
                                    <span class="help-block">{{ $errors->first('country_code') }}</span>
                                @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
@stop