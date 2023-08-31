@props(['tabs', 'centered' => true, 'startPage' => 0])
{{-- tabs should be an array of strings or a dictionary of keys as slot names and values as tab names, each string representing a tab title. --}}
<script src="{{ asset('js/switchable-tabs.js') }}" defer></script>
<div class="tabs">
    <ul class="nav nav-tabs m-2 mt-0 mb-0 {{ $centered ? 'justify-content-center' : '' }}" role="tablist">
        @foreach ($tabs as $name => $title)
            <li class="nav-item" role="presentation">
                <a class="nav-link @if ($loop->index == $startPage) active @endif d-none d-sm-block tab-menu-item"
                    id="tab-{{ $loop->iteration }}-button" data-bs-toggle="tab" href="#tab-{{ $loop->iteration }}"
                    role="tab" aria-controls="tab-{{ $loop->iteration }}"
                    aria-selected="{{ $loop->index == $startPage ? 'true' : 'false' }}">{{ $title }}</a>
            </li>
        @endforeach

        <!-- Dropdown for smaller screens -->
        <li class="nav-item dropdown d-sm-none w-100">
            @php($firstTab = $tabs[0])

            <button id="tab-button" class="dropdown-toggle btn border-secondary w-100" type="button" id="tab-dropdown"
                data-bs-toggle="dropdown" aria-expanded="false">{{ $tabs[$startPage] }}</button>
            <ul class="dropdown-menu w-100" aria-labelledby="tab-dropdown">
                @foreach ($tabs as $name => $title)
                    <li>
                        <a class="dropdown-item nav-link" href="#tab-{{ $loop->iteration }}" data-bs-toggle="tab"
                            id="tab-{{ $loop->iteration }}-button" role="tab">{{ $title }}</a>
                    </li>
                @endforeach
            </ul>
        </li>
    </ul>
    <div class="tab-content">
        @foreach ($tabs as $name => $title)
            <div class="tab-pane fade @if ($loop->index == $startPage) show active @endif"
                id="tab-{{ $loop->iteration }}" role="tabpanel" aria-labelledby="tab-{{ $loop->iteration }}-button"
                data-tab-name="{{ $tabs[$loop->iteration - 1] }}">
                @php($slotName = is_numeric($name) ? 'slot_' . $name : $name)
                {{ ${$slotName} }}
            </div>
        @endforeach
    </div>
</div>
