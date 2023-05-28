@extends('app')

@php
use App\Models\PasswordType;$types = PasswordType::toSelectArray();
asort($types)
@endphp

@section('content')
@include('system.passwords.passwords-shareds')
@include('system.passwords.passwords-add-groups')
@include('system.passwords.passwords-add-users')

<div id="modal" class="modal modal-blur fade" tabindex="-1" role="dialog" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"></path>
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <form id="form" name="api/passwords" role="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" id="txtId">

                <div class="modal-body py-2">
                    <div class="row">
                        <div class="col-4">
                            <label for="txtNome" class="form-label">{{ __('fields.name') }}</label>
                            <input type="text" class="form-control" name="name" id="txtNome" maxlength="64"
                                   required>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="txtTipo" class="form-label">{{ __('fields.type') }}</label>
                                <select id="txtTipo" class="form-select" name="type" required>
                                    <option></option>
                                    @foreach($types as $index => $type)
                                    <option value="{{ $index }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            @select(['id'=>'txtFolderId', 'name'=>'folder_id', 'label'=>'fields.folder', 'url'=>'/api/folders/compact'])
                        </div>
                    </div>
                </div>
                <div class="modal-body py-2">
                    <div class="row">
                        <div class="col-4 d-none show show-1">
                            <div class="mb-3">
                                <label for="txtApiLiveKey" class="form-label">{{ __('fields.api_key') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="api_live_key" id="txtApiLiveKey"
                                           maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-8 d-none show show-1">
                            <div class="mb-3">
                                <label for="txtApiSecretKey"
                                       class="form-label">{{ __('fields.secret_key') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="api_secret_key"
                                           id="txtApiSecretKey" maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-8 d-none show show-3">
                            <div class="mb-3">
                                <label for="txtFtpServer" class="form-label">{{ __('fields.server') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="ftp_server" id="txtFtpServer"
                                           maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-none show show-3">
                            <div class="mb-3">
                                <label for="txFtpPort" class="form-label">{{ __('fields.port') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="ftp_port" id="txFtpPort"
                                           maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-none show show-3">
                            <div class="mb-3">
                                <label for="txtFtpType" class="form-label">{{ __('fields.type') }}</label>
                                <select class="form-select" id="txtFtpType" name="ftp_type">
                                    <option></option>
                                    <option value="1">FTP</option>
                                    <option value="2">SFTP</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-8 d-none show show-6">
                            <div class="mb-3">
                                <label for="txtDatabaseServer" class="form-label">{{ __('fields.server') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="database_server"
                                           id="txtDatabaseServer" maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 d-none show show-6">
                            <div class="mb-3">
                                <label for="txtDatabasePort" class="form-label">{{ __('fields.port') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="database_port"
                                           id="txtDatabasePort" maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-none show show-6">
                            <div class="mb-3">
                                <label for="txtDatabaseName"
                                       class="form-label">{{ __('fields.database_name') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="database_name"
                                           id="txtDatabaseName" maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-none show show-6">
                            <div class="mb-3">
                                <label for="txtDatabaseAlias" class="form-label">{{ __('fields.alias') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="database_alias"
                                           id="txtDatabaseAlias" maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-8 d-none show show-4 show-5">
                            <div class="mb-3">
                                <label for="txtEmail" class="form-label">E-mail</label>
                                <div class="input-group input-group-flat">
                                    <input type="email" class="form-control" name="email" id="txtEmail"
                                           maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 d-none show show-4">
                            <div class="mb-3">
                                <label for="txtMailType" class="form-label">{{ __('fields.mail_type') }}</label>
                                <select class="form-select" id="txtMailType" name="mail_type">
                                    <option></option>
                                    <option value="1">IMAP</option>
                                    <option value="2">POP3</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6 d-none show show-2 show-3 show-4 show-6 show-7">
                            <div class="mb-3">
                                <label for="txtUsername" class="form-label">{{ __('fields.username') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="username" id="txtUsername"
                                           maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-none show show-2 show-3 show-4 show-6 show-7">
                            <div class="mb-3" id="pwd-container">
                                <label for="txtPassword" class="form-label">{{ __('fields.password') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="password" class="form-control" name="password" id="txtPassword"
                                           maxlength="160" required>
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary" id="generatePassword"
                                               title="" data-toggle="tooltip" data-original-title="Gerar senha"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><path
                                                        d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -5v5h5"></path><path
                                                        d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 5v-5h-5"></path></svg></a>
                                            <a href="javascript:void(0)" class="link-secondary ml-2" id="showPassword"
                                               title="" data-toggle="tooltip" data-original-title="Exibir senha"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><circle
                                                        cx="12" cy="12" r="2"></circle><path
                                                        d="M2 12l1.5 2a11 11 0 0 0 17 0l1.5 -2"></path><path
                                                        d="M2 12l1.5 -2a11 11 0 0 1 17 0l1.5 2"></path></svg></a>
                                            <a href="javascript:void(0)" class="link-secondary copy ml-2" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="pwstrength_viewport_progress"></div>
                                    </div>
                                </div>
                            </div>

                        <div class="col-6 d-none show show-4">
                            <div class="mb-3">
                                <label for="txtMailIncomingServer"
                                       class="form-label">{{ __('fields.incoming_server') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="mail_incoming_server"
                                           id="txtMailIncomingServer" maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-none show show-4">
                            <div class="mb-3">
                                <label for="txtMailIncomingPort" class="form-label">{{ __('fields.port') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="mail_incoming_port"
                                           id="txtMailIncomingPort" maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-none show show-4">
                            <div class="mb-3">
                                <label for="txtMailIncomingProtocol"
                                       class="form-label">{{ __('fields.protocol') }}</label>
                                <select class="form-select" id="txtMailIncomingProtocol"
                                        name="mail_incoming_protocol">
                                    <option></option>
                                    <option value="1">SSL</option>
                                    <option value="2">TLS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2 d-none show show-4">
                            <div class="mb-3">
                                <label for="txtMailIncomingAuthentication"
                                       class="form-label">{{ __('fields.authentication') }}</label>
                                <select class="form-select" id="txtMailIncomingAuthentication"
                                        name="mail_incoming_authentication">
                                    <option></option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6 d-none show show-4">
                            <div class="mb-3">
                                <label for="txtMailOutgoingServer"
                                       class="form-label">{{ __('fields.outgoing_server') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="mail_outgoing_server"
                                           id="txtMailOutgoingServer" maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-none show show-4">
                            <div class="mb-3">
                                <label for="txtMailOutgoingPort" class="form-label">{{ __('fields.port') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="mail_outgoing_port"
                                           id="txtMailOutgoingPort" maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-none show show-4">
                            <div class="mb-3">
                                <label for="txtMailOutgoingProtocol"
                                       class="form-label">{{ __('fields.protocol') }}</label>
                                <select class="form-select" id="txtMailOutgoingProtocol"
                                        name="mail_outgoing_protocol">
                                    <option></option>
                                    <option value="1">SSL</option>
                                    <option value="2">TLS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2 d-none show show-4">
                            <div class="mb-3">
                                <label for="txtMailOutgoingAuthentication"
                                       class="form-label">{{ __('fields.authentication') }}</label>
                                <select class="form-select" id="txtMailOutgoingAuthentication"
                                        name="mail_outgoing_authentication">
                                    <option></option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-4 d-none show show-5">
                            <div class="mb-3">
                                <label for="txtLicenseTo" class="form-label">{{ __('fields.license_to') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="license_to" id="txtLicenseTo"
                                           maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 d-none show show-5">
                            <div class="mb-3">
                                <label for="txtLicenseCompany" class="form-label">{{ __('fields.company') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="license_company"
                                           id="txtLicenseCompany" maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 d-none show show-5">
                            <div class="mb-3">
                                <label for="txtLicenseVersion"
                                       class="form-label">{{ __('fields.license_version') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="license_version"
                                           id="txtLicenseVersion" maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 d-none show show-5">
                            <div class="mb-3">
                                <label for="txtLicenseKey" class="form-label">{{ __('fields.license_key') }}</label>
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control" name="license_key" id="txtLicenseKey"
                                           maxlength="64">
                                    <span class="input-group-text">
                                            <a href="javascript:void(0)" class="link-secondary copy" title=""
                                               data-toggle="tooltip" data-original-title="Copy"><svg
                                                    xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round"><path stroke="none"
                                                                                  d="M0 0h24v24H0z"></path><rect x="8"
                                                                                                                 y="8"
                                                                                                                 width="12"
                                                                                                                 height="12"
                                                                                                                 rx="2"></rect><path
                                                        d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path></svg></a>
                                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-none show show-4 show-5 show-7">
                            <div class="mb-3">
                                <label for="txtUrl" class="form-label">URL</label>
                                <input type="url" class="form-control" name="url" id="txtUrl" maxlength="255">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body py-2">
                    <div class="row">
                        <div class="col-12">
                            <label for="txtNotes" class="form-label">{{ __('fields.notes') }}</label>
                            <textarea class="form-control" name="notes" id="txtNotes"
                                      maxlength="10000"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-white w-xs mr-auto" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary w-xs">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row flex-fill">

    <div class="w-75 pl-0">
        <div class="card m-0">
            <table id="table" class="table table-vcenter card-table border-top table-hover">
            </table>
        </div>
    </div>
    <div class="w-25 d-flex flex-column">
        <div class="dropdown-menu dropdown-menu-demo h-100 m-0 border-0"
             style="box-shadow: none;min-height: 500px;background-color: transparent;">
            <h6 class="dropdown-header">Filters</h6>
            <label class="dropdown-item"><input class="form-check-input m-0 mr-2 filterBy" type="radio" name="filter_by" value="all"
                                                checked>All</label>
            <label class="dropdown-item"><input class="form-check-input m-0 mr-2 filterBy" type="radio" name="filter_by" value="favorites">Favoritesㅤ<i class="fa-solid fa-heart"> </i></label>
            <label class="dropdown-item"><input class="form-check-input m-0 mr-2 filterBy" type="radio" name="filter_by" value="my_passwords">My passwordsㅤ<i class="fa-solid fa-key"></i></label>
            <label class="dropdown-item"><input class="form-check-input m-0 mr-2 filterBy" type="radio" name="filter_by" value="shareds_passwords">Shared with me ㅤ<i class="fa-solid fa-people-group"></i></label>



            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Filter by type</h6>
            @foreach($types as $index => $type)
            <label class="dropdown-item"><input class="form-check-input m-0 mr-2 filterByType" type="checkbox"
                                                data-id="{{ $index }}">{{ $type }}</label>
            @endforeach

            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Filter by folder</h6>
            <div id="filterByFolder"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $.getScript("{{ asset($assets . '/js/passwords.js?') . $version }}");
</script>
@endsection
