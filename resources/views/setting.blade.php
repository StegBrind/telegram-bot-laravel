@extends('layouts.app')

@section('content')
    <div class="container">

        @if (Session::has('show_info'))
            <div class="alert alert-info">
                <span>{{ Session::get('show_info') }}</span>
            </div>
        @endif
        <form action="/setting/apply" method="POST">
            @csrf
            <input type="hidden" name="type" value="webhook">
            <div class="form-group">
                <label>Webhook settings for Telegram server</label>
                <div class="input-group">
                    <div class="input-group-btn">
                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Select <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#" onclick="document.getElementById('url_webhook').style.display = this.style.display == 'block' ? 'none' : 'block'">Type webhook url</a>
                            </li>
                            <li>
                                <a href="/setting/show/webhook">Show webhook info</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <input type="url" class="form-control" id="url_webhook" name="url_webhook" value="{{ $url_webhook ?? '' }}" style="display: none">
                <br><input type="submit" class="btn btn-info" value="Save">
            </div>
        </form>
    </div>
@endsection
