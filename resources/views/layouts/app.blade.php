<?php

use App\Models\User;
$user = User::find(2);
//dd($chat->all_users);
//dd($user->all_chats);
?>
@include('header')
<main class="py-4">
    @include('mis.mistake')
    @include('success.success')
    @yield('content')
</main>
<script type="text/javascript">

</script>
</body>
</html>

