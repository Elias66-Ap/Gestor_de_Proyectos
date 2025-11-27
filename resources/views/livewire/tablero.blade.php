<div>
    <div class="btn-group w-100" role="group">
        @foreach ([
            "Por hacer" => "📝 Por hacer",
            "En proceso" => "⚙️ En proceso",
            "Revision" => "🔍 Revisión",
            "Hecho" => "✅ Hecho"
        ] as $value => $label)

            <input type="radio"
                   class="btn-check"
                   id="radio-{{ $value }}"
                   value="{{ $value }}"
                   wire:click="actualizarEstado('{{ $value }}')"
                   @checked($estado === $value)
            >

            <label class="btn
                @if($estado === $value)
                    btn-primary
                @else
                    btn-outline-secondary
                @endif
            " for="radio-{{ $value }}">
                {{ $label }}
            </label>

        @endforeach
    </div>
</div>
