@extends('layouts.app')

@section('title', 'Profil - AEMS')
@section('page-title', 'Mon Profil')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="aems-card p-6">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="aems-card p-6">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="aems-card p-6">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
