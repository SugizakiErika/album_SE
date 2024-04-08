@extends('adminlte::page')
    @section('title', '設定画面')
    @section('content_header')
    @stop
    @section('content')
    <div class="info-box">
        <span class="info-box-icon bg-info"><i class="fas fa-fw fa-user"></i></span>
            <div class="info-box-content">
                @include('profile.partials.update-profile-information-form')
            </div>
    </div>
    <div class="info-box">
        <span class="info-box-icon bg-success"><i class="fas fa-solid fa-dragon"></i></span>
            <div class="info-box-content">
                @include('profile.partials.update-password-form')
            </div>
    </div>
    <div class="info-box">
        <span class="info-box-icon bg-danger"><i class="fas fa-solid fa-cannabis"></i></span>
            <div class="info-box-content">
                @include('profile.partials.delete-user-form')
            </div>
    </div>
    @stop
