<v-card elevation="1" class="user-panel-box">

    <v-card-title class="profile_menu_title">
        @if(array_key_exists('title',$args))
            {{ $args['title'] }}

        @else
            {{ $header }}
        @endif
    </v-card-title>

    <v-card-text>
        {{ $slot }}
    </v-card-text>

</v-card>
