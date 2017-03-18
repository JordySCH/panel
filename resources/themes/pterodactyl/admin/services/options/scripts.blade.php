{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- Permission is hereby granted, free of charge, to any person obtaining a copy --}}
{{-- of this software and associated documentation files (the "Software"), to deal --}}
{{-- in the Software without restriction, including without limitation the rights --}}
{{-- to use, copy, modify, merge, publish, distribute, sublicense, and/or sell --}}
{{-- copies of the Software, and to permit persons to whom the Software is --}}
{{-- furnished to do so, subject to the following conditions: --}}

{{-- The above copyright notice and this permission notice shall be included in all --}}
{{-- copies or substantial portions of the Software. --}}

{{-- THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR --}}
{{-- IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, --}}
{{-- FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE --}}
{{-- AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER --}}
{{-- LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, --}}
{{-- OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE --}}
{{-- SOFTWARE. --}}
@extends('layouts.admin')

@section('title')
    Services &rarr; Option: {{ $option->name }} &rarr; Scripts
@endsection

@section('content-header')
    <h1>{{ $option->name }}<small>Manage install and upgrade scripts for this service option.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.services') }}">Services</a></li>
        <li><a href="{{ route('admin.services.view', $option->service->id) }}">{{ $option->service->name }}</a></li>
        <li class="active">{{ $option->name }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom nav-tabs-floating">
            <ul class="nav nav-tabs">
                <li><a href="{{ route('admin.services.option.view', $option->id) }}">Configuration</a></li>
                <li><a href="{{ route('admin.services.option.variables', $option->id) }}">Variables</a></li>
                <li class="active"><a href="{{ route('admin.services.option.scripts', $option->id) }}">Scripts</a></li>
            </ul>
        </div>
    </div>
</div>
<form action="{{ route('admin.services.option.scripts', $option->id) }}" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Install Script</h3>
                </div>
                <div class="box-body no-padding">
                    <div id="editor_install"style="height:300px">{{ $option->script_install }}</div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Upgrade Script</h3>
                </div>
                <div class="box-body no-padding">
                    <div id="editor_upgrade"style="height:300px">{{ $option->script_upgrade }}</div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <textarea name="script_install" class="hidden"></textarea>
                    <textarea name="script_upgrade" class="hidden"></textarea>
                    <button type="submit" class="btn btn-primary btn-sm pull-right">Save Scripts</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/vendor/ace/ace.js') !!}
    {!! Theme::js('js/vendor/ace/ext-modelist.js') !!}
    <script>
    $(document).ready(function () {
        const InstallEditor = ace.edit('editor_install');
        const UpgradeEditor = ace.edit('editor_upgrade');

        const Modelist = ace.require('ace/ext/modelist')

        InstallEditor.setTheme('ace/theme/chrome');
        InstallEditor.getSession().setMode('ace/mode/sh');
        InstallEditor.getSession().setUseWrapMode(true);
        InstallEditor.setShowPrintMargin(false);

        UpgradeEditor.setTheme('ace/theme/chrome');
        UpgradeEditor.getSession().setMode('ace/mode/sh');
        UpgradeEditor.getSession().setUseWrapMode(true);
        UpgradeEditor.setShowPrintMargin(false);

        $('form').on('submit', function (e) {
            $('textarea[name="script_install"]').val(InstallEditor.getValue());
            $('textarea[name="script_upgrade"]').val(UpgradeEditor.getValue());
        });
    });
    </script>
@endsection
