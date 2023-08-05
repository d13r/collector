<x-layout>

    <x-slot:head>
        <style>
            @foreach ($targets as $id => $target)
                @if ($target['color'] ?? null)
                    .message[data-target="{{ $id }}"]::first-line {
                        color: {{ $target['color'] }};
                    }
               @endif
            @endforeach
        </style>
        <script defer src="{{ asset_url('main.js') }}"></script>
    </x-slot:head>

    <form action="{{ route('send') }}" class="form" method="post">

        <!-- Message -->
        <div class="message-row">
            <textarea
                autofocus
                class="message"
                name="message"
                placeholder="Collector"
                spellcheck="false"
            >{{ "\n" . request('message') }}</textarea>
        </div>

        <div class="buttons-row">

            <!-- Target -->
            @if (count($targets) > 1)
                <div class="targets">
                    @foreach ($targets as $id => $target)
                        <label class="target">
                            <input
                                @checked(is_current_target($id))
                                accesskey="{{ $target['shortcut'] }}"
                                data-to="{{ json_encode($target['to']) }}"
                                name="target"
                                tabindex="-1"
                                type="radio"
                                value="{{ $id }}"
                            >
                            <span class="target-text">{{ $target['title'] }}</span>
                        </label>
                    @endforeach
                </div>
            @else
                <input type="hidden" name="target" value="{{ current_target() }}">
            @endif

            <!-- Send -->
            <button class="submit button" tabindex="-1">Send</button>

        </div>

        <!-- Confirmation -->
        <div class="confirmation">Message Sent</div>

    </form>

</x-layout>
