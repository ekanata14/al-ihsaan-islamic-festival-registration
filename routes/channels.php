<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Channel privat untuk realtime. Data pendaftaran mengandung NIK/alamat,
| jadi semua channel bersifat private dan diotorisasi berbasis role/pemilik.
|
*/

Broadcast::channel('admin', fn (User $user) => $user->role === 'admin');

Broadcast::channel('user.{id}', fn (User $user, $id) => (int) $user->id === (int) $id);
